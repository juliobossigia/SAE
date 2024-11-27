<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Setor;
use App\Models\Local;
use Illuminate\Support\Facades\Auth;

class RegistroForm extends Component
{
    public $userType;
    public $cursos;
    public $turmas = [];
    public $alunos = [];
    public $setores;
    public $locais;
    
    // Campos do formulário
    public $curso_id = '';
    public $turma_id = '';
    public $aluno_id = '';
    public $tipo = 'Advertência';
    public $encaminhado_para = '';
    public $descricao = '';
    public $data;
    public $agendamento = false;
    public $data_agendamento;
    public $hora_agendamento;
    public $participantes;
    public $local_id;
    
    public function mount($userType = null)
    {
        $this->userType = $userType;
        $this->cursos = Curso::orderBy('nome')->get();
        $this->setores = Setor::all();
        $this->locais = Local::with('predio')->get();
        $this->data = date('Y-m-d');
    }
    
    public function updatedCursoId($value)
    {
        $this->turmas = Turma::where('curso_id', $value)->get();
        $this->turma_id = '';
        $this->aluno_id = '';
        $this->alunos = [];
    }
    
    public function updatedTurmaId($value)
    {
        $this->alunos = Aluno::where('turma_id', $value)->get();
        $this->aluno_id = '';
    }

    public function salvar()
    {
        $validated = $this->validate([
            'data' => 'required|date',
            'aluno_id' => 'nullable|exists:alunos,id',
            'turma_id' => 'nullable|exists:turmas,id',
            'tipo' => 'required|in:Advertência,Registro Disciplinar,Nota NAI,Registro Pedagogico',
            'descricao' => 'required|string',
            'encaminhado_para' => 'required|exists:setores,id',
            'agendamento' => 'boolean',
            'data_agendamento' => 'required_if:agendamento,true|nullable|date',
            'hora_agendamento' => 'required_if:agendamento,true|nullable|date_format:H:i',
            'participantes' => 'required_if:agendamento,true|nullable|string',
            'local_id' => 'required_if:agendamento,true|nullable|exists:locais,id'
        ]);

        try {
            // Cria o registro primeiro
            $registroData = [
                'data' => $validated['data'],
                'aluno_id' => $validated['aluno_id'],
                'turma_id' => $validated['turma_id'],
                'tipo' => $validated['tipo'],
                'descricao' => $validated['descricao'],
                'encaminhado_para' => $validated['encaminhado_para'],
                'agendamento' => $validated['agendamento'],
                'criado_por_id' => Auth::id(),
            ];
            
            $registro = \App\Models\Registro::create($registroData);

            // Se tiver agendamento, cria o registro de agendamento
            if ($validated['agendamento']) {
                $registro->agendamento()->create([
                    'data_agendamento' => $validated['data_agendamento'],
                    'hora_agendamento' => $validated['hora_agendamento'],
                    'participantes' => $validated['participantes'],
                    'local_id' => $validated['local_id'],
                    'status' => 'Pendente'
                ]);
            }

            // Redireciona baseado no tipo de usuário
            $route = match($this->userType) {
                'servidor' => 'servidor.registros.show',
                'docente' => 'docente.registros.show',
                'admin' => 'admin.registros.show'
            };

            return redirect()->route($route, $registro)
                ->with('success', 'Registro criado com sucesso!');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar registro: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.registro-form');
    }
}