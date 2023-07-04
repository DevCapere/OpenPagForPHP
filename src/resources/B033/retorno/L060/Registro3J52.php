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
class Registro3J52 extends Generico3
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
        // Código Segmento do Registro Detalhe      014 014 X(001) J
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'J',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   015 015 X(001) Brancos
        'filler1' => array(
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código de Movimento Remessa              016 017 9(002) Nota G026
        'codigo_movimento_remessa' => array(
            'tamanho' => 2,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Identificação Registro                   018 019 9(002) 52
        'identificacao_registro' => array(
            'tamanho' => 2,
            'default' => '52',
            'tipo' => 'int',
            'required' => true
        ),
        // Pagador | Tipo de Inscrição              020 020 9(001) Nota G027
        'pagador_tipo_documento' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Pagador | CPF/CNPJ do Pagador            021 035 9(015) Nota G027
        'pagador_documento' => array(
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Pagador | Nome do Pagador                036 075 X(040) Nota G027
        'pagador_nome' => array(
            'tamanho' => 40,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),

        // Beneficiário | Tipo de Inscrição         076 076 9(001) Nota G023 (Obrigatório)
        'beneficiario_tipo_documento' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Beneficiário | CPF/CNPJ do Beneficiário  077 091 9(015) CPF/CNPJ (Obrigatório)
        'beneficiario_documento' => array(
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Beneficiário | Nome do Beneficiário      092 131 X(040) Nota G028
        'beneficiario_nome' => array(
            'tamanho' => 40,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Sacador | Tipo de Inscrição              132 132 9(001) Nota G027
        'sacador_tipo_documento' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Sacador | CPF/CNPJ do Sacador            133 147 9(015) Nota G027
        'sacador_documento' => array(
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Sacador | Nome do Sacador                148 187 X(040) Nota G027
        'sacador_nome' => array(
            'tamanho' => 40,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   188 240 X(053) Brancos
        'filler2' => array(
            'tamanho' => 53,
            'default' => '',
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
