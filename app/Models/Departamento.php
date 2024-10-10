<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
     
    protected $fillable=['nome'];

    // Relacionamento com Docentes
    public function docentes()
    {
        return $this->hasMany(Docente::class); // Um departamento tem muitos docentes
    }

    // Relacionamento com Disciplinas
    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class); // Um departamento tem muitas disciplinas
    }
}
