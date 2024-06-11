<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alunos = Aluno::all();
        return view('alunos.index',compact('alunos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alunos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:alunos',
            'data_nascimento'=>'required|date',
            'matricula'=>'required|unique:alunos',
        ]);

        Aluno::create($request->all());

        return redirect()->route('alunos.index')->with('sucess','Aluno cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        // Buscar o aluno pelo ID
        $aluno = Aluno::findOrFail($id);
        
        
        return view('alunos.show',compact('aluno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        // Buscar o aluno pelo ID
        $aluno = Aluno::findOrFail($id);
        
        
        return view('alunos.edit',compact('aluno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:alunos',
            'data_nascimento'=>'required|date',
            'matricula'=>'required|unique:alunos',
        ]);

        $aluno->update($request->all());

        return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        
        return redirect()->route('alunos.index')->with('sucess', 'Aluno deletado com sucesso!');
    }
}
