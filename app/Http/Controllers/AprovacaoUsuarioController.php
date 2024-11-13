<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AprovacaoUsuarioController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pendente')->with('roles')->get();
        return view('usuarios-pendentes', compact('pendingUsers'));

    }

    public function approve(User $user)
    {
        $role = $user->roles->first();

        $user->update(['status' => 'aprovado']);

        
        if ($role->name === 'docente') {
            $user->docente()->create([
                'nome' => $user->name,
                'email' => $user->email,
                'status' => 'ativo'
                
            ]);
        } elseif ($role->name === 'servidor') {
            $user->servidor()->create([
                'nome' => $user->name,
                'email' => $user->email,
                'status' => 'ativo'
                
            ]);
        }

        return redirect()->route('usuarios-pendentes')
            ->with('success', 'Usuário aprovado com sucesso!');
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejeitado']);
        return redirect()->route('usuarios-pendentes')
            ->with('success', 'Usuário rejeitado com sucesso!');
    }
}