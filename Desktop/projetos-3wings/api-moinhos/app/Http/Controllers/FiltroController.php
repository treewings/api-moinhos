<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiltroController extends Controller
{
    public function consulta(ConsultaValidation $request){

        $consulta = function ($query) use ($request)
        {
            if($request->has('codigo_setor_exame')){
                $query->where('codigo_setor_exame', $request->get('codigo_setor_exame'));
            }
        };

        $moinhos = DB::table('moinhos')->where($consulta)->get();
        $agendados = DB::table('agendados')->where($consulta)->get();
        $atendimentos = DB::table('atendimentos')->where($consulta)->get();
        $posexame = DB::table('posexames')->where($consulta)->get();
        $finalizado = DB::table('finalizados')->where($consulta)->get();
        $filtro = [];
        $Atualizado = [];
        foreach($moinhos as $dadosAtulizado){
            $setor = json_decode($dadosAtulizado->dados, true);
            $filtro[$dadosAtulizado->codigo_setor_exame] = $setor['setor_exame'];
             array_push($Atualizado, json_decode($dadosAtulizado->dados));
        }

        $Agendado = [];
        $umovCheca = [];

       foreach($agendados as $agend){
        $agen = json_decode($agend->dados, true);
        $filtro[$agend->codigo_setor_exame] = $agen['setor_exame'];
        $agen['data_agendamento'] = $agend->data_agendamento;
        $agen['hora_agendamento'] = $agend->hora_agendamento;
        $agen['sala'] = $agend->sala ? $agend->sala : null;
        $agen['status_tarefa'] = $agend->status_tarefa ? $agend->status_tarefa : null;
        $agen['numero_tarefa'] = $agend->numero_tarefa ? $agend->numero_tarefa : null;
        $agen['imagem_cadeira'] = $agend->imagem_cadeira ? $agend->imagem_cadeira : null;
        $agen['observacao'] = $agend->observacao ? $agend->observacao : null;
        $agen['cod_sala'] = $agend->cod_sala ? $agend->cod_sala : null;
        if($agen['numero_tarefa'] != null && $agen['status_tarefa'] != '50' && $agen['status_tarefa'] != '70'){
            $umovCheca[] = $agen;
        }
        array_push($Agendado, $agen);
       }

       $Atendimento = [];
       foreach($atendimentos as $atend){
        $at = json_decode($atend->dados, true);
        $at['data_agendamento'] = $atend->data_agendamento;
        $at['hora_agendamento'] = $atend->hora_agendamento;
        $at['sala'] = $atend->sala ? $atend->sala : null;
        $at['numero_tarefa'] = $atend->numero_tarefa ? $atend->numero_tarefa : null;
        $at['imagem_cadeira'] = $atend->imagem_cadeira ? $atend->imagem_cadeira : null;
        $at['observacao'] = $atend->observacao ? $atend->observacao : null;
        $filtro[$atend->codigo_setor_exame] = $at['setor_exame'];
        if($at['numero_tarefa'] != null){
            $umovCheca[] = $agen;
        }
        array_push($Atendimento, $at);
       }


       $posDados = [];

       foreach($posexame as $pos){
        $p = json_decode($pos->dados, true);
        $p['data_agendamento'] = $pos->data_agendamento;
        $p['hora_agendamento'] = $pos->hora_agendamento;
        $p['sala'] = $pos->sala ? $pos->sala : null;
        $p['numero_tarefa'] = $pos->numero_tarefa ? $pos->numero_tarefa : null;
        $p['status_tarefa'] = $pos->status_tarefa ? $pos->status_tarefa : null;
        $p['imagem_cadeira'] = $pos->imagem_cadeira ? $pos->imagem_cadeira : null;
        $p['observacao'] = $pos->observacao ? $pos->observacao : null;
        $filtro[$pos->codigo_setor_exame] = $p['setor_exame'];
        if($p['numero_tarefa'] != null && $p['status_tarefa'] != '50' && $p['status_tarefa'] != '70'){
            $umovCheca[] = $agen;
        }
        array_push($posDados, $p);
       }



       $finDados = [];

       foreach($finalizado as $fin){
        $f = json_decode($fin->dados, true);
        $f['data_agendamento'] = $fin->data_agendamento;
        $f['hora_agendamento'] = $fin->hora_agendamento;
        $f['data_movimentacao'] = $fin->created_at->format('d/m/Y H:i');
        $f['sala'] = $fin->sala ? $fin->sala : null;
        $f['numero_tarefa'] = $fin->numero_tarefa ? $fin->numero_tarefa : null;
        $f['status_tarefa'] = $fin->status_tarefa ? $fin->status_tarefa : null;
        $f['imagem_cadeira'] = $fin->imagem_cadeira ? $fin->imagem_cadeira : null;
        $f['observacao'] = $fin->observacao ? $fin->observacao : null;
        $f['cod_sala'] = $fin->cod_sala ? $fin->cod_sala : null;
        $filtro[$fin->codigo_setor_exame] = $f['setor_exame'];
        if($f['numero_tarefa'] != null && $f['status_tarefa'] != '50' && $f['status_tarefa'] != '70'){
            $umovCheca[] = $fin;
        }
        array_push($finDados, $f);
       }

        $arrayDados = [
            'solicitados' => $Atualizado,
            'agendados' => $Agendado,
            'atendimento' => $Atendimento,
            'pos_exame' => $posDados,
            'finalizados' => $finDados,
            'count' => [
                'total_solicitatos' => count($Atualizado),
                'total_agendados' => count($Agendado),
                'total_pos_exame' => count($posDados),
                'total_atendimento' => count($Atendimento),
                'total_finalizados' => count($finDados)
            ],
            'filtro' => $filtro,
            'umovCheca' => $umovCheca
        ];

        return response($arrayDados, 200)->header('Retry-After', '3000');
    }
}
