<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $table = 'turmas';
    
    protected $fillable=['ano','letra','curso_id'];

    public function alunos(){
        return $this->hasMany(Aluno::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function getNomeAttribute(){
        return "{$this->ano}°{$this->letra}";
    }

}
