<?php

namespace App\Http\Controllers\Api;

use App\Models\Aula;
use Illuminate\Http\Request;
use App\Http\Requests\AulaRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AulaResource;
use App\Models\Curso;

class AulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $aulas = Aula::paginate();

        return AulaResource::collection($aulas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AulaRequest $request,$id): JsonResponse
    {
        $curso = Curso::find($id);

        if(!$curso){
            return response()->json(['message'=>'Curso Not-Found'],404);
        }

        if(auth()->user()->id != $curso->user_id){
            return response()->json(['message'=>'Voce nao e dono do curso'],403);
        }

        $aula = Aula::create(array_merge($request->validated(),['curso_id'=>$id]));

        return response()->json(new AulaResource($aula));
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso): JsonResponse
    {   
        $curso = $curso->load('aulas');

        return response()->json(new AulaResource($curso->aulas));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AulaRequest $request, Aula $aula): JsonResponse
    {
        $aula->update($request->validated());

        return response()->json(new AulaResource($aula));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Aula $aula)
    {
        $aula = $aula->load('curso');

        if(auth()->user()->id != $aula->curso->user_id){
            return response()->json(['message'=>'Voce nao e dono do curso'],403);
        }


        $aula->delete();

        return response()->noContent();
    }
}
