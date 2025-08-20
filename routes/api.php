<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\CursoController;
use App\Http\Controllers\Api\AulaController;
use App\Http\Controllers\Api\MatriculaController;
use App\Http\Controllers\Api\AvaliacoController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RelatoriosController;
use App\Models\Avaliaco;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);

Route::post('/register',[UserController::class,'store']);

Route::post('/login',[UserController::class,'login']);

Route::post('/logout',function(Request $request){

    $request->user()->currentAccessToken()->delete();

    return ['message'=>'Usuario deslogado'];
})->middleware('auth:sanctum');

Route::apiResource('cursos', CursoController::class)->only(['index']);

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('cursos', CursoController::class)->only(['store'])->middleware('instrutor');
    Route::apiResource('cursos', CursoController::class)->except(['index','store']);
});

Route::post('/cursos/{id}/aulas',[AulaController::class,'store'])->middleware(['auth:sanctum','instrutor']);

Route::get('/cursos/{curso}/aulas',[AulaController::class,'show']);

Route::apiResource('aulas', AulaController::class)->only(['destroy'])->middleware('auth:sanctum');

Route::post('/cursos/{curso}/matricular',[MatriculaController::class,'store'])->middleware('auth:sanctum');

Route::get('/meus-cursos',[MatriculaController::class,'index'])->middleware('auth:sanctum');

Route::put('/matriculas/{matricula}/status',[MatriculaController::class,'update'])->middleware(['auth:sanctum','admin']);

Route::post('/cursos/{curso}/avaliar',[AvaliacoController::class,'store'])->middleware(['auth:sanctum']);

Route::get('/cursos/{curso}/avaliacoes',[AvaliacoController::class,'show'])->middleware(['auth:sanctum']);

Route::get('/relatorios/matriculas-mensais',[RelatoriosController::class,'mensais'])->middleware(['auth:sanctum','admin']);

Route::get('/relatorios/faturamento-mensal',[RelatoriosController::class,'faturamentos_mensais'])->middleware(['auth:sanctum','admin']);

Route::get('/relatorios/engajamento-alunos',[RelatoriosController::class,'engajamento'])->middleware(['auth:sanctum','admin']);

Route::post('/aulas/{aula}/material',[FileController::class,'upload'])->middleware(['auth:sanctum','instrutor']);

Route::get('/aulas/{aula}/materiais',[FileController::class,'list'])->middleware(['auth:sanctum']);