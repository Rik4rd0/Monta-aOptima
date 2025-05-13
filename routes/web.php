<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OptimizadorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/optimizador', [OptimizadorController::class, 'index'])->name('optimizador.index');
Route::post('/optimizador/calcular', [OptimizadorController::class, 'calcular'])->name('optimizador.calcular');
