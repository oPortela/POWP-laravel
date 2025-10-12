<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('auth.login');
})->name('login');


Route::get('/supabase-select', function () {
    $url = env('SUPABASE_URL') . '/rest/v1/pwcliente';
    $key = env('SUPABASE_KEY');

    $response = Http::withHeaders([
        'apikey' => $key,
        'Authorization' => 'Bearer ' . $key,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ])->get($url, [
        'select' => '*', 'codcliente' => 'eq.1'
    ]);

    if ($response->successful()) {
        $cliente = $response->json();
        return $cliente;
    } else {
        return [
            'erro' => true,
            'status' => $response->status(),
            'mensagem' => $response->body()
        ];
    }
});