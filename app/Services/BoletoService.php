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

    public function calcularBoleto(float $valor, string $vencimento, string $dataPagamento, ?int $parcelas = null) {
        $this->valorOriginal = $valor;
        $this->valorTotal = $valor;
        $this->vencimento = Carbon::parse($vencimento);
        $this->dataPagamento = Carbon::parse($dataPagamento);
        $this->parcelas = $parcelas;

        $this->calcularAtraso();

        $resposta = [
            "valor_original" => round($this->valorOriginal, 2),
            "dias_em_atraso" => $this->diasAtrasado
        ];

        if ($this->diasAtrasado === 0) {
            return $resposta;
        }

        $resposta += [
            'multa' => round($this->multa, 2),
            'juros' => round($this->juros, 2),
            'valor_atualizado' => round($this->valorTotal, 2),
        ];

        if ($this->parcelas) {
            $parcelamento = $this->calcularParcelamento();

            $resposta = array_merge($resposta, $parcelamento);
        }

        return $resposta;
    }

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

    private function calcularParcelamento() {
        $jurosTotal = $this->valorTotal * self::JUROS_MENSAL_PARCELAMENTO * $this->parcelas;
        $valorTotalComJuros = $this->valorTotal + $jurosTotal;
        $valorParcela = round($valorTotalComJuros / $this->parcelas, 2);

        return [
            'parcelas' => $this->parcelas,
            'juros_parcelamento' => round($jurosTotal, 2),
            'valor_total_com_juros' => round($valorTotalComJuros, 2),
            'valor_parcela' => $valorParcela,
        ];
    }
}
