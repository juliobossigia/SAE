<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use App\Models\Aluno;
use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    // Métodos CRUD (apenas admin)
    public function index()
    {
        $responsaveis = Responsavel::with('alunos')->get();
        return view('responsavel.index', compact('responsaveis'));
    }

    public function create()
    {
        $alunos = Aluno::all();
        return view('responsavel.create', compact('alunos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:responsaveis,email',
            'cpf' => 'required|unique:responsaveis',
            'telefone' => 'required',
            'user_id' => 'required|exists:users,id',
            'alunos' => 'required|array|exists:alunos,id'
        ]);

        $responsavel = Responsavel::create($request->except('alunos'));
        $responsavel->alunos()->attach($request->alunos);

        return redirect()->route('responsaveis.index')
                        ->with('success', 'Responsável criado com sucesso.');
    }

    public function show(Responsavel $responsavel)
    {
        return view('responsavel.show', compact('responsavel'));
    }

    public function edit(Responsavel $responsavel)
    {
        $alunos = Aluno::all();
        return view('responsavel.edit', compact('responsavel', 'alunos'));
    }

    public function update(Request $request, Responsavel $responsavel)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:responsaveis,email,' . $responsavel->id,
            'cpf' => 'required|unique:responsaveis,' . $responsavel->id,
            'telefone' => 'required',
            'alunos' => 'required|array|exists:alunos,id'
        ]);

        $responsavel->update($request->except('alunos'));
        $responsavel->alunos()->sync($request->alunos);

        return redirect()->route('responsavel.index')
                        ->with('success', 'Responsável atualizado com sucesso.');
    }

    public function destroy(Responsavel $responsavel)
    {
        $responsavel->alunos()->detach();
        $responsavel->delete();

        return redirect()->route('responsavel.index')
                        ->with('success', 'Responsável deletado com sucesso.');
    }

    // Métodos específicos para responsáveis logados
    public function meuPerfil()
    {
        $responsavel = Responsavel::whereHas('user', function($query) {
            $query->where('id', auth()->id());
        })->firstOrFail();
        return view('responsavel.perfil', compact('responsavel'));
    }

    private function getAuthenticatedResponsavel()
    {
        return Responsavel::whereHas('user', function($query) {
            $query->where('id', auth()->id());
        })->firstOrFail();
    }

    public function meusAlunos()
    {
        try {
            $user = auth()->user();
            
            \Log::info('Tentando buscar responsável', [
                'user_email' => $user->email
            ]);

            $responsavel = Responsavel::firstOrCreate(
                ['email' => $user->email],
                [
                    'nome' => $user->name,
                    'email' => $user->email,
                    'cpf' => $user->cpf,
                    'telefone' => null,
                    'senha' => $user->password
                ]
            );

            $alunos = $responsavel->alunos;
            
            return view('responsavel.alunos', compact('alunos'));
            
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar/criar responsável', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    public function verRegistrosAluno(Aluno $aluno)
    {
        \Log::info('Acessando registros do aluno', [
            'aluno_id' => $aluno->id,
            'responsavel_id' => auth()->user()->id,
            'aluno_existe' => $aluno->exists,
            'responsavel' => $this->getAuthenticatedResponsavel()->toArray(),
            'alunos_do_responsavel' => $this->getAuthenticatedResponsavel()->alunos->pluck('id')
        ]);
        
        $responsavel = $this->getAuthenticatedResponsavel();
        
        // Verifica se o aluno pertence ao responsável
        if (!$responsavel->alunos->contains($aluno)) {
            \Log::warning('Aluno não pertence ao responsável', [
                'aluno_id' => $aluno->id,
                'responsavel_id' => $responsavel->id
            ]);
            abort(403, 'Não autorizado');
        }
        
        $registros = $aluno->registros()->with('docente')->get();
        
        \Log::info('Registros encontrados', [
            'quantidade' => $registros->count()
        ]);
        
        return view('responsavel.registros-aluno', compact('aluno', 'registros'));
    }

    public function verAgendamentosAluno($alunoId)
    {
        $responsavel = $this->getAuthenticatedResponsavel();
        $aluno = $responsavel->alunos()->findOrFail($alunoId);
        $agendamentos = $aluno->agendamentos;
        
        return view('responsavel.agendamentos-aluno', compact('aluno', 'agendamentos'));
    }
}
