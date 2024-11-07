<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Local;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function index()
    {
        $agendamentos = Agendamento::with(['registro', 'local'])
            ->orderBy('data_agendamento')
            ->orderBy('hora_agendamento')
            ->paginate(10);
            
        return view('agendamentos.index', compact('agendamentos'));
    }

    public function show(Agendamento $agendamento)
    {
        $agendamento->load(['registro', 'local']);
        return view('agendamentos.show', compact('agendamento'));
    }

    public function edit(Agendamento $agendamento)
    {
        $locais = Local::all();
        return view('agendamentos.edit', compact('agendamento', 'locais'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $validated = $request->validate([
            'data_agendamento' => 'required|date',
            'hora_agendamento' => 'required|date_format:H:i',
            'participantes' => 'nullable|string',
            'local_id' => 'nullable|exists:locais,id',
            'status' => 'required|in:Pendente,Confirmado,Cancelado,Realizado'
        ]);

        $agendamento->update($validated);

        return redirect()
            ->route('agendamentos.show', $agendamento)
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();

        return redirect()
            ->route('agendamentos.index')
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}