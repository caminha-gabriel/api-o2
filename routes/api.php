<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoletoController;

Route::post('/calcular-boleto', [BoletoController::class, 'calcular']);
