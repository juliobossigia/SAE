<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Servidor extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'setor_id',
        // outros campos necessários
    ];

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
