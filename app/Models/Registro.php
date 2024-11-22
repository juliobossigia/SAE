<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';

    protected $fillable = [
        'data',
        'aluno_id',
        'turma_id',
        'tipo',
        'descricao',
        'encaminhado_para',
        'criado_por_id',
        'agendamento',
        'data_agendamento',
        'hora_agendamento',
        'participantes',
        'local_id'
    ];

    protected $with = ['aluno', 'turma', 'setor', 'local', 'criadoPor'];

    protected $casts = [
        'data' => 'date',
        'data_agendamento' => 'date',
        'hora_agendamento' => 'datetime',
        'agendamento' => 'boolean',
    ];

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'criado_por_id');
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'encaminhado_para');
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function agendamento()
    {
        return $this->hasOne(Agendamento::class);
    }
}
