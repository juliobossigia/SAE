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
        'telefone'
    ];

    protected $casts = [
        'nome' => 'string',
        'email' => 'string',
        'cpf' => 'string',
        'telefone' => 'string'
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_responsavel')
                    ->withTimestamps();
    }
}
