<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
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
        try {
            // Busca apenas registros do docente logado
            $registros = Registro::with(['aluno', 'turma', 'setor'])
                ->where('criado_por_id', Auth::id())
                ->latest('data')
                ->paginate(10);

            return view('docente.registros.index', compact('registros'));
        } catch (\Exception $e) {
            \Log::error('Erro ao carregar registros: ' . $e->getMessage());
            return response()->view('docente.registros.index', ['registros' => collect()], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Busca apenas alunos das turmas do docente
        $alunos = Aluno::whereHas('turma', function($query) {
            $query->whereHas('docentes', function($q) {
                $q->where('docente_id', Auth::id());
            });
        })->orderBy('nome')->get();

        // Busca apenas turmas do docente
        $turmas = Turma::whereHas('docentes', function($query) {
            $query->where('docente_id', Auth::id());
        })->get();

        $setores = Setor::all();
        $locais = Local::all();

        return view('docente.registros.create', compact('alunos', 'turmas', 'setores', 'locais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'data' => 'required|date',
                'aluno_id' => 'nullable|exists:alunos,id',
                'turma_id' => 'nullable|exists:turmas,id',
                'tipo' => 'required|in:Advertência,Registro Disciplinar,Nota NAI,Registro Pedagogico',
                'descricao' => 'required|string',
                'encaminhado_para' => 'required|exists:setores,id',
                'agendamento' => 'nullable|boolean',
                'data_agendamento' => 'nullable|date|required_if:agendamento,true',
                'hora_agendamento' => 'nullable|date_format:H:i|required_if:agendamento,true',
                'participantes' => 'nullable|string',
                'local_id' => 'nullable|exists:locais,id'
            ]);

            // Verifica se o aluno pertence a uma turma do docente
            if ($request->aluno_id) {
                $alunoAutorizado = Aluno::whereHas('turma.docentes', function($query) {
                    $query->where('docente_id', Auth::id());
                })->where('id', $request->aluno_id)->exists();

                if (!$alunoAutorizado) {
                    return back()->withInput()->with('error', 'Você não tem permissão para criar registros para este aluno.');
                }
            }

            $validated['criado_por_id'] = Auth::id();

            $registro = Registro::create($validated);

            if ($request->has('agendamento') && $request->agendamento) {
                $registro->agendamento()->create([
                    'data_agendamento' => $request->data_agendamento,
                    'hora_agendamento' => $request->hora_agendamento,
                    'participantes' => $request->participantes,
                    'local_id' => $request->local_id,
                    'status' => 'Pendente'
                ]);
            }

            return redirect()
                ->route('docente.registros.show', $registro)
                ->with('success', 'Registro criado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao criar registro: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Erro ao criar registro. Por favor, tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Registro $registro)
    {
        // Verifica se o registro pertence ao docente
        if ($registro->criado_por_id !== Auth::id()) {
            return redirect()
                ->route('docente.registros.index')
                ->with('error', 'Você não tem permissão para visualizar este registro.');
        }

        try {
            $registro->load(['aluno', 'turma', 'setor', 'local', 'criadoPor']);
            return view('docente.registros.show', compact('registro'));
        } catch (\Exception $e) {
            \Log::error('Erro ao exibir registro: ' . $e->getMessage());
            return redirect()
                ->route('docente.registros.index')
                ->with('error', 'Erro ao exibir registro.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registro $registro)
    {
        // Verifica se o registro pertence ao docente
        if ($registro->criado_por_id !== Auth::id()) {
            return redirect()
                ->route('docente.registros.index')
                ->with('error', 'Você não tem permissão para editar este registro.');
        }

        $alunos = Aluno::whereHas('turma.docentes', function($query) {
            $query->where('docente_id', Auth::id());
        })->orderBy('nome')->get();

        $turmas = Turma::whereHas('docentes', function($query) {
            $query->where('docente_id', Auth::id());
        })->get();

        $setores = Setor::all();
        $locais = Local::all();

        return view('docente.registros.edit', compact('registro', 'alunos', 'turmas', 'setores', 'locais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registro $registro)
    {
        // Verifica se o registro pertence ao docente
        if ($registro->criado_por_id !== Auth::id()) {
            return redirect()
                ->route('docente.registros.index')
                ->with('error', 'Você não tem permissão para atualizar este registro.');
        }

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
            ->route('docente.registros.show', $registro)
            ->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registro $registro)
    {
        // Verifica se o registro pertence ao docente
        if ($registro->criado_por_id !== Auth::id()) {
            return redirect()
                ->route('docente.registros.index')
                ->with('error', 'Você não tem permissão para excluir este registro.');
        }

        $registro->delete();

        return redirect()
            ->route('docente.registros.index')
            ->with('success', 'Registro excluído com sucesso!');
    }

    /**
     * Busca registros com base em filtros
     */
    public function search(Request $request)
    {
        $query = Registro::query()->where('criado_por_id', Auth::id());

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

        return view('docente.registros.index', compact('registros'));
    }
}