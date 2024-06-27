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

    public function turma(){
        return $this->belongsTo(Turma::class);
    }
    
    public function curso(){
        return $this->belongsTo(Curso::class);
    }
}
