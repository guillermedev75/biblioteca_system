<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\EditoraController;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmprestimoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Generos
Route::get('/generos', [GeneroController::class, 'index']);
Route::post('/generos', [GeneroController::class, 'store']);
Route::put('/generos/{id}', [GeneroController::class, 'update']);
Route::delete('/generos/{id}', [GeneroController::class, 'destroy']);

//Autores
Route::get('/autores', [AutorController::class, 'index']);
Route::post('/autores', [AutorController::class, 'store']);
Route::put('/autores/{id}', [AutorController::class, 'update']);
Route::delete('/autores/{id}', [AutorController::class, 'destroy']);

//Editoras
Route::get('/editoras', [EditoraController::class, 'index']);
Route::post('/editoras', [EditoraController::class, 'store']);
Route::put('/editoras/{id}', [EditoraController::class, 'update']);
Route::delete('/editoras/{id}', [EditoraController::class, 'destroy']);

//Livros
Route::get('/livros', [LivroController::class, 'index']);
Route::post('/livros', [LivroController::class, 'store']);
Route::put('/livros/{id}', [LivroController::class, 'update']);
Route::delete('/livros/{id}', [LivroController::class, 'destroy']);
//Estoque
Route::get('/livros/estoque', [EstoqueController::class, 'index']);
Route::post('/livros/estoque', [EstoqueController::class, 'store']);
Route::put('/livros/estoque/{id}', [EstoqueController::class, 'update']);
Route::delete('/livros/estoque/{id}', [EstoqueController::class, 'destroy']);

//Clientes
Route::get('/clientes',[ClienteController::class, 'index']);
Route::post('/clientes',[ClienteController::class, 'store']);
Route::put('/clientes/{id}',[ClienteController::class, 'update']);
Route::delete('/clientes/{id}',[ClienteController::class, 'destroy']);

//Emprestimo
Route::get('/emprestimos', [EmprestimoController::class, 'index']);
Route::post('/emprestimos', [EmprestimoController::class, 'store']);
Route::put('/emprestimos/{id}', [EmprestimoController::class, 'update']);
Route::delete('/emprestimos/{id}', [EmprestimoController::class, 'destroy']);