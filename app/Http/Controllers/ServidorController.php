<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servidor;
use App\Models\Setor;
use App\Models\User;

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

        return view('servidores.index', compact('servidores', 'setores'));
    }

    public function create()
    {
        $setores = Setor::all();
        return view('servidores.create', compact('setores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'email' => 'required|email|unique:servidores',
            'cpf' => 'required|unique:servidores',
            'setor_id' => 'required|exists:setores,id',
            'password' => 'required|min:6',
        ]);

        // Criar o servidor
        $servidor = Servidor::create($request->except('password'));

        // Criar o usuário associado
        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_type' => 'App\Models\Servidor',
            'profile_id' => $servidor->id,
        ]);

        // Atribuir papel ao usuário
        $user->assignRole('servidor');

        return redirect()->route('servidores.index')
            ->with('success', 'Servidor criado com sucesso.');
    }

    public function show(string $id)
    {
        $servidor = Servidor::findOrFail($id);
        
        return view('servidores.show', compact('servidor'));
    }

    public function edit(string $id)
    {
        $servidor = Servidor::findOrFail($id);
        $setores = Setor::all();
        return view('servidores.edit', compact('servidor', 'setores'));
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

        return redirect()->route('servidores.index')
                         ->with('success', 'Servidor atualizado com sucesso.');
    }

    public function destroy(Servidor $servidor)
    {
        $servidor->delete();

        return redirect()->route('servidores.index')->with('success', 'Servidor deletado com sucesso.');
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
