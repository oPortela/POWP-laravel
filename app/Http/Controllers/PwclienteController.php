<?php


namespace App\Http\Controllers;

use App\Models\Pwcliente;
use Illuminate\Http\Request;

class PwclienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Pwcliente::orderBy('data_cadastro', 'desc')->paginate(10);
        return view('pwclientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pwclientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_cadastro' => 'required|date',
            'tipo_pessoa' => 'required|in:F,J',
            'observacoes' => 'nullable|string|max:250',
        ]);

        Pwcliente::create($request->all());

        return redirect()->route('pwclientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pwcliente $pwcliente)
    {
        return view('pwclientes.show', compact('pwcliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pwcliente $pwcliente)
    {
        return view('pwclientes.edit', compact('pwcliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pwcliente $pwcliente)
    {
        $request->validate([
            'data_cadastro' => 'required|date',
            'tipo_pessoa' => 'required|in:F,J',
            'observacoes' => 'nullable|string|max:250',
        ]);

        $pwcliente->update($request->all());

        return redirect()->route('pwclientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pwcliente $pwcliente)
    {
        $pwcliente->delete();

        return redirect()->route('pwclientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }

    /**
     * Filtros adicionais
     */
    public function fisicos()
    {
        $clientes = Pwcliente::where('tipo_pessoa', 'F')
            ->orderBy('data_cadastro', 'desc')
            ->paginate(10);

        return view('pwclientes.index', compact('clientes'))
            ->with('titulo', 'Clientes - Pessoa Física');
    }

    public function juridicos()
    {
        $clientes = Pwcliente::where('tipo_pessoa', 'J')
            ->orderBy('data_cadastro', 'desc')
            ->paginate(10);

        return view('pwclientes.index', compact('clientes'))
            ->with('titulo', 'Clientes - Pessoa Jurídica');
    }
}