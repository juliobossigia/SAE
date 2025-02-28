<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\Departamento;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function index(){
        $disciplinas = Disciplina::with('departamento')->get();
        return view('admin.disciplinas.index', compact('disciplinas'));
    }

    public function create(){
        $departamentos = Departamento::all();
        return view('admin.disciplinas.create', compact('departamentos'));
    }

    public function store(Request $request){
        $request->validate([
            'nome'=>'required|string',
            'departamento_id'=>'required|exists:departamentos,id',
        ]);

        Disciplina::create($request->all());
        return redirect()->route('admin.disciplinas.index')->with('success','Disciplina criada com sucesso!');
    }

    public function show($id){
        $disciplina = Disciplina::with('departamento')->findOrFail($id);
        return view('admin.disciplinas.show',compact('disciplina'));
    }
    
    public function edit($id){
        $disciplina = Disciplina::findOrFail($id);
        $departamentos = Departamento::all();
        return view('admin.disciplinas.edit', compact('disciplina','departamentos'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nome'=>'required|string',
            'departamento_id'=>'required|exists:departamentos,id',
        ]);

        $disciplina = Disciplina::findOrFail($id);
        $disciplina->update($request->all());

        return redirect()->route('admin.disciplinas.index')->with('success','Disciplina atualizada com sucesso!');
    }

    public function destroy($id){
        $disciplina = Disciplina::findOrFail($id);
        $disciplina->delete();
        return redirect()->route('admin.disciplinas.index')->with('success','Disciplina apagada com sucesso!');
    }

    public function getDocentes(Disciplina $disciplina){
        return response()->json($disciplina->docentes()->get(['id','nome']));
    }
}
