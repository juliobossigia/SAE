<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('login');
        }

        // Se não foram passados roles, permite o acesso
        if (empty($roles)) {
            return $next($request);
        }

        // Verifica se o usuário tem algum dos roles especificados
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Se chegou aqui, o usuário não tem nenhum dos roles necessários
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        return redirect()
            ->route('/')
            ->with('error', 'Você não tem permissão para acessar esta página.');
    }
}