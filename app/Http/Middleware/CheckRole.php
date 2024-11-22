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

        if (empty($roles)) {
            return $next($request);
        }

        if ($request->user()->hasAnyRole($roles)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Acesso não autorizado.'], 403);
        }

        return redirect()
            ->route('/')
            ->with('error', 'Você não tem permissão para acessar esta página.');
    }
}