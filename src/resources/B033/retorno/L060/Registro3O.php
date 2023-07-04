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
use PagForPHP\DetalhaMovimentoRetorno;

/**
 * @version 11.3.1
 * @link https://cms.santander.com.br/sites/WPS/documentos/arq-layout-pagamento-fornecedores-mai22/23-03-07_150124_pagamento_a_fornecedores_layout_cnab_240_v11.3.2_newpt.pdf
 */
class Registro3O extends Generico3
{

    protected $meta = array(
        // Código do Banco                          001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
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
        // Código de Barras                         018 061 X(044) Nota N002
        'codigo_barras' => array(
            'tamanho' => 44,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome Concessionária / Órgão Público      062 091 X(030) Obrigatório
        'nome_concessionaria' => array(
            'tamanho' => 30,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data de Vencimento                       092 099 9(008) DDMMAAAA
        'data_vencimento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Data do Pagamento                        100 107 9(008) DDMMAAAA
        'data_pagamento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Valor Total do Pagamento                 108 122 9(013)V2 Nota G022
        'vlr_pagamento' => array(
            'tamanho' => 13,
            'default' => '',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Nro. do Documento Cliente                123 142 X(020) Nota G006
        'seu_numero' => array(
            'tamanho' => 20,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nro. do Documento Banco                  143 162 X(020) Nota G017
        'nosso_numero' => array(
            'tamanho' => 20,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   163 230 X(068) Brancos
        'seu_numero' => array(
            'tamanho' => 68,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Ocorrência para Retorno                  231 240 X(010) Nota G007
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
