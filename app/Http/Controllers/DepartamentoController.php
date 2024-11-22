<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos =Departamento::all();
        return view('admin.departamentos.index',compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required|string',
        ]);

        Departamento::create($request->all());
        return redirect()->route('admin.departamentos.index')->with('success','Departamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        $departamento = Departamento::findOrFail($id);
        return view('admin.departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('admin.departamentos.edit',compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nome'=>'required|string',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update($request->all());

        return redirect()->route('admin.departamentos.index')->with('success','Departamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        $departamento = Departamento::FindOrFail($id);
        $departamento->delete();
        return redirect()->route('admin.departamentos.index')->with('success','Departamento apagado com sucesso!');
    }
}
