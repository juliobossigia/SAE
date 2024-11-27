<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servidor extends Model
{
    protected $table = 'servidores';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'setor_id',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }
}
