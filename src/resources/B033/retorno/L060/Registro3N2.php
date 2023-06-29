<?php
/*
 * PagForPHP - Geração de arquivos de remessa e retorno em PHP
 *
 * LICENSE: The MIT License (MIT)
 *
 * Copyright (C) 2013 Ciatec.net
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace PagForPHP\resources\B033\retorno\L060;

use PagForPHP\resources\generico\retorno\L060\Generico3;
use PagForPHP\RetornoAbstract;

/**
 * @version 11.3.1
 * @link https://cms.santander.com.br/sites/WPS/documentos/arq-layout-pagamento-fornecedores-mai22/23-03-07_150124_pagamento_a_fornecedores_layout_cnab_240_v11.3.2_newpt.pdf
 */
class Registro3N2 extends Generico3
{

    protected $meta = array(
        // Código da Receita do Tributo             111 116 9(006) Nota N001
        'codigo_tributo' => array(
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo de Identificação do Contribuinte    117 118 9(002) Nota N003
        'tipo_documento_contribuinte' => array(
            'tamanho'   => 2,
            'default'   => '',
            'tipo'      => 'int',
            'required'  => true
        ),
        // Identificação do Contribuinte            119 132 9(014) Nota N004
        'documento_contribuinte' => array(
            'tamanho'  => 14,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Código de Identificação do Tributo       133 134 X(002) 16
        'tipo_tributo' => array(
            'tamanho'  => 2,
            'default'  => '16',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Período de Apuração                      135 142 9(008) DDMMAAAA
        'data_apuracao' => array(
            'tamanho'  => 8,
            'default'  => '',
            'tipo'     => 'date',
            'required' => true
        ),
        // Número de Referencia                     143 159 9(017) Obrigatório
        'numero_referencia' => array(
            'tamanho'  => 17,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Valor Principal                          160 174 9(013)V2 Obrigatório
        'vlr_principal' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Valor da Multa                           175 189 9(013)V2 Opcional
        'vlr_multa' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Valor dos Juros / Encargos               190 204 9(013)V2 Opcional
        'vlr_juros' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Data de Vencimento                       205 212 9(008) DDMMAAAA
        'data_vencimento' => array(
            'tamanho'   => 8,
            'default'   => '',
            'tipo'      => 'date',
            'required'  => true
        ),
        // Filler                                   213 230 X(018) Brancos 
        'filler' => array(
            'tamanho'   => 18,
            'default'   => '',
            'tipo'      => 'alfa',
            'required'  => true
        ),
    );

}
