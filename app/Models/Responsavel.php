<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    protected $table = 'responsaveis';
    
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_responsavel')
                    ->withTimestamps();
    }
}
