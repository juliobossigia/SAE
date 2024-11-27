<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        try {
            $this->validate();

            $this->form->authenticate();

            Session::regenerate();
            
            // Força o redirecionamento sem usar navigate
            $this->redirect(route($this->form->redirectTo));
            
        } catch (\Exception $e) {
            \Log::error('Erro no login:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            session()->flash('error', 'Erro ao realizar login: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Tipo de Usuário -->
        <div class="mt-4">
            <x-input-label for="tipo_usuario" :value="__('Tipo de Usuário')" />
            <select wire:model="form.tipo_usuario" id="tipo_usuario" class="block mt-1 w-full rounded-md border-gray-300">
                <option value="">Selecione o tipo de usuário</option>
                <option value="admin">Administrador</option>
                <option value="servidor">Servidor</option>
                <option value="docente">Docente</option>
                <option value="responsavel">Responsável</option>
            </select>
            <x-input-error :messages="$errors->get('form.tipo_usuario')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar usuario') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" wire:loading.attr="disabled">
                <span wire:loading wire:target="login">
                    {{ __('Entrando...') }}
                </span>
                <span wire:loading.remove>
                    {{ __('Entrar') }}
                </span>
            </x-primary-button>
        </div>
    </form>
</div>
