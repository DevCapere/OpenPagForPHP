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
class Registro3N7 extends Generico3
{

    protected $meta = array(
        // Código da Receita do Tributo             111 116 X(006) Nota N001
        'codigo_tributo' => array(
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'alfa',
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
        // Código de Identificação do Tributo       133 134 X(002) 25
        'tipo_tributo' => array(
            'tamanho'  => 2,
            'default'  => '25',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Ano Base / Exercício                     135 138 9(004) AAAA
        'ano_exercicio' => array(
            'tamanho'  => 4,
            'default'  => '',
            'tipo'     => 'date',
            'required' => true
        ),
        // Código do RENAVAM (9 dígitos)            139 147 9(009) Nota N015
        'renavam' => array(
            'tamanho'  => 9,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Unidade da Federação                     148 149 X(002) Nota N008
        'uf' => array(
            'tamanho'  => 2,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Código do Município                      150 154 9(005) Nota N009
        'codigo_municipio' => array(
            'tamanho'  => 5,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Placa do Veículo                         155 161 X(007) Nota N010
        'placa' => array(
            'tamanho'  => 7,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Opção de Pagamento                       162 162 X(001) Nota N011
        'opcao_pagamento' => array(
            'tamanho'  => 1,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Opção de Retirada do CRLV                 163 163  9(001)
        'opcao_retirada' => array(
            'tamanho'  => 1,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
        // Novo RENAVAM (11 dígitos)                163 174 9(012) Nota N015
        'novo_renavam' => array(
            'tamanho'  => 12,
            'default'  => '',
            'tipo'     => 'int',
            'required' => true
        ),
        // Uso Exclusivo FEBRABAN/CNAB              175 230 X(055) Brancos 
        'uso_febraban' => array(
            'tamanho'  => 54,
            'default'  => '',
            'tipo'     => 'alfa',
            'required' => true
        ),
    );

}
