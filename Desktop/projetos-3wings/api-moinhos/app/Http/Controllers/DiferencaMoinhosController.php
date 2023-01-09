<?php

namespace App\Http\Controllers;

use App\Models\Agendado;
use App\Models\Atendimento;
use App\Models\Moinhos;
use Illuminate\Http\Request;
use App\Http\Views\Moinhos as ViewsMoinhos;

class DiferencaMoinhosController extends Controller
{
    public function diferenca(){
      
      $moinhosArray = []; 
      $view = new ViewsMoinhos();
      $view = $view->dados();
      while($dados = oci_fetch_assoc($view)){
        $moinhos = Agendado::where('acess_number', $dados['acess_number'])->get();
        $atendimento = Atendimento::where('acess_number', $dados['acess_number'])->get();
        $solicitados = Moinhos::where('acess_number', $dados['acess_number'])->get();
        if(!isset($moinhos[0]) && !isset($atendimento[0]) && !isset($solicitados[0])){
            array_push($moinhosArray, $dados);
            if($dados != ''){
                Moinhos::create([
                    'acess_number' => $dados['acess_number'],
                    'data' => $dados['hora_pedido'],
                    'dados' =>  json_encode($dados)
                ]);
            }
        }
      }

      $arrayDados = [
        'solicitados' => $moinhosArray,
    ];

      
      return response($arrayDados, 200);

    }

    public function atualizaDados(Request $request){
        $agendado = Agendado::count();
        
        if($agendado == $request->numero_count){
            return response('', 200);
        }else{
            return response('', 404);
        }
    }
}
