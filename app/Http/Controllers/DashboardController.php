<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;
use App\Models\Agendamento;

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
        $servidor = auth()->user()->profile;
        
        // Busca os registros do servidor
        $totalRegistros = Registro::where('criado_por_id', auth()->id())->count();
        
        // Busca os registros recentes
        $registrosRecentes = Registro::with(['aluno', 'turma'])
            ->where('criado_por_id', auth()->id())
            ->latest('data')
            ->take(5)
            ->get();
        
        // Busca os agendamentos pendentes
        $agendamentosPendentes = Agendamento::whereHas('registro', function($query) {
            $query->where('criado_por_id', auth()->id());
        })
        ->where('status', 'Pendente')
        ->count();
        
        // Busca os próximos agendamentos
        $proximosAgendamentos = Agendamento::with(['local', 'registro'])
            ->whereHas('registro', function($query) {
                $query->where('criado_por_id', auth()->id());
            })
            ->where('data_agendamento', '>=', now())
            ->orderBy('data_agendamento')
            ->take(5)
            ->get();
        
        // Busca o setor do servidor
        $setor = $servidor->setor;
        
        return view('servidor.dashboard', compact(
            'totalRegistros',
            'registrosRecentes',
            'agendamentosPendentes',
            'proximosAgendamentos',
            'setor'
        ));
    }

    public function docente()
    {
        try {
            $userId = auth()->id();
            
            // Debug para verificar o ID do usuário
            \Log::info('User ID: ' . $userId);
            
            // Contagem de registros
            $totalRegistros = Registro::where('criado_por_id', $userId)->count();
            
            // Debug para verificar a contagem
            \Log::info('Total Registros: ' . $totalRegistros);
            
            // Contagem de agendamentos
            $totalAgendamentos = Registro::where('criado_por_id', $userId)
                ->where('agendamento', true)
                ->count();
                
            // Debug para verificar a contagem de agendamentos
            \Log::info('Total Agendamentos: ' . $totalAgendamentos);

            return view('docente.dashboard', compact('totalRegistros', 'totalAgendamentos'));
            
        } catch (\Exception $e) {
            \Log::error('Erro no dashboard: ' . $e->getMessage());
            return view('docente.dashboard', [
                'totalRegistros' => 0,
                'totalAgendamentos' => 0
            ])->with('error', 'Erro ao carregar dados do dashboard');
        }
    }

    public function responsavel()
    {
        return view('responsavel.dashboard');
    }
}
