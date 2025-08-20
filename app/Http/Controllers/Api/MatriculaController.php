<?php

namespace App\Http\Controllers\Api;

use App\Models\Matricula;
use Illuminate\Http\Request;
use App\Http\Requests\MatriculaRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MatriculaResource;
use App\Models\Curso;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user()->id;

        $matriculas = Matricula::with(['curso'])->where('user_id',$user)->get();
        $data = [];
        foreach($matriculas as $matricula){
            $data[] = ['curso'=>$matricula->curso];
        }

        return $data;
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Curso $curso): JsonResponse
    {
        $query = Matricula::where('user_id',auth()->user()->id)->first();

        if($query){
            abort(409,'Voce ja se matriculou no curso');
        }

        if($curso->status == 'rascunho'){
            abort(409,'Curso ainda esta em rascunho');
        }
        $matricula = Matricula::create(['user_id'=>auth()->user()->id,'curso_id'=>$curso->id,'status'=>'ativa']);

        return response()->json(new MatriculaResource($matricula));
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula): JsonResponse
    {
        return response()->json(new MatriculaResource($matricula));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Matricula $matricula): JsonResponse
    {
        $matricula->update($request->validate([
            'status'=>'required|in:ativa,cancelada,concluida'
        ]));

        return response()->json(new MatriculaResource($matricula));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Matricula $matricula): Response
    {
        $matricula->delete();

        return response()->noContent();
    }
}
