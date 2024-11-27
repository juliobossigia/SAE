<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Servidor;
use App\Models\Setor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Docente;
use App\Models\Departamento;
use App\Models\Curso;
use App\Models\Responsavel;

class RegisterForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $tipo_usuario;
    public $cpf;
    public $departamento_id;
    public $data_nascimento;
    public $is_coordenador = false;
    public $curso_id;
    public $matricula;
    public $titulacao;
    public $area_atuacao;
    public $setor_id;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'tipo_usuario' => 'required|in:docente,servidor,responsavel',
            'cpf' => 'required|string|size:11|unique:users,cpf',
        ];

        if ($this->tipo_usuario === 'docente') {
            $rules['departamento_id'] = 'required|exists:departamentos,id';
            $rules['data_nascimento'] = 'required|date';
            
            if ($this->is_coordenador) {
                $rules['curso_id'] = 'required|exists:cursos,id';
            }
        }

        if ($this->tipo_usuario === 'servidor') {
            $rules['setor_id'] = 'required|exists:setores,id';
        }

        return $rules;
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'cpf') {
            $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
        }
        $this->validateOnly($propertyName);
    }

    public function register()
    {
        \Log::info('Método register chamado', [
            'tipo_usuario' => $this->tipo_usuario,
            'setor_id' => $this->setor_id
        ]);

        try {
            \Log::info('Iniciando registro:', [
                'tipo_usuario' => $this->tipo_usuario,
                'setor_id' => $this->setor_id,
                'name' => $this->name,
                'email' => $this->email
            ]);

            $this->cpf = preg_replace('/[^0-9]/', '', $this->cpf);
            
            $validatedData = $this->validate();
            \Log::info('Dados validados com sucesso');
            
            DB::beginTransaction();

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'cpf' => $this->cpf,
                'status' => 'pendente',
                'tipo_usuario' => $this->tipo_usuario
            ]);

            \Log::info('Usuário criado:', ['user_id' => $user->id]);

            if ($this->tipo_usuario === 'docente') {
                $docente = Docente::create([
                    'nome' => $this->name,
                    'email' => $this->email,
                    'cpf' => $this->cpf,
                    'departamento_id' => $this->departamento_id,
                    'data_nascimento' => $this->data_nascimento,
                    'status' => false
                ]);

                \Log::info('Docente criado:', ['docente_id' => $docente->id]);

                // Estabelecer o relacionamento polimórfico
                $user->profile()->associate($docente);
                $user->save();

                \Log::info('Relacionamento estabelecido');
            }
            elseif ($this->tipo_usuario === 'servidor') {
                $servidor = Servidor::create([
                    'nome' => $this->name,
                    'email' => $this->email,
                    'cpf' => $this->cpf,
                    'setor_id' => $this->setor_id,
                    'status' => false
                ]);

                \Log::info('Servidor criado:', ['servidor_id' => $servidor->id]);

                // Estabelecer o relacionamento polimórfico
                $user->profile()->associate($servidor);
                $user->save();

                \Log::info('Relacionamento estabelecido');
            }
            elseif ($this->tipo_usuario === 'responsavel') {
                $responsavel = Responsavel::create([
                    'nome' => $this->name,
                    'email' => $this->email,
                    'cpf' => $this->cpf,
                    'telefone' => null,
                    'status' => false
                ]);

                \Log::info('Responsável criado:', ['responsavel_id' => $responsavel->id]);

                // Estabelecer o relacionamento polimórfico
                $user->profile()->associate($responsavel);
                $user->save();

                \Log::info('Relacionamento estabelecido para responsável');
            }

            $user->assignRole($this->tipo_usuario);
            \Log::info('Role atribuída');

            DB::commit();
            \Log::info('Transação commitada com sucesso');

            session()->flash('success', 'Cadastro realizado com sucesso! Aguarde a aprovação do administrador.');
            return redirect()->route('login');

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Erro no registro:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'tipo_usuario' => $this->tipo_usuario,
                    'setor_id' => $this->setor_id,
                    'name' => $this->name,
                    'email' => $this->email
                ]
            ]);
            
            session()->flash('error', 'Erro ao realizar cadastro: ' . $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.auth.register-form', [
            'departamentos' => Departamento::orderBy('nome')->get(),
            'cursos' => Curso::orderBy('nome')->get(),
            'setores' => Setor::orderBy('nome')->get(),
        ])->layout('layouts.guest');
    }

    public function updatedTipoUsuario($value)
    {
        if ($value === 'docente') {
            \Log::info('Departamentos disponíveis:', ['departamentos' => Departamento::all()->toArray()]);
        }
        if ($value === 'servidor') {
            \Log::info('Setores disponíveis:', ['setores' => Setor::all()->toArray()]);
        }
    }

    public function updatedSetorId($value)
    {
        \Log::info('Setor atualizado:', [
            'setor_id' => $value,
            'tipo_usuario' => $this->tipo_usuario
        ]);
    }
}