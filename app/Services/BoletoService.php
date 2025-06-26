<?php

namespace App\Services;

use Carbon\Carbon;

class BoletoService
{
    private const MULTA_PERCENTUAL = 0.02; // 2%
    private const JUROS_DIA = 0.00033; // 0.033% ao dia
    private const JUROS_MENSAL_PARCELAMENTO = 0.013; // 1.3% ao mês

    private float $valorOriginal;
    private Carbon $vencimento;
    private Carbon $dataPagamento;
    private ?int $parcelas = null;

    private int $diasAtrasado;

    private float $multa;
    private float $juros;
    private float $valorTotal;

    private function calcularAtraso() {
        $this->diasAtrasado = max($this->vencimento->diffInDays($this->dataPagamento, false), 0);

        if ($this->diasAtrasado > 0) {
            $this->aplicarMulta();
            $this->aplicarJuros();
            $this->valorTotal = $this->valorOriginal + $this->multa + $this->juros;
        }
    }

    private function aplicarMulta() {
        $this->multa = $this->valorTotal * self::MULTA_PERCENTUAL;
    }

    private function aplicarJuros() {
        $this->juros = $this->valorTotal * self::JUROS_DIA * $this->diasAtrasado;
    }
}
