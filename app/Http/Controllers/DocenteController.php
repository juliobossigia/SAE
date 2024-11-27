<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Disciplina;
use App\Models\Curso;
use App\Models\User;
use App\Models\Registro;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Setor;
use App\Models\Local;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    // Métodos CRUD (apenas admin)
    public function index()
    {
        $docentes = Docente::with('departamento')->get();
        return view('admin.docentes.index', compact('docentes'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        $disciplinas = Disciplina::all();
        $cursos = Curso::all();
        return view('admin.docentes.create', compact('departamentos', 'disciplinas', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|unique:users,cpf',
            'password' => 'required|string|min:8|confirmed',
            'departamento_id' => 'required|exists:departamentos,id',
            'data_nascimento' => 'required|date',
            'is_coordenador' => 'boolean',
            'curso_id' => 'required_if:is_coordenador,1|exists:cursos,id',
            'status' => 'required|in:ativo,inativo'
        ]);

        DB::beginTransaction();
        
        try {
            // Criar o usuário primeiro
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cpf' => $request->cpf,
                'tipo_usuario' => 'docente',
                'status' => $request->status
            ]);

            // Criar o docente
            $docente = Docente::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'departamento_id' => $request->departamento_id,
                'data_nascimento' => $request->data_nascimento,
                'is_coordenador' => $request->boolean('is_coordenador'),
                'curso_id' => $request->is_coordenador ? $request->curso_id : null,
                'status' => $request->status == 'ativo'
            ]);

            // Estabelecer o relacionamento polimórfico
            $user->profile()->associate($docente);
            $user->save();

            // Atribuir a role
            $user->assignRole('docente');

            DB::commit();
            return redirect()->route('admin.docentes.index')
                ->with('success', 'Docente criado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Erro ao criar docente: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $docente = Docente::with('departamento')->findOrFail($id);
        return view('admin.docentes.show', compact('docente'));
    }

    public function edit(string $id)
    {
        $docente = Docente::findOrFail($id);
        $departamentos = Departamento::all();
        return view('admin.docentes.edit', compact('docente', 'departamentos'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $docente->id,
            'cpf' => 'required|unique:docentes,' . $docente->id,
            'departamento_id' => 'required|exists:departamentos,id'
        ]);

        $docente->update($request->all());

        return redirect()->route('admin.docentes.index')
                        ->with('success', 'Docente atualizado com sucesso.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('admin.docentes.index')
                        ->with('success', 'Docente deletado com sucesso.');
    }

    // Métodos específicos para docentes logados
    public function meuPerfil()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        return view('docentes.perfil', compact('docente'));
    }

    public function meusAgendamentos()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        $agendamentos = $docente->agendamentos;
        return view('docentes.agendamentos', compact('agendamentos'));
    }

    public function minhasDisciplinas()
    {
        $docente = Docente::where('user_id', auth()->id())->firstOrFail();
        $disciplinas = $docente->disciplinas;
        return view('docentes.disciplinas', compact('disciplinas'));
    }

    public function agendamentos()
    {
        // Busca o docente autenticado
        $docente = auth()->user()->profile;
        
        // Busca os registros feitos pelo docente
        $registros = Registro::where('docente_id', $docente->id)
            ->with(['agendamentos' => function($query) {
                $query->orderBy('data_agendamento', 'desc');
            }, 'agendamentos.local', 'aluno'])
            ->has('agendamentos')
            ->get();

        return view('docente.agendamentos.index', [
            'registros' => $registros
        ]);
    }

    public function registros()
    {
        $turmas = Turma::all();
        $alunos = Aluno::all();
        $setores = Setor::all();
        $locais = Local::all();

        return view('docente.registros.create', compact('turmas', 'alunos', 'setores', 'locais'));
    }

    public function storeRegistro(Request $request)
    {
        // Regras básicas de validação
        $rules = [
            'data' => 'required|date',
            'turma_id' => 'required|exists:turmas,id',
            'aluno_id' => 'required|exists:alunos,id',
            'tipo' => 'required|in:Advertência,Registro Disciplinar,Nota NAI,Registro Pedagogico',
            'descricao' => 'required|string',
            'encaminhado_para' => 'required|exists:setores,id',
        ];

        // Adiciona regras de validação para agendamento apenas se o checkbox estiver marcado
        if ($request->has('agendamento') && $request->agendamento) {
            $rules['data_agendamento'] = 'required|date';
            $rules['hora_agendamento'] = 'required|date_format:H:i';
            $rules['participantes'] = 'required|string';
            $rules['local_id'] = 'required|exists:locais,id';
        }

        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Criar o registro
            $registro = Registro::create([
                'data' => $validated['data'],
                'turma_id' => $validated['turma_id'],
                'aluno_id' => $validated['aluno_id'],
                'tipo' => $validated['tipo'],
                'descricao' => $validated['descricao'],
                'encaminhado_para' => $validated['encaminhado_para'],
                'criado_por_id' => auth()->id(),
                'agendamento' => $request->has('agendamento'),
            ]);

            // Se houver agendamento, adicionar os dados do agendamento
            if ($request->has('agendamento') && $request->agendamento) {
                $registro->update([
                    'data_agendamento' => $validated['data_agendamento'],
                    'hora_agendamento' => $validated['hora_agendamento'],
                    'participantes' => $validated['participantes'],
                    'local_id' => $validated['local_id'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('docente.registros.index')
                ->with('success', 'Registro criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erro ao criar registro: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Erro ao criar registro. Por favor, tente novamente.');
        }
    }

    private function verificarAutorizacao($docente)
    {
        if (!auth()->user()->hasRole('admin') && 
            $docente->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }
    }

    public function listarRegistros()
    {
        try {
            // Usar criado_por_id ao invés de docente_id
            $registros = Registro::where('criado_por_id', auth()->id())
                ->with(['aluno', 'turma'])
                ->orderBy('data', 'desc')
                ->get();

            return view('docente.registros.index', compact('registros'));
        } catch (\Exception $e) {
            \Log::error('Erro ao listar registros: ' . $e->getMessage());
            return back()->with('error', 'Erro ao carregar registros. Por favor, tente novamente.');
        }
    }

    public function showRegistro(Registro $registro)
    {
        // Verifica se o registro foi criado pelo docente atual
        if ($registro->criado_por_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para ver este registro.');
        }

        return view('docente.registros.show', [
            'registro' => $registro,
            'setores' => Setor::all(), // Adicione se necessário
            'locais' => Local::all()   // Adicione se necessário
        ]);
    }
}
