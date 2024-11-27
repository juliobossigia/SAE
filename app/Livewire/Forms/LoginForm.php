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
use Spatie\Permission\Models\Role;

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
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
            'tipo_usuario' => $this->tipo_usuario
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Define o redirecionamento com base no tipo de usuário
        $this->redirectTo = match ($this->tipo_usuario) {
            'admin' => 'admin.dashboard',
            'servidor' => 'servidor.dashboard',
            'docente' => 'docente.dashboard',
            'responsavel' => 'responsavel.dashboard',
            default => '/'
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
