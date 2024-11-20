<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    // Métodos CRUD (apenas admin)
    public function index()
    {
        $docentes = Docente::with('departamento')->get();
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('docentes.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:docentes,email',
            'cpf' => 'required|unique:docentes',
            'departamento_id' => 'required|exists:departamentos,id',
            'user_id' => 'required|exists:users,id'
        ]);

        Docente::create($request->all());

        return redirect()->route('docentes.index')
                        ->with('success', 'Docente criado com sucesso.');
    }

    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        $departamentos = Departamento::all();
        return view('docentes.edit', compact('docente', 'departamentos'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $docente->id,
            'cpf' => 'required|unique:docentes,' . $docente->id,
            'departamento_id' => 'required|exists:departamentos,id'
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')
                        ->with('success', 'Docente atualizado com sucesso.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index')
                        ->with('success', 'Docente deletado com sucesso.');
    }

    // Métodos específicos para docentes logados
    public function meuPerfil()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        return view('docentes.perfil', compact('docente'));
    }

    public function meusAgendamentos()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        $agendamentos = $docente->agendamentos;
        return view('docentes.agendamentos', compact('agendamentos'));
    }

    public function minhasDisciplinas()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        $disciplinas = $docente->disciplinas;
        return view('docentes.disciplinas', compact('disciplinas'));
    }

    private function verificarAutorizacao($docente)
    {
        if (!auth()->user()->hasRole('admin') && 
            $docente->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
