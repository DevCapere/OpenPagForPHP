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
class Registro3A extends Generico3
{

    /**
     * G011. Tipo de Movimento
     */
    protected $tipoMovimento = array(
        '0' => 'Indica INCLUSÃO',
        '3' => 'Indica ESTORNO (somente para retorno)',
        '5' => 'Indica ALTERAÇÃO',
        '8' => 'Indica INCLUSÃO COMPROR',
        '9' => 'Indica EXCLUSÃO',
    );

    /**
     * G012. Código da Instrução para Movimento
     */
    protected $instrucaoMovimento = array(
        '00' => 'Inclusão de Registro Detalhe Liberado',
        '09' => 'Inclusão do Registro Detalhe Bloqueado Pendente de Autorização',
        '10' => 'Alteração do Pagamento Liberado para Bloqueado (Bloqueio)',
        '11' => 'Alteração do Pagamento Bloqueado para Liberado (Desbloqueio)',
        '14' => 'Autorização do Pagamento',
        '33' => 'Estorno por Devolução da Câmara Centralizadora (somente Tipo de Movimento = 3)',
    );

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
        // Código Segmento do Registro Detalhe     014 014 X(001) A
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'A',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Tipo de Movimento                       015 015 9(001) Nota G011
        'tipo_movimento' => array(
            'tamanho' => 1,
            'default' => '1',
            'tipo' => 'int',
            'required' => true
        ),
        // Código da Instrução para Movimento      016 017 9(002) Nota G012
        'codigo_instrucao_movimento' => array(
            'tamanho' => 2,
            'default' => '01',
            'tipo' => 'int',
            'required' => true
        ),
        // Código Câmara Compensação               018 020 9(003) Nota G014
        'codigo_camara_compensacao' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código do Banco Favorecido              021 023 9(003) Obrigatório
        'codigo_banco_favorecido' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código da Agência Favorecido            024 028 9(005) Nota G003
        'agencia_favorecido' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Dígito Verificador da Agência           029 029 X(001) Branco
        'agencia_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Conta Corrente do Favorecido            030 041 9(012) Nota G003
        'conta_favorecido' => array(
            'tamanho' => 12,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Dígito Verificador da Conta             042 042 X(001) Nota G003
        'conta_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Dígito Verificador da Agência/Conta     043 043 X(001) Nota G003
        'agencia_conta_dv_favorecido' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome do Favorecido                      044 073 X(030) Obrigatório
        'nome_favorecido' => array(
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nro. do Documento Cliente               074 093 X(020) Nota G006
        'documento_favorecido' => array(
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data do Pagamento                       094 101 9(008) DDMMAAAA
        'data_pagamento' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Tipo da Moeda                       102 104 X(003) Nota G005
        'tipo_moeda' => array(
            'tamanho' => 3,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Quantidade de Moeda                 105 119 9(010)V5 Zeros
        'qtd_moeda' => array(
            'tamanho' => 10,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 5,
            'required' => true
        ),
        // Valor do Pagamento                  120 134 9(013)V2 Obrigatório
        'vlr_pagamento' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Nro. do Documento Banco             135 154 X(020) Nota G017
        'nosso_numero' => array(
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Data Real do Pagamento (Retorno)    155 162 9(008) DDMMAAAA
        'data_pagamento_real' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Valor Real do Pagamento             163 177 9(013)V2 Opcional
        'vlr_pagamento_real' => array(
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true
        ),
        // Informação 2 - Mensagem             178 217 X(040) Nota G016
        'informacao_2' => array(
            'tamanho' => 40,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Finalidade do DOC                   218 219 X(002) Nota G013 A
        'finalidade_doc' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Finalidade de TED                   220 224 X(005) Nota G013 B
        'finalidade_ted' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código Finalidade Complementar      225 226 X(002) Nota G013 C
        'finalidade_complementar' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                              227 229 X(003) Brancos
        'filler2' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Emissão de Aviso ao Favorecido      230 230 X(001) Zeros (Nota G018)
        'aviso' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Ocorrências para o Retorno          231 240 X(010) Nota G007
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
        $this->inserirDetalhe($data);
    }

    public function inserirDetalhe($data)
    {
        if (
            isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]) && 
            substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 13, 1) == 'B'
        ) {

            $tipo = $this->data['codigo_camara_compensacao'] == '009' ? '_Pix' : '_TedDoc';

            $class = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout . '\Registro3B' . $tipo;
            $this->children[] = new $class(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
        }
    }

    /**
     * Retorna um array com a lista das descrições de comando e detalhes do
     * comando para o movimento
     * 
     * @return array
     */
    public function get_arrayOcorrencias(){
        $detalhes = new DetalhaMovimentoRetorno('033','240');

        $codigoMovimento = str_pad($this->data['codigo_movimento'], 2, 0, STR_PAD_LEFT);

        return $detalhes->getArrayTxtOcorrencias($codigoMovimento, $this->data['codigo_ocorrencia']);
    }
}
