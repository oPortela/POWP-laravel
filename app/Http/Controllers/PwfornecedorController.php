<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pwfornecedor;

class PwfornecedorController extends Controller
{
    public function index()
    {
        return Pwfornecedor::all();
    }

    public function store(Request $request)
    {
        $fornecedor = Pwfornecedor::create($request->all());
        return response()->json($fornecedor, 201);
    }

    public function show($id)
    {
        return Pwfornecedor::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $fornecedor = Pwfornecedor::findOrFail($id);
        $fornecedor->update($request->all());
        return response()->json($fornecedor, 200);
    }

    public function destroy($id)
    {
        Pwfornecedor::destroy($id);
        return response()->json(null, 204);
    }
}
