<?php

namespace App\Livewire\Forms;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('required|in:servidor,docente,admin,responsavel')]
    public string $tipo_usuario = '';

    #[Validate('boolean')]
    public bool $remember = false;

    public ?string $redirectTo = null;

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // Log para debug
        Log::info('Tentativa de login', [
            'email' => $this->email,
            'tipo_usuario' => $this->tipo_usuario
        ]);

        // Primeiro tenta autenticar
        if (!Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        // Depois verifica o role
        $user = Auth::user();
        
        // Log para debug
        Log::info('Usuário autenticado', [
            'user_id' => $user->id,
            'roles' => $user->roles()->pluck('nome')->toArray()
        ]);

        if (!$user->hasRole($this->tipo_usuario)) {
            Auth::logout();
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'form.tipo_usuario' => 'Tipo de usuário inválido para este login.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Define o redirecionamento baseado no tipo de usuário
        $this->redirectTo = match($this->tipo_usuario) {
            'admin' => '/admin/dashboard',
            'docente' => '/docente/dashboard',
            'servidor' => '/servidor/dashboard',
            'responsavel' => '/responsavel/dashboard',
            default => '/dashboard'
        };
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}
