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
class Registro3N extends Generico3
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
        // Código Segmento no Registro Detalhe      014 014 X(001) N
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'N',
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
        // Número do Documento Cliente              018 037 X(020) Nota G006
        'seu_numero' => array(
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Número do Documento Banco                038 057 X(020) Nota G017
        'nosso_numero' => array(
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome do Contribuinte                     058 087 X(030) Obrigatório
        'nome_contrinuinte' => array(
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data do Pagamento                        088 095 9(008) DDMMAAAA
        'data_pagamento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Valor Total do Pagamento                 096 110 9(013)V2 Nota G022
        'vlr_pagamento' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Informações Complementares do Tributo    111 230 120 Vide descrição de cada tributo a seguir
        'info_complementar_tributo' => array(
            'tamanho' => 120,
            'default' => '',
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
        if (empty($this->data)) {
            parent::__construct($data);
        }
        RetornoAbstract::$linesCounter++;
    }

    private $_infoComplementarTributo;
    protected function get_infoComplementarTributo() {
        if (!empty($this->_infoComplementarTributo)) {
            return $this->_infoComplementarTributo;
        }

        $tipo = $this->get_layoutComplementar();

        if (empty($tipo)) {
            return NULL;
        }

        $class = 'PagForPHP\\resources\\B' . RetornoAbstract::$banco . '\\retorno\\' . RetornoAbstract::$layout . '\Registro3' . $tipo;

        return new $class($this->info_complementar_tributo);


        // N014. Código de Identificação do Tributo
        // 16 = Tributo – DARF NORMAL
        // 17 = Tributo – GPS (Guia da Previdência Social)
        // 22 = Tributo - GARE-SP ICMS
        // 23 = Tributo - GARE-SP DR
        // 24 = Tributo - GARE-SP ITCMD
        // 25 = Tributo – IPVA – SP, PR e MG
        // 26 = Tributo – Licenciamento – SP, PR e MG
        // 27 = Tributo – DPVAT – SP, PR e MG
    }

    public function get_layoutComplementar() {
        $tipo = substr($this->linha, 132, 2);
        $map = [
            '16' => 'N2',
            '17' => 'N1',
            '22' => 'N4',
            '23' => 'N4',
            '24' => 'N4',
            '25' => 'N5',
            '26' => 'N7',
            '27' => 'N6',
        ];

        return $map[$tipo] ?? NULL;
    }

}
