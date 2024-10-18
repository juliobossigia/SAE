<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class RegistroPendente extends Model
{
    use HasFactory;

    protected $table = 'registro_pendentes';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'password',
        'type',
        'data_nascimento',
        'departamento_id',
        'setor_id',
        'status'
    ];

    protected $hidden = [
        'password',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }
}
