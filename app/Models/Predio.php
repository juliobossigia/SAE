<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predio extends Model
{
    use HasFactory;

    protected $table = 'predios';
 
    protected $fillable = ['nome'];

    public function locais()
    {
        return $this->hasMany(Local::class); // Um prédio pode ter várias salas (locais)
    }
}
