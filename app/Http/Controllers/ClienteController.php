<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Services\ClienteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClienteController extends Controller
{
    protected $clienteService;

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('perPage', 10);
            $page = $request->input('page', 1);

            $result = $this->clienteService->listClientes($page, $perPage);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar dados', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreClienteRequest $request): JsonResponse
    {
        try {
            $cliente = $this->clienteService->createCliente($request->validated());
            return response()->json($cliente, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $codcliente): JsonResponse
    {
        try {
            $cliente = $this->clienteService->getCliente($codcliente);

            if (!$cliente) {
                return response()->json(['message' => 'Cliente não encontrado'], 404);
            }

            return response()->json($cliente, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar cliente', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $cliente = $this->clienteService->updateCliente($id, $request->all());

            if (!$cliente) {
                return response()->json(['message' => 'Cliente não encontrado para atualização'], 404);
            }

            return response()->json($cliente, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $codcliente): JsonResponse
    {
        try {
            $deleted = $this->clienteService->deleteCliente($codcliente);

            if (!$deleted) {
                return response()->json(['message' => 'Cliente não encontrado'], 404);
            }

            return response()->json(['message' => 'Cliente deletado com sucesso'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar', 'error' => $e->getMessage()], 500);
        }
    }
}