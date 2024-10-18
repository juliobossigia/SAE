<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Predio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocalController extends Controller
{
    public function index()
    {
        $locais = Local::with('predio')->get();
        return view('locais.index', compact('locais'));
    }

    public function create()
    {
        $predios = Predio::all(); // Buscando todos os prédios
        return view('locais.create', compact('predios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'predio_id' => 'required|exists:predios,id',
            'tipo_local' => 'required|in:sala,laboratório',
            'numero' => [
                'required',
                Rule::unique('locais')->where(function ($query) use ($request) {
                    return $query->where('numero', $request->numero)
                                 ->where('tipo_local', $request->tipo_local) 
                                 ->where('predio_id', $request->predio_id); 
                }),
            ], [
                'numero.unique' => 'Já existe um(a) :input do tipo :tipo_local com este número neste prédio.',
            ]
        ]);

        Local::create($request->all());
        return redirect()->route('locais.index')->with('success', 'Local criado com sucesso!');
    }
    

    public function edit($id)
    {
        $local = Local::findOrFail($id);
        $predios = Predio::all(); // Buscando todos os prédios para o select
        return view('locais.edit', compact('local', 'predios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => [
                'required',
                Rule::unique('locais')->where(function ($query) use ($request, $id) {
                    return $query->where('numero', $request->numero)
                                 ->where('tipo_local', $request->tipo_local) 
                                 ->where('predio_id', $request->predio_id) 
                                 ->where('id', '!=', $id); 
                }),
            ],
            'predio_id' => 'required|exists:predios,id',
            'tipo_local' => 'required|in:sala,laboratório',
        ]);

        $local = Local::findOrFail($id);
        $local->update($request->all());

        return redirect()->route('locais.index')->with('success', 'Local atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $local = Local::findOrFail($id);
        $local->delete();
        return redirect()->route('locais.index')->with('success', 'Local excluído com sucesso!');
    }
}
