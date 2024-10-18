<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('nome', $role)->exists();
    }

     // Verifica se o usuário tem qualquer um dos roles fornecidos
     public function hasAnyRole($roles)
     {
         return $this->roles()->whereIn('nome', (array) $roles)->exists();
     }
 
     // Verifica se o usuário tem todos os roles fornecidos
     public function hasAllRoles($roles)
     {
         $roles = (array) $roles;
         return $this->roles()->whereIn('nome', $roles)->count() === count($roles);
     }
 
     // Adiciona um role ao usuário
     public function assignRole($role)
     {
         if (is_string($role)) {
             $role = Role::whereName($role)->firstOrFail();
         }
         $this->roles()->syncWithoutDetaching($role);
     }
 
     // Remove um role do usuário
     public function removeRole($role)
     {
         if (is_string($role)) {
             $role = Role::whereName($role)->firstOrFail();
         }
         $this->roles()->detach($role);
     }
 
    public function docente()
    {
        return $this->hasOne(Docente::class);
    }

    public function servidor()
    {
        return $this->hasOne(Servidor::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
