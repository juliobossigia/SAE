<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'participantes',
        'local_agendamento',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function criador()
    {
        return $this->belongsTo(User::class, 'criado_por_id');
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class, 'encaminhado_para');
    }

    public function agendamento()
    {
        return $this->hasOne(Agendamento::class);
    }
}
