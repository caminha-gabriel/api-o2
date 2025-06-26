<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BoletoService;

class BoletoController extends Controller
{
    public function calcular(Request $request) {
        $request->validate([
            'valor'          => 'required|numeric|min:0.01',
            'vencimento'     => 'required|date|before_or_equal:data_pagamento',
            'data_pagamento' => 'required|date|after_or_equal:vencimento',
            'parcelas'       => 'nullable|integer|min:1|max:12',
        ]);
        
        try {
            $service = new BoletoService();

            $resultado = $service->calcularBoleto(
                $request['valor'],
                $request['vencimento'],
                $request['data_pagamento'],
                $request['parcelas'] ?? null
            );

            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Erro ao processar boleto",
                "details" => $e->getMessage()
            ]);
        }
    }
}
