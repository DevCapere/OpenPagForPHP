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
class Registro3B_TedDoc extends Generico3 {

    
    protected $meta = array(
        // Código do Banco                         001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'alfa',
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
        // Filler                                  015 017 X(003) Brancos
        'filler1' => array(
            'tamanho' => 3,
            'default' => '',
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
        // Logradouro do Favorecido                033 062 X(030) Opcional
        'endereco_logradouro_favorecido' => array(
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Número do Local do Favorecido           063 067 9(005) Opcional
        'endereco_numero_favorecido' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Complemento do Local Favorecido         068 082 X(015) Opcional
        'endereco_complemento_favorecido' => array(
            'tamanho' => 15,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Bairro do Favorecido                    083 097 X(015) Opcional
        'endereco_bairro_favorecido' => array(
            'tamanho' => 15,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Cidade do Favorecido                    098 117 X(020) Opcional
        'cidade_favorecido' => array(
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // CEP do Favorecido                       118 125 9(008) Opcional
        'cep_favorecido' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Estado do Favorecido                    126 127 X(002) Opcional
        'uf_favorecido' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data de Vencimento                      128 135 9(008) DDMMAAAA
        'data_vencimento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Valor do Documento                      136 150 9(013)V2 Opcional
        'vlr_documento' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor do Abatimento                     151 165 9(013)V2 Opcional
        'vlr_abatimento' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor do Desconto                       166 180 9(013)V2 Opcional
        'vlr_desconto' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor da Mora                           181 195 9(013)V2 Opcional
        'vlr_mora' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Valor da Multa                          196 210 9(013)V2 Opcional
        'vlr_multa' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Horário de Envio de TED                 211 214 9(004) Zeros
        'hora_envio_ted' => array(
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                  215 225 X(011) Brancos
        'filler2' => array(
            'tamanho' => 11,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código Histórico para Crédito           226 229 9(004) Nota G019
        'codigo_historico' => array(
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Emissão de Aviso ao Favorecido          230 230 9(001) 0 (Nota G018)
        'aviso' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                  231 231 X(001) Nota G007
        'filler3' => array(
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // TED para Instituição Financeira         232 232 X(001) Nota G029
        'ted_instituicao' => array(
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Identificação da IF no SPB              233 240 X(008) Nota G030
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
