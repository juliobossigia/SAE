<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'departamento_id',
        'data_nascimento',
        'is_coordenador',
        'curso_id',
        'status',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'is_coordenador' => 'boolean',
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    public function registros()
    {
        return $this->hasMany(Registro::class, 'criado_por_id', 'id');
    }
}
