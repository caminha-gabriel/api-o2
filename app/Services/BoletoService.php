<?php

namespace App\Services;

use Carbon\Carbon;

class BoletoService
{
    private const MULTA_PERCENTUAL = 0.02; // 2%
    private const JUROS_DIA = 0.00033; // 0.033% ao dia
    private const JUROS_MENSAL_PARCELAMENTO = 0.013; // 1.3% ao mês

    private $valorOriginal;
    private $vencimento;
    private $dataPagamento;
    private $parcelas = null;

    private $diasAtrasado;

    private $multa;
    private $juros;
    private $valorTotal;
}
