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
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout',[App\Livewire\Actions\Logout::class, 'logout'])->name('logout');    
    
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

    // Adiciona a rota API para obter turmas por curso
    Route::get('/api/cursos/{curso}/turmas', [CursoController::class, 'getTurmas'])->name('api.cursos.turmas');
});

//ver depois
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

require __DIR__.'/auth.php';
