<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();
        return view('docentes.index',compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:docentes',
            'data_nascimento'=>'required|date',
            'cpf'=>'required|unique:docentes',
        ]);

        Docente::create($request->all());

        return redirect()->route('docentes.index')->with('sucess','Docente cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        // Buscar o aluno pelo ID
        $docente = Docente::findOrFail($id);
        
        
        return view('docentes.show',compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        // Buscar o aluno pelo ID
        $docente = Docente::findOrFail($id);
        
        
        return view('docentes.edit',compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>'required|email|unique:docentes',
            'data_nascimento'=>'required|date',
            'cpf'=>'required|unique:docentes',
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')->with('success', 'Docente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        $docente->delete();
        
        return redirect()->route('docente.index')->with('sucess', 'Docente deletado com sucesso!');
    }
}
