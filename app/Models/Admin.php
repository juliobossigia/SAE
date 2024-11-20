<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cpf',
        'telefone',
        'status',
        'ultimo_acesso'
    ];

    protected $dates = [
        'ultimo_acesso',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para atualizar último acesso
    public function registrarAcesso()
    {
        $this->update([
            'ultimo_acesso' => now()
        ]);
    }

    // Método para ativar/inativar
    public function toggleStatus()
    {
        $this->update([
            'status' => $this->status === 'ativo' ? 'inativo' : 'ativo'
        ]);
    }
}
