<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatoriosController extends Controller
{
    public function mensais(){
        $data = DB::table('matriculas')
                ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') as mes, COUNT(id) as matriculas")
                ->where('created_at','>=',DB::raw('NOW() - INTERVAL 1 year'))
                ->groupBy('mes')
                ->get();

        return $data;
    }

    public function faturamentos_mensais(){
        $data = DB::table('matriculas')
                ->join('cursos','cursos.id','=','matriculas.curso_id')
                ->selectRaw("DATE_FORMAT(matriculas.created_at,'%Y-%m') as mes, SUM(cursos.preco) as faturamento")
                ->where('created_at','>=',DB::raw('NOW() - INTERVAL 1 year'))
                ->groupBy('mes')
                ->get();
                
        return $data;
    }
    
      public function engajamento(){
        $data = DB::table('matriculas')
                ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') as mes, COUNT(id) as concluidos")
                ->where('created_at','>=',DB::raw('NOW() - INTERVAL 1 year'))
                ->where('status','concluida')
                ->groupBy('mes')
                ->get();
            
        return $data;
    }
}
