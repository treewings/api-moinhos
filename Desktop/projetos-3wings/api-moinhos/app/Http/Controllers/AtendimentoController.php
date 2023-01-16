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
            'codigo_setor_exame' => $request->codigo_setor_exame,
            'data_agendamento' => $agendados->data_agendamento,
            'hora_agendamento' => $agendados->hora_agendamento,
            'sala' => $agendados->sala,
            'cod_sala' => $agendados->cod_sala,
            'observacao' => $agendados->observacao,
            'dados' => $agendados->dados
            ]);
       }else{
            return response('', 404)->header('Retry-After', '3000');
       }
     


       $agendados->delete();

        return response([], 200)->header('Retry-After', '3000');
     }
}
