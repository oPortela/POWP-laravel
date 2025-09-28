<?php


namespace App\Http\Controllers;

use App\Models\Pwempregado;
use Illuminate\Http\Request;

class PwempregadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empregados = Pwempregado::orderBy('data_admissao', 'desc')->paginate(10);
        return view('pwempregados.index', compact('empregados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pwempregados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14|unique:pwempregado_create,cpf',
            'rg' => 'nullable|string|max:20',
            'data_nascimento' => 'required|date',
            'data_admissao' => 'required|date',
            'data_demissao' => 'nullable|date',
            'contato_id' => 'required|exists:pwcontato_create,id',
            'endereco_id' => 'required|exists:pwendereco_create,id',
            'cargo' => 'required|string|max:100',
            'salario' => 'required|string|max:10',
            'descricao' => 'nullable|string',
        ]);

        Pwempregado::create($request->all());

        return redirect()->route('pwempregados.index')
            ->with('success', 'Empregado cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pwempregado $pwempregado)
    {
        return view('pwempregados.show', compact('pwempregado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pwempregado $pwempregado)
    {
        return view('pwempregados.edit', compact('pwempregado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pwempregado $pwempregado)
    {
        $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14|unique:pwempregado_create,cpf,' . $pwempregado->id,
            'rg' => 'nullable|string|max:20',
            'data_nascimento' => 'required|date',
            'data_admissao' => 'required|date',
            'data_demissao' => 'nullable|date',
            'contato_id' => 'required|exists:pwcontato_create,id',
            'endereco_id' => 'required|exists:pwendereco_create,id',
            'cargo' => 'required|string|max:100',
            'salario' => 'required|string|max:10',
            'descricao' => 'nullable|string',
        ]);

        $pwempregado->update($request->all());

        return redirect()->route('pwempregados.index')
            ->with('success', 'Empregado atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pwempregado $pwempregado)
    {
        $pwempregado->delete();

        return redirect()->route('pwempregados.index')
            ->with('success', 'Empregado excluído com sucesso!');
    }

    /**
     * Métodos adicionais
     */

    public function ativos()
    {
        $empregados = Pwempregado::ativos()
            ->orderBy('nome')
            ->paginate(10);

        return view('pwempregados.index', compact('empregados'))
            ->with('titulo', 'Empregados Ativos');
    }

    public function demitidos()
    {
        $empregados = Pwempregado::demitidos()
            ->orderBy('data_demissao', 'desc')
            ->paginate(10);

        return view('pwempregados.index', compact('empregados'))
            ->with('titulo', 'Empregados Demitidos');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $empregados = Pwempregado::where('nome', 'like', "%{$search}%")
            ->orWhere('cpf', 'like', "%{$search}%")
            ->orWhere('cargo', 'like', "%{$search}%")
            ->orderBy('nome')
            ->paginate(10);

        return view('pwempregados.index', compact('empregados', 'search'));
    }

    /**
     * Demitir um empregado
     */
    public function demitir(Pwempregado $pwempregado)
    {
        $pwempregado->update([
            'data_demissao' => now()
        ]);

        return redirect()->route('pwempregados.index')
            ->with('success', 'Empregado demitido com sucesso!');
    }

    /**
     * Recontratar um empregado
     */
    public function recontratar(Pwempregado $pwempregado)
    {
        $pwempregado->update([
            'data_demissao' => null
        ]);

        return redirect()->route('pwempregados.index')
            ->with('success', 'Empregado recontratado com sucesso!');
    }
}