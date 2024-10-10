<?php

namespace App\Http\Controllers;

use App\Models\Predio;
use Illuminate\Http\Request;

class PredioController extends Controller
{
    public function index()
    {
        $predios = Predio::all();
        return view('predios.index', compact('predios'));
    }

    public function create()
    {
        return view('predios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        Predio::create($request->all());
        return redirect()->route('predios.index')->with('success', 'Prédio adicionado com sucesso!');
    }

    public function edit($id)
    {
        $predio = Predio::findOrFail($id);
        return view('predios.edit', compact('predio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $predio = Predio::findOrFail($id);
        $predio->update($request->all());
        return redirect()->route('predios.index')->with('success', 'Prédio atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $predio = Predio::findOrFail($id);
        $predio->delete();
        return redirect()->route('predios.index')->with('success', 'Prédio removido com sucesso!');
    }
}
