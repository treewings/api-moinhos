<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgendarValidation;
use App\Models\Agendado;
use App\Models\Atendimento;
use Illuminate\Http\Request;

class AtendimentoController extends Controller
{
    //
    public function atendimento(Request $request){
       $agendados = Agendado::where('acess_number', $request->acess_number)->first();

       if($agendados){
        Atendimento::create([
            'acess_number' => $request->acess_number,
            'dados' => $agendados->dados
            ]);
       }else{
            return response('', 404);
       }
     


       $agendados->delete();

        return response([], 200);
     }
}
