<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoinhosController;
use App\Http\Controllers\AgendadoController;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\DiferencaMoinhosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/moinhos', [MoinhosController::class, 'dados']);
Route::get('/moinhos/diferenca', [DiferencaMoinhosController::class, 'diferenca']);
Route::post('/moinhos/atualiza', [DiferencaMoinhosController::class, 'atualizaDados']);
Route::post('/moinhos/agendar', [AgendadoController::class, 'agendar']);
Route::post('/moinhos/cancelar', [AgendadoController::class, 'agendarCancelar']);
Route::post('/moinhos/atendimento', [AtendimentoController::class, 'atendimento']);
