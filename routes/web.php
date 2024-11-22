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
    AdminController
};
use App\Livewire\Auth\RegisterForm;

// Rotas públicas
Route::view('/', 'welcome');
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
    Route::resource('registros', RegistroController::class);
});

// Rotas do Docente
Route::middleware(['auth', 'check.role:docente'])->prefix('docente')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'docente'])->name('docente.dashboard');
    Route::get('/perfil', [DocenteController::class, 'perfil'])->name('docente.perfil');
    Route::get('/agendamentos', [DocenteController::class, 'agendamentos'])->name('docente.agendamentos');
    Route::resource('registros', RegistroController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('agendamentos', AgendamentoController::class)->only(['index', 'show', 'create', 'store']);
});

// Rotas do Servidor
Route::middleware(['auth', 'check.role:servidor'])->prefix('servidor')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'servidor'])->name('servidor.dashboard');
    Route::get('/perfil', [ServidorController::class, 'meuPerfil'])->name('servidor.perfil');
    Route::get('/agendamentos', [ServidorController::class, 'meusAgendamentos'])->name('servidor.agendamentos');
    Route::get('/registros', [ServidorController::class, 'meusRegistros'])->name('servidor.registros');
    Route::resource('registros', RegistroController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('agendamentos', AgendamentoController::class)->only(['index', 'show', 'create', 'store']);
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
    Route::post('/logout', [App\Livewire\Actions\Logout::class, 'logout'])->name('logout');
    
    // Rota API para obter turmas por curso
    Route::get('/api/cursos/{curso}/turmas', [CursoController::class, 'getTurmas'])->name('api.cursos.turmas');
    
    // Rota de busca de registros
    Route::get('registros/search', [RegistroController::class, 'search'])->name('registros.search');
});

Route::get('/register', RegisterForm::class)->name('register')->middleware('guest');

require __DIR__.'/auth.php';
