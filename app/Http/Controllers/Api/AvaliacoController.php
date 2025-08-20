<?php

namespace App\Http\Controllers\Api;

use App\Models\Avaliaco;
use Illuminate\Http\Request;
use App\Http\Requests\AvaliacoRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AvaliacoResource;
use App\Models\Curso;
use App\Models\Matricula;

class AvaliacoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $avaliacos = Avaliaco::paginate();

        return AvaliacoResource::collection($avaliacos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AvaliacoRequest $request,Curso $curso): JsonResponse
    {
        $query = Matricula::where('user_id',auth()->user()->id)->first();

        if($query->status != 'concluida'){
            abort(409,'Voce ainda não concluiu o curso');
        }

        $avaliaco = Avaliaco::create(array_merge($request->validated(),['user_id'=>auth()->user()->id,'curso_id'=>$curso->id]));

        return response()->json(new AvaliacoResource($avaliaco));
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso): JsonResponse
    {   
        $curso->load('avaliacoes');

        return response()->json(new AvaliacoResource($curso->avaliacoes));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AvaliacoRequest $request, Avaliaco $avaliaco): JsonResponse
    {
        $avaliaco->update($request->validated());

        return response()->json(new AvaliacoResource($avaliaco));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Avaliaco $avaliaco): Response
    {
        $avaliaco->delete();

        return response()->noContent();
    }
}
