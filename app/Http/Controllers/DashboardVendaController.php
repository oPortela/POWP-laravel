<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class DashboardVendaController extends Controller
{
    public function getSalesData() {

    }

    public function getClientesAtivos() {
        $url = env('SUPABASE_URL');
        $key = env('SUPABASE_KEY');

        $tableName = 'pwcliente';

        $filter = 'bloqueio=eq.N'; // Filtra clientes ativos (bloqueio = 'N')

        try {
            $response = Http::withHeaders([
                'apikey' => $key,
                'authorization' => "Bearer {$key}",
                'Prefer' => 'count=exact',
            ])->get("{$url}/rest/v1/{$tableName}", [
                'select' => 'codcliente',
                $filter,
                'limit' => 0
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Falha ao conectar com o Banco de Dados',
                    'details' => $response->json()], 500);
            }

            $contentRange = $response->header('Content-Range');
            list(, $count) = explode('/', $contentRange);

            return response()->json([
                'active_clients_count' => (int) $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
                500
            ]);
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
