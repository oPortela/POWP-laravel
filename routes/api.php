<?php

use App\Http\Controllers\DashboardVendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dados-contagem-clientes', [DashboardVendaController::class, 'getClientesAtivos']);
Route::get('/dados-qt-vendas-hoje', [DashboardVendaController::class, 'getSalesToday']);
Route::get('/dados-valor-vendas-hoje', [DashboardVendaController::class, 'getSalesValueToday']);

Route::get('/dados-dashboard-vendas', [DashboardVendaController::class, 'getSalesChartData']);

Route::get('/sales-comparison', [DashboardVendaController::class, 'salesComparison']);