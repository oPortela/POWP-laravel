<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pwproduto;

class PwprodutoController extends Controller
{
    public function index()
    {
        return Pwproduto::all();
    }

    public function store(Request $request)
    {
        $produto = Pwproduto::create($request->all());
        return response()->json($produto, 201);
    }

    public function show($id)
    {
        return Pwproduto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $produto = Pwproduto::findOrFail($id);
        $produto->update($request->all());
        return response()->json($produto, 200);
    }

    public function destroy($id)
    {
        Pwproduto::destroy($id);
        return response()->json(null, 204);
    }
}
