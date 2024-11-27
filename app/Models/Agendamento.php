<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Agendamento extends Model
{
    protected $fillable = [
        'registro_id',
        'data_agendamento',
        'hora_agendamento',
        'participantes',
        'local_id',
        'status' // Pendente, Confirmado, Cancelado, Realizado
    ];

    protected $dates = [
        'data_agendamento'
    ];

    protected $casts = [
        'data_agendamento' => 'datetime',
        'hora_agendamento' => 'datetime',
    ];

    public function registro(): BelongsTo
    {
        return $this->belongsTo(Registro::class);
    }

    public function local(): BelongsTo
    {
        return $this->belongsTo(Local::class);
    }
}
