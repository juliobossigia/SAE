<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index()
    {
        $alunos = Aluno::with('turma', 'curso')->get();
        return view('admin.alunos.index', compact('alunos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $turmas = Turma::all();
        $cursos = Curso::all();
        return view('admin.alunos.create', compact('turmas', 'cursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:alunos',
            'data_nascimento' => 'required|date',
            'matricula' => 'required|unique:alunos',
            'turma_id' => 'required|exists:turmas,id',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Aluno::create($request->all());

        return redirect()->route('admin.alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $aluno = Aluno::with('turma', 'curso')->findOrFail($id);
        return view('admin.alunos.show', compact('aluno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $aluno = Aluno::findOrFail($id);
        $turmas = Turma::all();
        $cursos = Curso::all();

        return view('admin.alunos.edit', compact('aluno', 'turmas', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:alunos,email,' . $aluno->id,
            'data_nascimento' => 'required|date',
            'matricula' => 'required|unique:alunos,matricula,' . $aluno->id,
            'turma_id' => 'required|exists:turmas,id',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $aluno->update($request->all());

        return redirect()->route('admin.alunos.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('admin.alunos.index')->with('success', 'Aluno deletado com sucesso!');
    }
}
