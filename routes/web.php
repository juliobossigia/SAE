<?php

use App\Http\Controllers\AlunoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::view('/', 'welcome');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/logout',[App\Livewire\Actions\Logout::class, 'logout'])->name('logout');    
    
Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index'])->middleware(['auth'])->name('dashboard');
    Route::resource('alunos', AlunoController::class);
});

require __DIR__.'/auth.php';
