<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoinhosController extends Controller
{
    public function dados()
    {
        $arrayDados = [
            'solicitados' => [
                [
                    'nome' => 'thiago',
                    'atendimento' => 123123,
                    'sexo' => 'masculino'
                ],
                [
                    'nome' => 'slaython',
                    'atendimento' => 5932,
                    'sexo' => 'mulher'
                ],
            ],
            'agendados' => [],
            'atendimento' => [],
            'pos_exame' => [],
            'finalizados' => [],
            'count' => [
                'total_solicitatos' => 2,
                'total_agendados' => 0,
                'total_pos_exame' => 0,
                'total_finalizados' => 0,
                'total_finalizados' => 0 
            ]
        ];

        return response($arrayDados, 200);
    }
}
