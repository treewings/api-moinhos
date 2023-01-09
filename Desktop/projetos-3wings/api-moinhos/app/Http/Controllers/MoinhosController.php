<?php

namespace App\Http\Controllers;

use App\Http\Views\Moinhos as ViewsMoinhos;
use App\Models\Agendado;
use App\Models\Atendimento;
use App\Models\Moinhos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;

class MoinhosController extends Controller
{
    public function dados()
    {
        $remove = Moinhos::all();

        foreach($remove as $dados){
                $dados->delete();
        }

        $view = new ViewsMoinhos();
        $view = $view->dados();
    
       while($dados = oci_fetch_assoc($view)){
            $moinhos = Agendado::where('acess_number', $dados['acess_number'])->get();
            $atendimento = Atendimento::where('acess_number', $dados['acess_number'])->get();
            if(!isset($moinhos[0]) && !isset($atendimento[0])){
                Moinhos::create([
                    'acess_number' => $dados['acess_number'],
                    'data' =>  $dados['hora_pedidoX'],
                    'dados' => json_encode($dados)
                ]);
            }
       }

       $moinhos = DB::table('moinhos')->reorder('data', 'asc')->get();
       $agendados = Agendado::all();
       $atendimentos = Atendimento::all();
       
       $Atualizado = [];
       foreach($moinhos as $dadosAtulizado){
            array_push($Atualizado, json_decode($dadosAtulizado->dados));
       }

       $Agendado = [];
       foreach($agendados as $agend){
        array_push($Agendado, json_decode($agend->dados));
       }

       $Atendimento = [];
       foreach($atendimentos as $atend){
        array_push($Atendimento, json_decode($atend->dados));
       }


        $arrayDados = [
            'solicitados' => $Atualizado,
            'agendados' => $Agendado,
            'atendimento' => $Atendimento,
            'pos_exame' => [],
            'finalizados' => [],
            'count' => [
                'total_solicitatos' => count($Atualizado),
                'total_agendados' => count($Agendado),
                'total_pos_exame' => 0,
                'total_atendimento' => count($Atendimento),
                'total_finalizados' => 0
            ]
        ];

        return response($arrayDados, 200);
    }
}
