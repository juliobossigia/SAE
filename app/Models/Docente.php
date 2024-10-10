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
        'data_nascimento',
        'cpf',
        'departamento_id',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
    
    // Um docente pode ter muitas disciplinas
    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_docente');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function isCoordenador()
    {
        return $this->is_coordenador;
    }
}
