<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class RegisterForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $tipo_usuario;
    public $cpf;

    // Adicione regras de validação em tempo real
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'tipo_usuario' => 'required|in:docente,servidor,responsavel',
            'cpf' => 'required|string|size:11|unique:users',
        ];
    }

    // Validação em tempo real
    public function updated($propertyName)
    {
        try {
            if ($propertyName === 'cpf') {
                $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
            }
            $this->validateOnly($propertyName);
        } catch (Exception $e) {
            // Log do erro para debug
            \Log::error('Erro na validação: ' . $e->getMessage());
        }
    }

    public function register()
    {
        try {
            // Limpa o CPF
            $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
            
            // Valida os dados
            $validatedData = $this->validate();
            
            DB::beginTransaction();

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'cpf' => $this->cpf,
                'status' => 'pendente'
            ]);

            if (!$user) {
                throw new Exception('Erro ao criar usuário');
            }

            $user->assignRole($this->tipo_usuario);

            DB::commit();

            session()->flash('success', 'Cadastro realizado com sucesso! Aguarde a aprovação do administrador.');
            return redirect()->route('login');

        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao realizar cadastro: ' . $e->getMessage());
            \Log::error('Erro no registro: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-form')
            ->layout('layouts.guest');
    }
}