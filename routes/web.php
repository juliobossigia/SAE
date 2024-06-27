<?php
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\SetorController;
use App\Http\Controllers\ServidorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Setor;
use App\Models\Turma;
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
    Route::resource('servidores', ServidorController::class);
});

//ver depois
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

require __DIR__.'/auth.php';
