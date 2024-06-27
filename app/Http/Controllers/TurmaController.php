<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{
    public function index(){
        $turmas = Turma::all();
        return view('turmas.index', compact('turmas'));
    }

    public function create(){
        return view('turmas.create');
    }

    public function store(Request $request){
        $request->validate([
            'ano' => 'required|integer',
            'letra' => 'required|string|max:1',
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
        return view('turmas.edit',compact('turma'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'ano' => 'required|integer',
            'letra' => 'required|string|max:1',
        ]);

        $turma= Turma::findOrFail($id);
        $turma->update($request->all());
        
        return redirect()->route('turmas.index')->with('sucess','Turma atualizada com sucesso!');
    }

    public function destroy($id){
        $turma = Turma::findOrFail($id);
        $turma->delete();
        return redirect()->route('turmas.index')->with('sucess','Turma deletada com sucesso!');
    }

}
