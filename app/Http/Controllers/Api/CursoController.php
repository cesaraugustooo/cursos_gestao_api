<?php

namespace App\Http\Controllers\Api;

use App\Models\Curso;
use Illuminate\Http\Request;
use App\Http\Requests\CursoRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;
use App\Models\User;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->query('instructor')){
            $instructor = User::where('name',$request->query('instructor'))->first();
            if(!$instructor){
                return response()->json(['message' => 'Instrutor não encontrado'],404);
            }
            $cursos = Curso::where('user_id',$instructor->id)->paginate();

            return CursoResource::collection($cursos);
        }
        $cursos = Curso::paginate();

        return CursoResource::collection($cursos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CursoRequest $request)
    {
        $curso = Curso::create(array_merge($request->validated(),['user_id'=>auth()->user()->id]));

        return response()->json(new CursoResource($curso));
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso): JsonResponse
    {
        return response()->json(new CursoResource($curso));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso): JsonResponse
    {
        if(auth()->user()->id != $curso->user_id and auth()->user()->role != 'admin'){
            return response()->json(['message'=>'Voce nao é dono do curso'],403);
        }

        $curso->update($request->validate(
            [
                'titulo' => 'sometimes|string',
                'descricao' => 'sometimes|string',
                'preco' => 'sometimes',
                'status' => 'sometimes|in:rascunho,publicado',
            ]
        ));

        return response()->json(new CursoResource($curso));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(Curso $curso)
    {
        if(auth()->user()->id != $curso->user_id and auth()->user()->role != 'admin'){
            return response()->json(['message'=>'Voce nao é dono do curso'],403);
        }

        $curso->delete();

        return response()->noContent();
    }
}
