<?php

namespace App\Http\Controllers\Api;

use App\Models\MateriaisAula;
use Illuminate\Http\Request;
use App\Http\Requests\MateriaisAulaRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MateriaisAulaResource;

class MateriaisAulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $materiaisAulas = MateriaisAula::paginate();

        return MateriaisAulaResource::collection($materiaisAulas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MateriaisAulaRequest $request): JsonResponse
    {
        $materiaisAula = MateriaisAula::create($request->validated());

        return response()->json(new MateriaisAulaResource($materiaisAula));
    }

    /**
     * Display the specified resource.
     */
    public function show(MateriaisAula $materiaisAula): JsonResponse
    {
        return response()->json(new MateriaisAulaResource($materiaisAula));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MateriaisAulaRequest $request, MateriaisAula $materiaisAula): JsonResponse
    {
        $materiaisAula->update($request->validated());

        return response()->json(new MateriaisAulaResource($materiaisAula));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(MateriaisAula $materiaisAula): Response
    {
        $materiaisAula->delete();

        return response()->noContent();
    }
}
