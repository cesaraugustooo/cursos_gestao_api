<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(UserRequest $request)
    {

        return User::create(array_merge($request->validated(),['role'=>'student','password'=>Hash::make($request->input('password'))]));
    }
    public function login(Request $request){
        $creds = [
            'email' => $request->input('email'),
            'password'=>$request->input('password'),
        ];

        if(Auth::attempt($creds)){
            return response()->json(['token'=>User::where('email',$creds['email'])->first()->createToken('api')->plainTextToken]);
        }
        abort(401,'Credenciais Invalidas');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        $user->update($request->validated());

        return response()->json(new UserResource($user));
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
