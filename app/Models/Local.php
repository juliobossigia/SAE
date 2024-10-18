<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    use HasFactory;
    
    protected $table = 'locais';

    protected $fillable = ['predio_id', 'tipo_local', 'numero']; // Referenciando a chave estrangeira para o prédio

    public function predio()
    {
        return $this->belongsTo(Predio::class); // Ligando Local a um Prédio
    }
}
