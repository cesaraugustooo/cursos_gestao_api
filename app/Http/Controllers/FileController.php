<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\MateriaisAula;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request,Aula $aula){

        $request->validate([
            'file'=>'required'
        ]);

        $file = $request->file('file');
        $name = md5(time() . time()*3 .'_user_id:'. auth()->user()->id.'_'.'as580knvasdoe9c'.$file->getClientOriginalName().',mdgds(((9ahudafds2');

        $file->move(public_path('uploads'),$name);

        MateriaisAula::create([
            'file_path'=>$name,
            'aula_id'=>$aula->id
        ]);

        return response()->json(['message'=>'success'],200);
    }
    public function list(Aula $aula){
        $aula = $aula->load('materiais');

        return response()->json(['data'=>$aula->materiais]);
    }
}
