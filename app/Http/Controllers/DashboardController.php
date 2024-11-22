<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        return match($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'servidor' => redirect()->route('servidor.dashboard'),
            'docente' => redirect()->route('docente.dashboard'),
            'responsavel' => redirect()->route('responsavel.dashboard'),
            default => redirect()->route('login')
        };
    }

    public function admin()
    {
        return view('admin.dashboard');
    }

    public function servidor()
    {
        return view('servidor.dashboard');
    }

    public function docente()
    {
        return view('docente.dashboard');
    }

    public function responsavel()
    {
        return view('responsavel.dashboard');
    }
}
