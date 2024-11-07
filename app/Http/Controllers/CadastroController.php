<?php

namespace App\Http\Controllers;

use App\Models\RegistroPendente;
use App\Models\Docente;
use App\Models\Servidor;
use App\Models\User;
use App\Models\Departamento;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class CadastroController extends Controller
{
    public function showRegistrationForm()
    {
        $departamentos = Departamento::all();
        $setores = Setor::all();
        return view('registro', compact('departamentos', 'setores') );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:registro_pendentes,email|unique:users,email',
            'password' => 'required|min:8',
            'cpf' => 'required|unique:registro_pendentes,cpf',
            'type' => 'required|in:docente,servidor',
            'data_nascimento' => 'required_if:type,docente|date|nullable',
            'departamento_id' => 'required_if:type,docente|exists:departamentos,id|nullable',
            'setor_id' => 'required_if:type,servidor|exists:setores,id|nullable',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        RegistroPendente::create($validated);

        return redirect()->back()->with('success', 'Cadastro enviado com sucesso! Aguarde a aprovação do administrador.');
    }

    public function approve(RegistroPendente $registro)
    {
        try {
            DB::beginTransaction();

            // Criar usuário
            $user = User::create([
                'name' => $registro->nome,
                'email' => $registro->email,
                'password' => $registro->password,
                'role' => $registro->type,
            ]);

            // Criar docente ou servidor baseado no typee
            if ($registro->type === 'docente') {
                Docente::create([
                    'nome' => $registro->nome,
                    'email' => $registro->email,
                    'cpf' => $registro->cpf,
                    'data_nascimento' => $registro->data_nascimento,
                    'departamento_id' => $registro->departamento_id,
                ]);
            } else {
                Servidor::create([
                    'nome' => $registro->nome,
                    'email' => $registro->email,
                    'cpf' => $registro->cpf,
                    'setor_id' => $registro->setor_id,
                ]);
            }

            $registro->update(['status' => 'approved']);
            
            DB::commit();
            return redirect()->back()->with('success', 'Registro aprovado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao aprovar registro: ' . $e->getMessage());
        }
    }

    public function reject(RegistroPendente $registro)
    {
        $registro->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Registro rejeitado com sucesso!');
    }

    public function index()
    {
        try {
            $registrosPendentes = RegistroPendente::where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('admin.peding-registrations', [
                'registrosPendentes' => $registrosPendentes
            ]);
        } catch (\Exception $e) {
            return view('admin.peding-registrations', [
                'registrosPendentes' => collect([]),
                'error' => 'Erro ao carregar registros pendentes: ' . $e->getMessage()
            ]);
        }
    }
}