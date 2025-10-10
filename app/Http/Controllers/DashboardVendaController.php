<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardVendaController extends Controller
{
    private $url;
    private $key;

    public function __construct() {
        $this->url = env('SUPABASE_URL');
        $this->key = env('SUPABASE_KEY');
    }

    public function getSalesValueToday(): JsonResponse 
    {
        $tableName = 'vw_sales_today';
        $today = Carbon::now()->format('Y-m-d');

        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'authorization' => "Bearer {$this->key}",
            
            ])->get("{$this->url}/rest/v1/{$tableName}", [
                'select' => 'total',
                //'select' => 'total:sum(vltotal)', 
                'dia' => "eq.$today",
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Falha ao buscar valor de vendas', 'details' => $response->json()], 500);
            }

            $data = $response->json();

            $totalValue = !empty($data) ? $data[0]['total'] : 0;

            return response()->json([
                'sales_value_today' => (float) $totalValue
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getSalesToday(): JsonResponse {
        $tableName = 'pwpedidoc';
        $today = Carbon::now()->format('Y-m-d');

        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'authorization' => "Bearer {$this->key}",
                'Prefer' => 'count=exact',
            ])->get("{$this->url}/rest/v1/{$tableName}", [
                'select' => 'codpedido',
                'data' => "eq.$today",  // Filtra vendas do dia atual
                'limit' => 0
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Falha ao conectar com o Banco de Dados',
                    'details' => $response->json()
                ], 500); // Status code como segundo parâmetro
            }

            $contentRange = $response->header('Content-Range');
            if (!$contentRange) {
                return response()->json([
                    'error' => 'Header Content-Range não encontrado na resposta da API.'
                ], 500);
            }

            list(, $count) = explode('/', $contentRange);

            return response()->json([
                'sales_today_count' => (int) $count
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno do servidor',
                'message' => $e->getMessage(),
                500
            ]);
        }
    }

    public function getClientesAtivos(): JsonResponse {
        $tableName = 'pwcliente';

        try {
            $response = Http::withHeaders([
                'apikey' => $this->key,
                'authorization' => "Bearer {$this->key}",
                'Prefer' => 'count=exact',
            ])->get("{$this->url}/rest/v1/{$tableName}", [
                'select' => 'codcliente',
                'bloqueio' => 'eq.N', //Filtra clientes ativos (bloqueio = 'N')
                'limit' => 0
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Falha ao conectar com o Banco de Dados',
                    'details' => $response->json()], 500);
            }

            $contentRange = $response->header('Content-Range');
            if (!$contentRange) {
                return response()->json(['error' => 'Header Content-Range não encontrado na resposta da API.'], 500);
            }

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

    public function getSalesChartData(): JsonResponse {
        try {
            $response = Http::withMiddleware([
                'apikey' => $this->key,
                'authorization' => "bearer {$this->key}",
            ])->post("{$this->url}/rpc/comparativo_vendas_diarias", [
                'dias_atras' => 5
            ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => 'Falha ao buscar dados do gráfico',
                    'details' => $response->json()
                ], 500);
            }

            $salesDataFromDB = $response->json();   

            $labels = [];
            $data = [];
            $salesByDate = [];

            foreach ($salesDataFromDB as $row) {
                $salesByDate[$row['dia']] = $row['total'];
            }

            for ($i=4; $i>=0; $i--) { 
                $date = Carbon::now()->subDays($i);
                $dateString = $date->format('Y-m-d');

                $labels[] = $date->translatedFormat('j \d\e M.');
                $data[] = $salesByDate[$dateString] ?? 0;
            }

            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);

        }catch (\Exception $e) {
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
