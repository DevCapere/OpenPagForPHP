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
class Registro3N1 extends Generico3
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
        // Código de Identificação do Tributo       133 134 X(002) 17
        'tipo_tributo' => array(
            'tamanho'  => 2,
            'default'  => '17',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Mês e Ano de Competência                 135 140 9(006) Nota N005
        'periodo_competencia' => array(
            'tamanho'  => 6,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Valor Previsto do Pagamento do INSS      141 155 9(013)V2 Obrigatório
        'vlr_previsto_pagamento_inss' => array(
            'tamanho'   => 13,
            'default'   => '0',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Valor de Outras Entidades                156 170 9(013)V2 Opcional
        'vlr_outras_entidades' => array(
            'tamanho'   => 13,
            'default'   => '0',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Atualização Monetária                    171 185 9(013)V2 Opcional
        'atualizacao_monetaria' => array(
            'tamanho'   => 13,
            'default'   => '0',
            'tipo'      => 'decimal',
            'precision' => 2,
            'required'  => true
        ),
        // Filler                                   186 230 X(045) Brancos
        'filler1' => array(
            'tamanho'   => 45,
            'default'   => '',
            'tipo'      => 'alfa',
            'required'  => true
        ),
    );
}
