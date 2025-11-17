<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class ClienteController extends Controller
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
            $perPage = $request->input('perPage', 10);
            $page = $request->input('page', 1);
            $offset = ($page - 1) * $perPage;

            $selectQuery = '*, pwenrecedo(*), pwtelefone(*), pwclientefisico(*), pwclientejuridico(*)';
            $orderBy = 'codcliente.asc';

            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwcliente', [
                'select' => $selectQuery,
                'order' => $orderBy,
                'offset' => $offset,
                'limit' => $perPage,
            ]);

            $response->throw();
            $data = $response->json();

            $countResponse = Http::withHeaders([
                'apikey'        => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept'        => 'application/json',
                'Prefer'        => 'count=exact' 
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwcliente', [
                'select' => 'codcliente',
                'limit' => 1
            ]);

            $range = $countResponse->header('Content-Range');
            $total = (int) explode('/', $range)[1];

            return response()->json([
                'data' => $data,
                'total' => $total
            ], 200);

        } catch(\Exception $e) {
            Log::error('Falha ao buscar clientes no Supabase: ' . $e->getMessage());
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
        ])->post($this->supabaseUrl . '/rest/v1/' . $table, $data);

        $response->throw();

        return $response->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
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

            //Pego o meu ID
            $codEndereco = $enderecoResponse[0]['codendereco'];

            $telefoneResponse = $this->postToSupabase('pwtelefone', [
                'telefone' => $data['telefone'],
                'celular' => $data['celular'],
            ]);

            $codTelefone = $telefoneResponse[0]['codtelefone'];

            $clientResponse = $this->postToSupabase('pwcliente', [
                'cliente' => $data['cliente'],
                'fantasia' => $data['fantasia'] ?? '',
                'dtcadastro' => now()->format('Y-m-d'),
                'tipopessoa' => $data['tipopessoa'],
                'email' => $data['email'],
                'codendereco' => $codEndereco,
                'codtelefone' => $codTelefone,
                'obs' => $data['obs'] ?? '',
                'bloqueio' => $data['bloqueio'] ?? 'N',
                'motivo_bloq' => $data['motivo_bloq'] ?? ''
            ]);

            $codCliente = $clientResponse[0]['codcliente'];

            if ($data['tipopessoa'] == 'F') {
                $clienteFisicoResponse = $this->postToSupabase('pwclientefisico', [
                    'codcli' => $codCliente,
                    'cpf' => $data['cpf'],
                    'rg' => $data['rg'],
                    'dt_nascimento' => $data['dt_nascimento'],
                ]);
            } elseif ($data['tipopessoa'] == 'J') {
                $clienteJuridicoResponse = $this->postToSupabase('pwclientejuridico', [
                    'codcli' => $codCliente,
                    'cnpj' => $data['cnpj'],
                    'inscricaoestadual' => $data['inscricaoestadual'],
                    'dtabertura' => $data['dtabertura'],
                ]);
            } else {
                return response()->json([
                    'message' => 'Tipo de pessoa inválido'
                ], 400);
            }

            return response()->json([
                $clientResponse[0],
            ], 201);

        } catch (\Exception $e) {
            Log::error('Falha ao salvar cliente no Supabase: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao salvar dados no Supabase.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $codcliente)
    {
        try {
            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwcliente', [
                'select' => '*, pwendereco(*), pwtelefone(*), pwclientefisico(*), pwclientejuridico(*)',
                'codcliente' => 'eq.' . $codcliente,
                'limit' => 1
            ]);

            $response->throw();
            $data = $response->json();

            if (empty($data)) {
                return response()->json([
                    'message' => 'Cliente não encontrado'
                ], 404);
            }

            $cliente = $data[0];

            if (!empty($cliente['pwclientefisico'])) {
                $cliente['pwclientefisico'] = $cliente['pwclientefisico'][0];
            }

            if (!empty($cliente['pwclientejuridico'])) {
                $cliente['pwclientejuridico'] = $cliente['pwclientejuridico'][0];
            }

            return response()->json($cliente, 200);

        } catch (\Exception $e) {
            Log::error('Falha ao buscar o cliente no Supabase: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao buscar dados no Supabase',
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
    public function update(Request $request, string $id)
    {
        $data = $request->all();

        try {
            $client = $this->findClientById($id);
            if (!$client) {
                return response()->json([
                    'message' => 'Cliente não encontrado'
                ], 404);
            }

            $this->patchToSupabase('pwendereco', 'codendereco', $client['codendereco'], [
                'logradouro' => $data['logradouro'],
                'numero' => $data['numero'],
                'cep' => $data['cep'],
                'bairro' => $data['bairro'],
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
            ]);

            $this->patchToSupabase('pwtelefone', 'codtelefone', $client['codtelefone'], [
                'telefone' => $data['telefone'],
                'celular' => $data['celular'],
            ]);

            $clientUpdated = $this->patchToSupabase('pwcliente', 'codcliente', $id, [
                'cliente' => $data['cliente'],
                'fantasia' => $data['fantasia'] ?? '',
                'tipopessoa' => $data['tipopessoa'],
                'email' => $data['email'],
                'obs' => $data['obs'] ?? '',
                'bloqueio' => $data['bloqueio'] ?? 'N',
                'motivo_bloq' => $data['motivo_bloq'] ?? ''
            ]);

            if ($data['tipopessoa'] == 'F') {
                $this->patchToSupabase('pwclientefisico', 'codcli', $id, [
                    'cpf' => $data['cpf'],
                    'rg' => $data['rg'],
                    'dt_nascimento' => $data['dt_nascimento'],
                ]);
            } elseif ($data['tipopessoa'] == 'J') {
                $this->patchToSupabase('pwclientejuridico', 'codcli', $id, [
                    'cnpj' => $data['cnpj'],
                    'inscricaoestadual' => $data['inscricaoestadual'],
                    'dtabertura' => $data['dtabertura'],
                ]);
            } else {
                return response()->json([
                    'message' => 'Tipo de pessoa inválido'
                ], 400);
            }

            return response()->json([
                $clientUpdated[0],
            ], 200);

        } catch (\Exception $e) {
            Log::error('Falha ao atualizar o cliente: ') . $e->getMessage();
            return response()->json([
                'message' => 'Erro ao salvar os dados.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function deleteFromSupabase(string $table, string $column, string $id)
    {
        $url = "{$this->supabaseUrl}/rest/v1/{$table}?{$column}=eq.{$id}";

        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
        ])->delete($url);

        Log::info('Retorno Supabase: ', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        $response->throw();

        return response()->json([
            'message' => 'Cliente deletado com sucesso'
        ], 204);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $codcliente)
    {
        try {
            $cliente = $this->findClientById($codcliente);
            if (!$cliente) {
                return response()->json([
                    'message' => 'Cliente não encontrado'
                ], 404);
            }

            $codendereco = $cliente['codendereco'];
            $codtelefone = $cliente['codtelefone'];
            $tipoPessoa = $cliente['tipopessoa'];

            if ($tipoPessoa == 'F') {
                $this->deleteFromSupabase('pwclientefisico', 'codcli', $codcliente);
                $this->deleteFromSupabase('pwcliente', 'codcliente', $codcliente);
                $this->deleteFromSupabase('pwendereco', 'codendereco', $codendereco);
                $this->deleteFromSupabase('pwtelefone', 'codtelefone', $codtelefone);
            } elseif ($tipoPessoa == 'J') {
                $this->deleteFromSupabase('pwclientejuridico', 'codcli', $codcliente);
                $this->deleteFromSupabase('pwcliente', 'codcliente', $codcliente);
                $this->deleteFromSupabase('pwendereco', 'codendereco', $codendereco);
                $this->deleteFromSupabase('pwtelefone', 'codtelefone', $codtelefone);
            } else {
                return response()->json([
                    'message' => 'Tipo de pessoa inválido'
                ], 400);
            }

            return response()->json([
                'message' => 'Cliente deletado com sucesso'
            ], 204);

        } catch (\Exception $e) {
            Log::error('Falha ao excluir o cliente no Banco: ' . $e->getMessage());
            return response()->json([
                'message' => 'Erro ao excluir o cliente no Supabase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function findClientById(string $id)
    {
        $response = Http::withHeaders([
            'apikey' => $this->supabaseKey,
            'Authorization' => 'Bearer ' . $this->supabaseKey,
            'Accept' => 'application/json',
        ])->get($this->supabaseUrl . '/rest/v1/pwcliente', [
            'select' => 'tipopessoa, codendereco, codtelefone',
            'codcliente' => 'eq.' . $id,
            'limit' => 1
        ]);

        $response->throw();
        $data = $response->json();
        return empty($data) ? null : $data[0];
    }
}
