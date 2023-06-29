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
class Registro3W extends Generico3
{

    protected $meta = array(
        // Código do Banco                          001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
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
        // Código Segmento no Registro Detalhe      014 014 X(001) W
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'W',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Número Seq. Registro Complementar        015 015 9(001)
        'numero_registro_complemento' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Identifica o Uso das Informações 1 e 2   016 016 9(001) Nota N006
        'tipo_informacao_complementar' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Informação Complementar 1                017 096 X(080) Nota N007
        'informacao_complementar_1' => array(
            'tamanho' => 80,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Informação Complementar 2                097 176 X(080) Nota N007
        'informacao_complementar_2' => array(
            'tamanho' => 80,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Informação Complementar do Tributo       177 228 X(050) Vide descrição de cada tributo a seguir
        'info_complementar_tributo' => array(
            'tamanho' => 50,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Filler                                   229 230 X(002) Brancos
        'filler1' => array(
            'tamanho' => 2,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Ocorrências para o Retorno               231 240 X(010) Nota G007
        'codigo_ocorrencia' => array(
            'tamanho' => 10,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
    );

    public function __construct($data = null)
    {
        $this->setInformacoesComplementaresLayout($data);
        if (empty($this->data)) {
            parent::__construct($data);
        }
        RetornoAbstract::$linesCounter++;
    }

    private function setInformacoesComplementaresLayout($linha) {
        
    }

    /**
     * W1. INFORMAÇÃO COMPLEMENTAR DE TRIBUTO / FGTS POR CÓDIGO DE BARRAS.
     */
    private function getLayoutW1() {
        return array(
            // Identificador do Tributo 177 178 X(002) 01
            // Código da Receita do Tributo 179 184 X(006) Nota N001
            // Tipo de Identificação do Contribuinte 185 186 X(002) Nota N003
            // Identificação do Contribuinte 187 200 X(014) Nota N004
            // Identificador do FGTS 201 216 X(016) Obrigatório
            // Lacre do Conectividade Social 217 225 X(009) Obrigatório
            // Digito do Lacre do Conectividade Social 226 227 X(002) Obrigatório
            // Filler 228 228 X(001) Brancos 
        );
    }

}
