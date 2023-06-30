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
class Registro3C extends Generico3
{
    protected $meta = array(
        // Código do Banco                         001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true
        ),
        // Lote de Serviço                         004 007 9(004) Nota G001
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => 1,
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo de Registro                        008 008 9(001) 3
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '3',
            'tipo' => 'int',
            'required' => true
        ),
        // Número Sequencial do Registro no Lote   009 013 9(005) Nota G004
        'numero_registro' => array(
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Código Segmento do Registro Detalhe     014 014 X(001) C
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'C',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                  015 017 X(003) Branco
        'filler1' => array(
            'tamanho' => 3,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Valor do IR                             018 032 9(013)V2 Zeros
        'vlr_ir' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor do ISS                            033 047 9(013)V2 Zeros
        'vlr_iss' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor do IOF                            048 062 9(013)V2 Zeros
        'vlr_iof' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor Outras Deduções                   063 077 9(013)V2 Zeros
        'vlr_outras_deducoes' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor Outros Acréscimos                 078 092 9(013)V2 Zeros
        'vlr_outros' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Código da Agência do Favorecido         093 097 9(005) Zeros
        'agencia_favorecido' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Digito Verificador da Agência           098 098 X(001) Branco
        'agencia_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Conta Corrente do Favorecido            099 110 9(012) Zeros
        'conta_favorecido' => array(
            'tamanho' => 12,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Dígito Verificador da Conta             111 111 X(001) Branco
        'conta_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Digito Verificador da Agência/Conta     112 112 X(001) Branco
        'agencia_conta_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Valor do INSS                           113 127 9(013)V2 Zeros
        'vlr_inss' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Número Conta Pagamento Creditada        128 147 9(020) Nota G003A
        'conta_pagamento_creditada' => array(
            'tamanho' => 20,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler 148 240 X(093) Branco
        'filler2' => array(
            'tamanho' => 93,
            'default' => ' ',
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
