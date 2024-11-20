<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'departamento_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
