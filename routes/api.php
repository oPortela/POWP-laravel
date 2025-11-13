<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardVendaController;
use App\Http\Controllers\FornecedorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dados-contagem-clientes', [DashboardVendaController::class, 'getClientesAtivos']);
Route::get('/dados-qt-vendas-hoje', [DashboardVendaController::class, 'getSalesToday']);
Route::get('/dados-valor-vendas-hoje', [DashboardVendaController::class, 'getSalesValueToday']);

Route::get('/dados-dashboard-vendas', [DashboardVendaController::class, 'getSalesChartData']);

Route::get('/sales-comparison', [DashboardVendaController::class, 'salesComparison']);


//Rotas de Fornecedor
Route::prefix('fornecedores')->group(function () {
    Route::post('', [FornecedorController::class, 'store']);
    Route::get('', [FornecedorController::class, 'index']);
    Route::delete('/{id}', [FornecedorController::class, 'destroy']);

    Route::get('/{id}', [FornecedorController::class, 'show']);
    Route::put('/{id}', [FornecedorController::class, 'update']);
});

Route::prefix('clientes')->group(function () {
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
    Route::post('', [ClienteController::class, 'store']);
});