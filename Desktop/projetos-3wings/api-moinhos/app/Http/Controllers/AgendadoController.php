<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendarValidation;
use App\Models\Agendado;
use App\Models\Atendimento;
use Illuminate\Http\Request;

class AgendadoController extends Controller
{
     public function agendar(AgendarValidation $request){
        Agendado::create([
            'acess_number' => $request->acess_number,
            'dados' => json_encode($request->dados)
        ]);

        return response([], 200);
     }

     public function agendarCancelar(Request $request){
      if($request->identificacao == 1){
        $dados = Agendado::where('acess_number', $request->acess_number)->first();
        $dados->delete();
      }

      if($request->identificacao == 2){
        $dados = Atendimento::where('acess_number', $request->acess_number)->first();
        $dados->delete();
      }

       if($dados){
        return response('', 200);
       }
     }
}
