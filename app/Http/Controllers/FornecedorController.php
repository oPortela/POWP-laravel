<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFornecedorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FornecedorController extends Controller
{
    private $supabaseUrl;
    private $supabaseKey;
    
    public function __construct()
    {
        $this->supabaseUrl = config('app.supabase_url', env('SUPABASE_URL'));
        $this->supabaseKey = config('app.supabase_key', env('SUPABASE_KEY'));
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //Parametro de paginação
            $perPage = $request->input('perPage', 10);
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $perPage;

            //Variaveis de consulta
            $selectQuery = '*,pwendereco(*),pwtelefone(*)';
            $orderBy = 'codfornecedor.asc';

            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
                'select' => $selectQuery,
                'order' => $orderBy,
                'offset' => $offset,
                'limit' => $perPage,
            ]);

            $response->throw();
            $data = $response->json();

            //Segunda chamada
            $countResponse = Http::withHeaders([
                'apikey'        => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept'        => 'application/json',
                'Prefer'        => 'count=exact' 
            ])    
            ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
                'select' => 'codfornecedor', 
                'limit'  => 1 
            ]);

            $range = $countResponse->header('Content-Range');
            $total = (int) explode('/', $range)[1];


            return response()->json([
                'data' => $data,
                'total' => $total
            ], 200);

        } catch (\Exception $e) {
            Log::error('Falha ao buscar fornecedores no Supabase: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar dados no Supabase.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function postToSupabase(string $table, array $data) 
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation',
        ])
        ->post($this->supabaseUrl . '/rest/v1/' . $table, $data);

        $response->throw();

        return $response->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFornecedorRequest $request)
    {
        $data = $request->validated();

        try {
            $enderecoResponse = $this->postToSupabase('pwendereco', [
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'cep' => $data['cep'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
            ]);

            //Pego meu Id 
            $codEndereco = $enderecoResponse[0]['codendereco'];

            $telefoneResponse = $this->postToSupabase('pwtelefone', [
                'telefone' => $data['telefone'],
                'celular' => $data['celular'],
            ]);

            $codTelefone = $telefoneResponse[0]['codtelefone'];

            $fornecedorResponse = $this->postToSupabase('pwfornecedor', [
                'fornecedor' => $data['fornecedor'],
                'fantasia' => $data['fantasia'] ?? '',
                'cnpj' => $data['cnpj'],
                'email' => $data['email'],
                'dtcadastro' => now()->format('Y-m-d'),
                'codendereco' => $codEndereco,
                'codtelefone' => $codTelefone,
                //'codrepresentante' => $data['codrepresentante'] ?? '',
            ]);

            return response()->json($fornecedorResponse[0], 201);
        } catch (\Exception $e) {
            Log::error('Falha ao salvar fornecedor no Supabase: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao salvar dados no Supabase.',
                'error' => $e->getMessage()
            ], 500);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $codfornecedor)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
                'select' => '*, pwendereco(*), pwtelefone(*)',
                'codfornecedor' => 'eq. ' . $codfornecedor,
                'limit' => 1
            ]);

            $response->throw();
            $data = $response->json();

            if(empty($data)) {
                return response()->json([
                    'message' => 'Fornecedor não encontrado.'
                ], 404);
            }

            return response()->json($data[0], 200);

        } catch (\Exception $e) {
            Log::error('Falha ao buscar fornecedor no Supabase: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar dados no Supabase.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    private function patchToSupabase(string $table, string $column, string $id, array $data)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' =>'Bearer ' . $this->supabaseKey,
            'Content-Type' => 'application/json',
            'Prefer' => 'return=representation'
        ])
        ->patch($this->supabaseUrl . '/rest/v1/' . $table . '?' . $column . '=eq.' . $id, $data);

        $response->throw();
        return $response->json();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFornecedorRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $supplier = $this->findSupplierById($id);
            if(!$supplier) {
                return response()->json([
                    'message' => 'Fornecedor não encontrado.'
                ], 404);
            }

            $this->patchToSupabase('pwendereco', 'codendereco', $supplier['codendereco'], [
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'cep' => $data['cep'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
            ]);

            $this->patchToSupabase('pwtelefone', 'codtelefone', $supplier['codtelefone'], [
                'telefone' => $data['telefone'],
                'celular' => $data['celular'],
            ]);

            $updatedSupplier = $this->patchToSupabase('pwfornecedor', 'codfornecedor', $id, [
                'fornecedor' => $data['fornecedor'],
                'fantasia' => $data['fantasia'],
                'cnpj' => preg_replace('/\D/', '', $data['cnpj']),
                'email' => $data['email'],
            ]);

            return response()->json($updatedSupplier[0], 200);

        } catch (\Exception $e) {
            Log::error('Falha ao atualizar o fornecedor: ') . $e->getMessage();
            return response()->json([
                'message' => 'Erro ao salvar os dados.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Função auxiliar para deletar registros
    private function deleteFromSupabase(string $table, string $column, string $id)
    {
        $url = "{$this->supabaseUrl}/rest/v1/{$table}?{$column}=eq.{$id}";

        Log::info('Requisição DELETE Supabase', ['url' => $url]);

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($url);

        Log::info('Resposta Supabase', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        $response->throw();

        return $response;
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $codfornecedor)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
                'select' => 'codendereco, codtelefone',
                'codfornecedor' => 'eq.' . $codfornecedor,
                'limit' => 1
            ]);

            $response->throw();
            $supplierData = $response->json();

            if(empty($supplierData)) {
                return response()->json([
                    'message' => 'Forncecedor não encontrado.'
                ], 404);
            }

            $codEndereco = $supplierData[0]['codendereco'];
            $codTelefone = $supplierData[0]['codtelefone'];

            $this->deleteFromSupabase('pwfornecedor', 'codfornecedor', $codfornecedor);

            $this->deleteFromSupabase('pwtelefone', 'codtelefone', $codTelefone);

            $this->deleteFromSupabase('pwendereco', 'codendereco', $codEndereco);

            return response()->json(null, 204);

        } catch(\Exception $e) {
            Log::error('Falha ao excluir o fornecedor no Banco: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao excluir o fornecedor no Supabase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function findSupplierById(string $id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Accept' => 'application/json',
        ])
        ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
            'select' => 'codendereco, codtelefone',
            'codfornecedor' => 'eq.' . $id,
            'limit' => 1
        ]);

        $response->throw();
        $data = $response->json();
        return empty($data) ? null : $data[0];
    }
}
