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
use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L060\Generico3;

/**
 * @version 11.3.1
 * @link https://cms.santander.com.br/sites/WPS/documentos/arq-layout-pagamento-fornecedores-mai22/23-03-07_150124_pagamento_a_fornecedores_layout_cnab_240_v11.3.2_newpt.pdf
 */
class Registro3B_Pix extends Generico3
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
        // Código Segmento do Registro Detalhe     014 014 X(001) B
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'B',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Forma de Iniciação                      015 016 X(002) G032
        'forma_iniciacao' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Uso Reservado do Banco                  017 017 X(001) Brancos
        'filler1' => array(
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Tipo de Inscrição do Favorecido         018 018 9(001) Nota G023
        'tipo_documento_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // CNPJ/CPF do Favorecido                  019 032 9(014) CPF/CNPJ
        'documento_favorecido' => array(
            'tamanho' => 14,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),

        // Informação 10                           033 067 X(035) G033
        'informacao_10' => array(
            'tamanho' => 35,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Informação 11                           068 127 X(060) G034
        'informacao_11' => array(
            'tamanho' => 60,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Informação 12                           128 226 X(099) G035
        'informacao_12' => array(
            'tamanho' => 99,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),

        // Uso Reservado do Banco                  227 232 X(006) Brancos
        'filler2' => array(
            'tamanho' => 6,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Identificação do SPB (ISPB)             233 240 X(008) Nota G030
        'identificacao_spb' => array(
            'tamanho' => 8,
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
