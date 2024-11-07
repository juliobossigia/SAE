<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Setor;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registros = Registro::with(['aluno', 'turma', 'setor', 'local', 'criadoPor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('registros.index', compact('registros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alunos = Aluno::orderBy('nome')->get();
        $turmas = Turma::all();
        $setores = Setor::all();
        $locais = Local::all();

        return view('registros.create', compact('alunos', 'turmas', 'setores', 'locais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'aluno_id' => 'nullable|exists:alunos,id',
            'turma_id' => 'nullable|exists:turmas,id',
            'tipo' => 'required|in:Advertência,Registro Disciplinar,Nota NAI,Registro Pedagogico',
            'descricao' => 'required|string',
            'encaminhado_para' => 'required|exists:setores,id',
            'agendamento' => 'boolean',
            'data_agendamento' => 'nullable|date|required_if:agendamento,true',
            'hora_agendamento' => 'nullable|date_format:H:i|required_if:agendamento,true',
            'participantes' => 'nullable|string',
            'local_id' => 'nullable|exists:locais,id'
        ]);

        $validated['criado_por_id'] = Auth::id();

        $registro = Registro::create($validated);

        if ($request->agendamento) {
            $registro->agendamento()->create([
                'data_agendamento' => $request->data_agendamento,
                'hora_agendamento' => $request->hora_agendamento,
                'participantes' => $request->participantes,
                'local_id' => $request->local_id,
                'status' => 'Pendente'
            ]);
        }


        return redirect()
            ->route('registros.show', $registro)
            ->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Registro $registro)
    {
        $registro->load(['aluno', 'turma', 'setor', 'local', 'criadoPor']);

        return view('registros.show', compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registro $registro)
    {
        $alunos = Aluno::orderBy('nome')->get();
        $turmas = Turma::all();
        $setores = Setor::all();
        $locais = Local::all();

        return view('registros.edit', compact('registro', 'alunos', 'turmas', 'setores', 'locais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registro $registro)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'aluno_id' => 'nullable|exists:alunos,id',
            'turma_id' => 'nullable|exists:turmas,id',
            'tipo' => 'required|in:Advertência,Registro Disciplinar,Nota NAI,Registro Pedagogico',
            'descricao' => 'required|string',
            'encaminhado_para' => 'required|exists:setores,id',
            'agendamento' => 'boolean',
            'data_agendamento' => 'nullable|date|required_if:agendamento,true',
            'hora_agendamento' => 'nullable|date_format:H:i|required_if:agendamento,true',
            'participantes' => 'nullable|string',
            'local_id' => 'nullable|exists:locais,id'
        ]);

        $registro->update($validated);

        return redirect()
            ->route('registros.show', $registro)
            ->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();

        return redirect()
            ->route('registros.index')
            ->with('success', 'Registro excluído com sucesso!');
    }

    /**
     * Busca registros com base em filtros
     */
    public function search(Request $request)
    {
        $query = Registro::query();

        if ($request->filled('aluno_id')) {
            $query->where('aluno_id', $request->aluno_id);
        }

        if ($request->filled('turma_id')) {
            $query->where('turma_id', $request->turma_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('data_inicio')) {
            $query->where('data', '>=', $request->data_inicio);
        }

        if ($request->filled('data_fim')) {
            $query->where('data', '<=', $request->data_fim);
        }

        $registros = $query->with(['aluno', 'turma', 'setor', 'local', 'criadoPor'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('registros.index', compact('registros'));
    }
}
