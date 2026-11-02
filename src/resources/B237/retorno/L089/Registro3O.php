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
namespace PagForPHP\resources\B237\retorno\L089;

use PagForPHP\resources\generico\retorno\L089\Generico3;
use PagForPHP\RetornoAbstract;
use PagForPHP\DetalhaMovimentoRetorno;

/**
 * Retorno Multipag Bradesco 237 layout 089 — segmento O.
 * Barras 48 e moeda REA, igual à remessa. O mapa Santander de barras 44 desloca nome e data.
 */
class Registro3O extends Generico3
{

    protected $meta = array(
        // Código do Banco                          001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '237',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Lote de Serviço                          004 007 9(004) Nota G001
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => 1,
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo de Registro                         008 008 9(001) 3
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '3',
            'tipo' => 'int',
            'required' => true
        ),
        // Número Sequencial do Registro no Lote    009 013 9(005) Nota G004
        'numero_registro' => array(
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Código Segmento do Registro Detalhe      014 014 X(001) 'O'
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'O',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Tipo de Movimento                        015 015 9(001) Nota G011
        'tipo_movimento' => array(
            'tamanho' => 1,
            'default' => '1',
            'tipo' => 'int',
            'required' => true
        ),
        

        // Código da Instrução para Movimento       016 017 9(002) Nota G012
        'codigo_instrucao_movimento' => array(
            'tamanho' => 2,
            'default' => '01',
            'tipo' => 'int',
            'required' => true
        ),
        // Código de Barras                         018 065 X(048) arrecadação Bradesco
        'codigo_barras' => array(
            'tamanho' => 48,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome Concessionária                      066 095 X(030)
        'nome_concessionaria' => array(
            'tamanho' => 30,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data de Vencimento                       096 103 9(008) DDMMAAAA
        'data_vencimento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Código da Moeda                          104 106 X(003) REA
        'codigo_moeda' => array(
            'tamanho' => 3,
            'default' => 'REA',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Quantidade da Moeda                      107 121 9(007)V9(008) — só ocupa posição
        'quantidade_moeda' => array(
            'tamanho' => 7,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 8,
            'required' => true
        ),
        // Valor do Pagamento                       122 136 9(013)V2
        'vlr_pagamento' => array(
            'tamanho' => 13,
            'default' => '',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Data do Pagamento                        137 144 9(008) DDMMAAAA
        'data_pagamento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Valor Pago                               145 159 9(013)V2 — só ocupa posição
        'valor_pago' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Filler                                   160 162 X(003)
        'filler' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Nota Fiscal                              163 171 9(009)
        'nota_fiscal' => array(
            'tamanho' => 9,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                   172 174 X(003)
        'filler2' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Nro. do Documento Cliente                175 194 X(020)
        'seu_numero' => array(
            'tamanho' => 20,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   195 215 X(021)
        'filler3' => array(
            'tamanho' => 21,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Nro. do Documento Banco                  216 230 X(015)
        'nosso_numero' => array(
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Ocorrência para Retorno                  231 240 X(010)
        'codigo_ocorrencia' => array(
            'tamanho' => 10,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
    );

    public function __construct($data = null)
    {
        if (empty($this->data)) {
            parent::__construct($data);
        }
        RetornoAbstract::$linesCounter++;
    }
}
