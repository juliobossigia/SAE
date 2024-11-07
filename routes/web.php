<?php
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\CadastroController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;



Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout',[App\Livewire\Actions\Logout::class, 'logout'])->name('logout'); 

Route::get('/registro', [CadastroController::class, 'showRegistrationForm'])->name('registro');
Route::post('/registro', [CadastroController::class, 'store'])->name('registro.store');

    
Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');
    Route::resource('alunos', AlunoController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('cursos', CursoController::class);
    Route::resource('turmas', TurmaController::class);
    Route::resource('setores', SetorController::class);
    Route::resource('disciplinas', DisciplinaController::class);
    Route::resource('servidores', ServidorController::class);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('locais', LocalController::class);
    Route::resource('predios', PredioController::class);
    Route::get('/admin/peding-registrations', [CadastroController::class, 'index'])->name('admin.peding-registrations');
    Route::post('/pending-registrations/{registro}/approve', [CadastroController::class, 'approve'])->name('registro.approve');
    Route::post('/pending-registrations/{registro}/reject', [CadastroController::class, 'reject'])->name('registro.reject');
    Route::resource('registros', RegistroController::class);
    Route::get('registros/search', [RegistroController::class, 'search'])->name('registros.search');
    Route::resource('agendamentos', AgendamentoController::class);
   


    // Adiciona a rota API para obter turmas por curso
    Route::get('/api/cursos/{curso}/turmas', [CursoController::class, 'getTurmas'])->name('api.cursos.turmas');
});

Route::middleware(['auth', 'role:docente'])->group(function () {
    Route::get('/docente/perfil', [DocenteController::class, 'perfil']);
    Route::get('/docente/agendamentos', [DocenteController::class, 'agendamentos']);
    });

Route::middleware(['auth', 'role:servidor'])->group(function () {
        Route::get('/servidor/perfil', [DocenteController::class, 'perfil']);
        Route::get('/servidor/agendamentos', [DocenteController::class, 'agendamentos']);
    });  

// Rota que aceita múltiplos roles
//Route::get('/dashboard', function () {
  //  return view('dashboard');
//})->middleware(['auth', 'role:admin,docente,servidor']);      

//ver depois
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

require __DIR__.'/auth.php';
