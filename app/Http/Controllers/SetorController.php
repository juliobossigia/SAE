<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{
    public function index(){

        $setores= Setor::all();
        return view('setores.index',compact('setores'));
    }

    public function create(){

        return view('setores.create');
    }

    public function store(Request $request){
        $request->validate([
            'nome' => 'required',
        ]);

        Setor::create($request->all());

        return redirect()->route('setores.index')->with('success','Setor criado com sucesso!');
    }

    public function show(string $id){

        $setor = Setor::findOrFail($id);

        return view('setores.show',compact('setor'));
    }

    public function edit(string $id){

        $setor = Setor::findOrFail($id);

        return view('setores.edit', compact('setor'));
    }

    public function update(Request $request, Setor $setor){

        $request->validate([
            'nome'=>'required',
        ]);
        
        $setor->update($request->all());

        return redirect()->route('setores.index')->with('success','Setor atualizado com sucesso!');
    }

    public function destroy(Setor $setor){

        $setor->delete();

        return redirect()->route('setores.index')->with('success','Setor apagado com sucesso!');
    }

}
