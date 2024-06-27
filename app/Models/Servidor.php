<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    use HasFactory;
    
    protected $table = 'servidores';

    protected $fillable = ['nome','email','cpf','setor_id'];

    public function setor(){
        return $this->belongsTo(Setor::class);
    }


}
