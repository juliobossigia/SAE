<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use App\Models\Setor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ServidorController extends Controller
{
    public function index(Request $request)
    {
        $setor_id = $request->get('setor_id');
        $setores = Setor::all();
        $servidores = Servidor::with('setor')
                              ->when($setor_id, function ($query, $setor_id) {
                                  return $query->where('setor_id', $setor_id);
                              })
                              ->get();

        return view('admin.servidores.index', compact('servidores', 'setores'));
    }

    public function create()
    {
        $setores = Setor::all();
        return view('admin.servidores.create', compact('setores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|unique:users,cpf',
            'password' => 'required|string|min:8|confirmed',
            'setor_id' => 'required|exists:setores,id',
            'status' => 'required|in:ativo,inativo',
        ]);

        \DB::beginTransaction();
        
        try {
            // Criar o usuário primeiro
            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cpf' => $request->cpf,
                'tipo_usuario' => 'servidor',
                'status' => $request->status,
            ]);

            // Criar o servidor
            $servidor = Servidor::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'setor_id' => $request->setor_id,
                'status' => $request->status == 'ativo',
            ]);

            // Estabelecer o relacionamento polimórfico
            $servidor->user()->save($user);

            // Atribuir a role
            $user->assignRole('servidor');

            \DB::commit();

            return redirect()->route('admin.servidores.index')
                ->with('success', 'Servidor criado com sucesso.');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Erro ao criar servidor:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Erro ao criar servidor: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $servidor = Servidor::findOrFail($id);
        
        return view('admin.servidores.show', compact('servidor'));
    }

    public function edit(string $id)
    {
        $servidor = Servidor::findOrFail($id);
        $setores = Setor::all();
        return view('admin.servidores.edit', compact('servidor', 'setores'));
    }

    public function update(Request $request, Servidor $servidor)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:servidores,email,' . $servidor->id,
            'cpf' => 'required|unique:servidores,cpf,' . $servidor->id,
            'setor_id' => 'required|exists:setores,id',
        ]);

        $servidor->update($request->all());

        return redirect()->route('admin.servidores.index')
                         ->with('success', 'Servidor atualizado com sucesso.');
    }

    public function destroy(Servidor $servidor)
    {
        $servidor->delete();

        return redirect()->route('admin.servidores.index')->with('success', 'Servidor deletado com sucesso.');
    }

    public function meuPerfil()
    {
        $servidor = Servidor::where('user_id', auth()->id())->firstOrFail();
        return view('servidores.perfil', compact('servidor'));
    }

    public function meusAgendamentos()
    {
        $servidor = Servidor::where('user_id', auth()->id())->firstOrFail();
        $agendamentos = $servidor->agendamentos;
        return view('servidores.agendamentos', compact('agendamentos'));
    }

    public function meusRegistros()
    {
        $servidor = Servidor::where('user_id', auth()->id())->firstOrFail();
        $registros = $servidor->registros;
        return view('servidores.registros', compact('registros'));
    }

    private function verificarAutorizacao($servidor)
    {
        if (!auth()->user()->hasRole('admin') && 
            $servidor->user_id !== auth()->id()) {
            abort(403, 'Acesso não autorizado.');
        }
    }
}
