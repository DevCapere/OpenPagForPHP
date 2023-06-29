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
class Registro3N4 extends Generico3
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
        // Código de Identificação do Tributo       133 134 X(002) Nota N014
        'tipo_tributo' => array(
            'tamanho'  => 2,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Data de Vencimento                       135 142 9(008) DDMMAAAA
        'data_vencimento' => array(
            'tamanho'  => 8,
            'default'  => '',
            'tipo'     => 'date',
            'required' => true
        ),
        // IE / Cód Município / Núm Declaração      143 154 9(012) Obrigatório
        'num_declaracao' => array(
            'tamanho'  => 12,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Dívida Ativa / Número Etiqueta           155 167 9(013)
        'divida_ativa' => array(
            'tamanho'  => 13,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Período de Referência                    168 173 9(006) Nota N005
        'periodo_competencia' => array(
            'tamanho'  => 6,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Número da Parcela / Notificação          174 186 9(013)
        'numero_parcela' => array(
            'tamanho'  => 13,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Valor da Receita                         187 201 9(013)V2 Obrigatório
        'vlr_receita' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'   => true
        ),
        // Valor dos Juros / Encargos               202 215 9(012)V2 Opcional
        'vlr_juros' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'   => true
        ),
        // Valor da Multa                           216 229 9(012)V2 Opcional
        'vlr_multa' => array(
            'tamanho'   => 13,
            'default'   => '',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'   => true
        ),
        // Filler                                   230 230 X(001) Brancos
        'filler1' => array(
            'tamanho'   => 1,
            'default'   => '',
            'tipo'      => 'alfa',
            'required'  => true
        ),
    );

}
