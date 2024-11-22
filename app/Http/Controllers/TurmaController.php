<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use App\Models\Curso;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(){
        $turmas = Turma::with('curso')->get();
        return view('admin.turmas.index', compact('turmas'));
    }

    public function create(){
        $cursos = Curso::all();
        return view('admin.turmas.create', compact('cursos'));
    }

    public function store(Request $request){
        $request->validate([
            'ano' => 'required|integer',
            'letra' => 'required|string|max:1',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Turma::create($request->all());
        return redirect()->route('admin.turmas.index')->with('success','Turma criada com sucesso!');
    }

    public function show($id){
        $turma = Turma::with('curso')->findOrFail($id);
        return view('admin.turmas.show',compact('turma'));
    }

    public function edit($id){
        $turma = Turma::findOrFail($id);
        $cursos = Curso::all();
        return view('admin.turmas.edit',compact('turma','cursos'));
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
        
        return redirect()->route('admin.turmas.index')->with('success','Turma atualizada com sucesso!');
    }

    public function destroy($id){
        $turma = Turma::findOrFail($id);
        $turma->delete();
        return redirect()->route('admin.turmas.index')->with('success','Turma deletada com sucesso!');
    }

}
