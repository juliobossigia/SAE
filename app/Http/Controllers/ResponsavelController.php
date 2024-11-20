<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use App\Models\Aluno;
use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    // Métodos CRUD (apenas admin)
    public function index()
    {
        $responsaveis = Responsavel::with('alunos')->get();
        return view('responsaveis.index', compact('responsaveis'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        return view('responsaveis.create', compact('alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:responsaveis,email',
            'cpf' => 'required|unique:responsaveis',
            'telefone' => 'required',
            'user_id' => 'required|exists:users,id',
            'alunos' => 'required|array|exists:alunos,id'
        ]);

        $responsavel = Responsavel::create($request->except('alunos'));
        $responsavel->alunos()->attach($request->alunos);

        return redirect()->route('responsaveis.index')
                        ->with('success', 'Responsável criado com sucesso.');
    }

    public function show(Responsavel $responsavel)
    {
        return view('responsaveis.show', compact('responsavel'));
    }

    public function edit(Responsavel $responsavel)
    {
        $alunos = Aluno::all();
        return view('responsaveis.edit', compact('responsavel', 'alunos'));
    }

    public function update(Request $request, Responsavel $responsavel)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:responsaveis,email,' . $responsavel->id,
            'cpf' => 'required|unique:responsaveis,' . $responsavel->id,
            'telefone' => 'required',
            'alunos' => 'required|array|exists:alunos,id'
        ]);

        $responsavel->update($request->except('alunos'));
        $responsavel->alunos()->sync($request->alunos);

        return redirect()->route('responsaveis.index')
                        ->with('success', 'Responsável atualizado com sucesso.');
    }

    public function destroy(Responsavel $responsavel)
    {
        $responsavel->alunos()->detach();
        $responsavel->delete();

        return redirect()->route('responsaveis.index')
                        ->with('success', 'Responsável deletado com sucesso.');
    }

    // Métodos específicos para responsáveis logados
    public function meuPerfil()
    {
        $responsavel = Responsavel::where('user_id', auth()->id())->firstOrFail();
        return view('responsaveis.perfil', compact('responsavel'));
    }

    public function meusAlunos()
    {
        $responsavel = Responsavel::where('user_id', auth()->id())->firstOrFail();
        $alunos = $responsavel->alunos;
        return view('responsaveis.alunos', compact('alunos'));
    }

    public function verRegistrosAluno($alunoId)
    {
        $responsavel = Responsavel::where('user_id', auth()->id())->firstOrFail();
        $aluno = $responsavel->alunos()->findOrFail($alunoId);
        $registros = $aluno->registros;
        
        return view('responsaveis.registros-aluno', compact('aluno', 'registros'));
    }

    public function verAgendamentosAluno($alunoId)
    {
        $responsavel = Responsavel::where('user_id', auth()->id())->firstOrFail();
        $aluno = $responsavel->alunos()->findOrFail($alunoId);
        $agendamentos = $aluno->agendamentos;
        
        return view('responsaveis.agendamentos-aluno', compact('aluno', 'agendamentos'));
    }
}
