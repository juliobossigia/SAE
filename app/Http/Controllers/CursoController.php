<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(){
        $cursos = Curso::all();
        return view('cursos.index', compact('cursos'));
    }

    public function create(){
        return view('cursos.create');
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required|string',
        ]);

        Curso::create($request->all());
        return redirect()->route('cursos.index')->with('success', 'Curso criado com sucesso!');
    }

    public function show($id){
        $curso = Curso::with('turmas')->findOrFail($id);
        return view('cursos.show', compact('curso'));
    }

    public function edit($id){
        $curso = Curso::findOrFail($id);
        return view('cursos.edit', compact('curso'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nome' => 'required|string',
        ]);

        $curso = Curso::findOrFail($id);
        $curso->update($request->all());
        
        return redirect()->route('cursos.index')->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy($id){
        $curso = Curso::findOrFail($id);
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso deletado com sucesso!');
    }


    public function getTurmas(Curso $curso)
    {
        return response()->json($curso->turmas()->get(['id', 'letra', 'ano']));
    }
}
