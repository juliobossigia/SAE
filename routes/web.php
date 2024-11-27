<?php

// Importações dos Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DocenteController,
    AlunoController,
    TurmaController,
    CursoController,
    SetorController,
    ServidorController,
    DashboardController,
    DisciplinaController,
    DepartamentoController,
    LocalController,
    PredioController,
    RegistroController,
    AgendamentoController,
    CadastroController,
    ResponsavelController,
    AdminController,
    
};
use App\Http\Controllers\Admin\AlunoResponsavelController; // Adicione este import no topo

use App\Livewire\Auth\RegisterForm;

// Rotas públicas
Route::view('/', 'welcome')->name('welcome');
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Rotas do Administrador
Route::middleware(['web', 'auth', 'check.role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resources([
        'alunos' => AlunoController::class,
        'docentes' => DocenteController::class,
        'turmas' => TurmaController::class,
        'cursos' => CursoController::class,
        'servidores' => ServidorController::class,
        'setores' => SetorController::class,
        'disciplinas' => DisciplinaController::class,
        'departamentos' => DepartamentoController::class,
        'predios' => PredioController::class,
        'locais' => LocalController::class,
        'registros' => RegistroController::class,
        'agendamentos' => AgendamentoController::class
    ]);
    Route::get('/pending-registrations', [AdminController::class, 'pendingRegistrations'])
        ->name('pending-registrations');
    Route::post('/approve-registration/{id}', [AdminController::class, 'approveRegistration'])
        ->name('approve-registration');
    Route::post('/reject-registration/{id}', [AdminController::class, 'rejectRegistration'])
        ->name('reject-registration');
    Route::resource('registros', RegistroController::class);
    Route::get('/aluno-responsavel/create', [AlunoResponsavelController::class, 'create'])
         ->name('aluno-responsavel.create');
    Route::post('/aluno-responsavel', [AlunoResponsavelController::class, 'store'])
         ->name('aluno-responsavel.store');
    Route::get('/admin/turmas-por-curso/{curso}', [RegistroController::class, 'getTurmasPorCurso'])->name('admin.turmas-por-curso');
    Route::get('/admin/alunos-por-turma/{turma}', [RegistroController::class, 'getAlunosPorTurma'])->name('admin.alunos-por-turma');
});

// Rotas do Docente 
Route::middleware(['auth', 'check.role:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'docente'])->name('dashboard');
    Route::get('/perfil', [DocenteController::class, 'perfil'])->name('perfil');
    
    // Rotas de registros
    Route::get('/registros', [DocenteController::class, 'listarRegistros'])->name('registros.index');
    Route::get('/registros/create', [DocenteController::class, 'registros'])->name('registros.create');
    Route::post('/registros', [DocenteController::class, 'storeRegistro'])->name('registros.store');
    Route::get('/registros/{registro}', [DocenteController::class, 'showRegistro'])->name('registros.show');
    Route::get('/registros/{registro}/edit', [DocenteController::class, 'editRegistro'])->name('registros.edit');
    Route::put('/registros/{registro}', [DocenteController::class, 'updateRegistro'])->name('registros.update');
    Route::delete('/registros/{registro}', [DocenteController::class, 'destroyRegistro'])->name('registros.destroy');
    
    // Rotas de agendamentos
    Route::get('/agendamentos', [DocenteController::class, 'agendamentos'])->name('agendamentos.index');
}); 
  
// Rotas do Servidor
Route::middleware(['auth', 'check.role:servidor'])->prefix('servidor')->name('servidor.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'servidor'])->name('dashboard');
    Route::get('/perfil', [ServidorController::class, 'meuPerfil'])->name('perfil');
    
    // Rotas de registros - usando ServidorController ao invés de RegistroController
    Route::get('/registros', [ServidorController::class, 'meusRegistros'])->name('registros.index');
    Route::get('/registros/create', [ServidorController::class, 'createRegistro'])->name('registros.create');
    Route::post('/registros', [ServidorController::class, 'storeRegistro'])->name('registros.store');
    Route::get('/registros/{registro}', [ServidorController::class, 'showRegistro'])->name('registros.show');
    
    // Rotas de agendamentos
    Route::get('/agendamentos', [ServidorController::class, 'meusAgendamentos'])->name('agendamentos.index');
    Route::resource('agendamentos', AgendamentoController::class)->only(['show', 'create', 'store']);
});

// Rotas do Responsável
Route::middleware(['auth', 'check.role:responsavel'])->prefix('responsavel')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'responsavel'])->name('responsavel.dashboard');
    Route::get('/perfil', [ResponsavelController::class, 'meuPerfil'])->name('responsavel.perfil');
    Route::get('/alunos', [ResponsavelController::class, 'meusAlunos'])->name('responsavel.alunos');
    Route::get('/aluno/{aluno}/registros', [ResponsavelController::class, 'verRegistrosAluno'])->name('responsavel.aluno.registros');
    Route::get('/aluno/{aluno}/agendamentos', [ResponsavelController::class, 'verAgendamentosAluno'])->name('responsavel.aluno.agendamentos');
});

// Rotas comuns para usuários autenticados
Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    Route::post('/logout', function () {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    })->name('logout');
    
    // Rota API para obter turmas por curso
    Route::get('/api/cursos/{curso}/turmas', [CursoController::class, 'getTurmas'])->name('api.cursos.turmas');
    
    // Rota de busca de registros
    Route::get('registros/search', [RegistroController::class, 'search'])->name('registros.search');
});

Route::get('/register', RegisterForm::class)->name('register')->middleware('guest');

require __DIR__.'/auth.php';
