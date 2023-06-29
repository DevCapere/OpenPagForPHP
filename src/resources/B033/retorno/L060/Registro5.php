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

use PagForPHP\resources\generico\retorno\L060\Generico5;
use PagForPHP\RetornoAbstract;

class Registro5 extends Generico5
{

    protected $meta = array(
        // Código do Banco                         001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true
        ),
        // Lote de Serviço                         004 007 9(004 Nota G001
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => 1,
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo de Registro                        008 008 9(001) 5
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '5',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                  009 017 X(009) Brancos
        'filler1' => array(
            'tamanho' => 9,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Quantidade de Registros do Lote         018 023 9(006) Registros Tipo 1, 3, 5
        'qtd_registros' => array(
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Somatória dos Valores                   024 041 9(016)V2 Nota G021
        'vlr_documento_lote' => array(
            'tamanho' => 16,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Somatória Quantidade Moeda              042 059 9(013)V5 Registro Tipo 3
        'qtd_moeda_lote' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 5,
            'required' => true
        ),
        // Número Aviso de Débito                  060 065 9(006) Nota G020
        'num_aviso_debito' => array(
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                  066 230 X(165) Brancos
        'filler3' => array(
            'tamanho' => 165,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Ocorrências para o Retorno              231 240 X(010) Nota G007
        'codigo_ocorrencia' => array(
            'tamanho' => 10,
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
