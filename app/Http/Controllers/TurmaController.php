<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(){
        $turmas = Turma::with('curso')->get();
        return view('turmas.index', compact('turmas'));
    }

    public function create(){
        $cursos = Curso::all();
        return view('turmas.create', compact('cursos'));
    }

    public function store(Request $request){
        $request->validate([
            'ano' => 'required|integer',
            'letra' => 'required|string|max:1',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Turma::create($request->all());
        return redirect()->route('turmas.index')->with('sucess','Turma criada com sucesso!');
    }

    public function show($id){
        $turma = Turma::with('alunos')->findOrFail($id);
        return view('turmas.show',compact('turma'));
    }

    public function edit($id){
        $turma = Turma::findOrFail($id);
        $cursos = Curso::all();
        return view('turmas.edit',compact('turma','cursos'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'ano' => 'required|integer',
            'letra' => 'required|string|max:1',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $turma= Turma::findOrFail($id);
        $cursos = Curso::all();
        $turma->update($request->all());
        
        return redirect()->route('turmas.index')->with('sucess','Turma atualizada com sucesso!');
    }

    public function destroy($id){
        $turma = Turma::findOrFail($id);
        $turma->delete();
        return redirect()->route('turmas.index')->with('sucess','Turma deletada com sucesso!');
    }

}
