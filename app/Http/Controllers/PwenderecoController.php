<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pwendereco;

class PwenderecoController extends Controller
{
    // Listar todos os endereços
    public function index()
    {
        return Pwendereco::all();
    }

    // Criar novo endereço
    public function store(Request $request)
    {
        $endereco = Pwendereco::create($request->all());
        return response()->json($endereco, 201);
    }

    // Mostrar um endereço específico
    public function show($id)
    {
        return Pwendereco::findOrFail($id);
    }

    // Atualizar um endereço
    public function update(Request $request, $id)
    {
        $endereco = Pwendereco::findOrFail($id);
        $endereco->update($request->all());
        return response()->json($endereco, 200);
    }

    // Deletar um endereço
    public function destroy($id)
    {
        Pwendereco::destroy($id);
        return response()->json(null, 204);
    }
}
