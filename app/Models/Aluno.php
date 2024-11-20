<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    protected $table = 'alunos';
    protected $fillable = [
        'nome',
        'email',
        'data_nascimento',
        'matricula',
        'turma_id',
        'curso_id',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function registros()
    {
        return $this->hasMany(Registro::class, 'aluno_id');
    }
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }


    /**
     * @property \Illuminate\Database\Eloquent\Collection|Responsavel[] $responsaveis
     */
    public function responsaveis()
    {
        return $this->belongsToMany(Responsavel::class, 'aluno_responsavel')
                    ->withTimestamps();
    }
}
