<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Setor;
use App\Models\Local;
use App\Models\Curso;
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
            $registros = Registro::with(['aluno', 'turma', 'setor'])
                ->latest('data')
                ->paginate(10);

            return view('admin.registros.index', compact('registros'));
        } catch (\Exception $e) {
            \Log::error('Erro ao carregar registros: ' . $e->getMessage());
            return response()->view('admin.registros.index', ['registros' => collect(), 'error' => 'Erro ao carregar registros'], 200);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = Curso::orderBy('nome')->get();
        $alunos = Aluno::orderBy('nome')->get();
        $turmas = Turma::all();
        $setores = Setor::all();
        $locais = Local::all();

        return view('admin.registros.create', compact('cursos', 'alunos', 'turmas', 'setores', 'locais'));
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
                ->route('admin.registros.show', $registro)
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
        try {
            $registro->load(['aluno', 'turma', 'setor', 'local', 'criadoPor']);
            return view('admin.registros.show', compact('registro'));
        } catch (\Exception $e) {
            \Log::error('Erro ao exibir registro: ' . $e->getMessage());
            return redirect()
                ->route('admin.registros.index')
                ->with('error', 'Erro ao exibir registro.');
        }
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

        return view('admin.registros.edit', compact('registro', 'alunos', 'turmas', 'setores', 'locais'));
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
            ->route('admin.registros.show', $registro)
            ->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registro $registro)
    {
        $registro->delete();

        return redirect()
            ->route('admin.registros.index')
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

        return view('admin.registros.index', compact('registros'));
    }

    public function getTurmasPorCurso($curso_id)
    {
        $turmas = Turma::where('curso_id', $curso_id)->get();
        return response()->json($turmas);
    }

    public function getAlunosPorTurma($turma_id)
    {
        $alunos = Aluno::where('turma_id', $turma_id)->get();
        return response()->json($alunos);
    }
}
