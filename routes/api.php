<?php

use App\Http\Controllers\DashboardVendaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/dados-contagem-clientes', [DashboardVendaController::class, 'getClientesAtivos']);
Route::get('/dados-qt-vendas-hoje', [DashboardVendaController::class, 'getSalesToday']);