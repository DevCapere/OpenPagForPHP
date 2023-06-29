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

use PagForPHP\resources\generico\retorno\L060\Generico9;

class Registro9 extends Generico9
{

    protected $meta = array(
        // Código do Banco                          001   003   9(003)   033
        'codigo_banco'  => array(
            'tamanho'   => 3,
            'default'   => '033',
            'tipo'      => 'int',
            'required'  => true
		),
        // Lote de Serviço                          004   007   9(004)   9999
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => 9999,
            'tipo' => 'int',
            'required' => true
		),
        // Tipo de Registro                         008   008   9(001)   9
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '9',
            'tipo' => 'int',
            'required' => true
		),
        // Filler                                   009   017   X(009)   Brancos
        'filler1' => array(
            'tamanho' => 9,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
		),
        // Quantidade de lotes do arquivo           018   023   9(006)   Registros Tipo 1
        'qtd_lotes' => array(
            'tamanho' => 6,
            'default' => '1',
            'tipo' => 'int',
            'required' => true
		),
        // Quantidade de registros no arquivo       024   029   9(006)   Registros Tipo 0, 1, 3, 5 e 9
        'qtd_registros' => array(
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
		),
        // Filler                                   030   240   X(211)   Brancos
        'filler2' => array(
            'tamanho' => 211,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
		),
    );
}
