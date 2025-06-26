<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BoletoService;

class BoletoController extends Controller
{
    public function calcular(Request $request) {
        $payload = $request->validate([
            'valor'          => 'required|numeric',
            'vencimento'     => 'required|date',
            'data_pagamento' => 'required|date',
            'parcelas'       => 'nullable|integer|min:1',
        ]);
        
        $service = new BoletoService();

        $resultado = $service->calcularBoleto(
            $request['valor'],
            $request['vencimento'],
            $request['data_pagamento'],
            $request['parcelas'] ?? null
        );

        return response()->json($resultado);
    }
}
