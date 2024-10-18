<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;
    protected $table = 'disciplinas';
    
    protected $fillable = [
        'nome',
        'departamento_id',
        'docente_id',
        
    ];
    public function departamento(){
        return $this->belongsTo(Departamento::class);

    }

    public function docentes(){
        return $this->belongsToMany(Docente::class, 'disciplina_docente');
    }
} 