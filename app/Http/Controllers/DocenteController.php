<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Disciplina;
use App\Models\Curso;
use App\Models\User;
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

    private function verificarAutorizacao($docente)
    {
        if (!auth()->user()->hasRole('admin') && 
            $docente->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
