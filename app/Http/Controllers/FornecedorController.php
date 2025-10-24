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
    public function index()
    {
        try {
            $selectQuery = '*,pwendereco(*),pwtelefone(*)';

            $response = Http::withHeaders([
                'apikey' => $this->supabaseKey,
                'Authorization' => 'Bearer ' . $this->supabaseKey,
                'Accept' => 'application/json',
            ])
            ->get($this->supabaseUrl . '/rest/v1/pwfornecedor', [
                'select' => $selectQuery
            ]);

            $response->throw();

            return response()->json($response->json(), 200);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
