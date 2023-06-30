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

use PagForPHP\resources\generico\retorno\L060\Generico0;
use PagForPHP\RetornoAbstract;

class Registro0 extends Generico0
{

    public $trailler;

    protected $meta = array(
        // Código do Banco                          001 003 9(003) 033
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true
        ),
        // Lote de Serviço                          004 007 9(004) 0000
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => '0000',
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo de Registro                         008 008 9(001) 0
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                   009 017 X(009) Brancos
        'filler1' => array(
            'tamanho' => 9,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Tipo de Inscrição da Empresa             018 018 9(001) Nota G023
        'tipo_inscricao' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Número Inscrição da Empresa              019 032 9(014) CNPJ/CPF
        'numero_inscricao' => array(
            'tamanho' => 14,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Código do Convenio no Banco              033 052 X(020) Nota G009
        'codigo_beneficiario' => array(
            'tamanho' => 20,
            'default' => '0',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Agência Mantenedora da Conta             053 057 9(005) Nota G003
        'agencia' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Dígito Verificador da Agência            058 058 X(001) Opcional
        'agencia_dv' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Número da Conta Corrente                 059 070 9(012) Nota G003
        'conta' => array(
            'tamanho' => 12,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // Dígito Verificador da Conta              071 071 X(001) Nota G003
        'conta_dv' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Dígito Verificador da Agência / Conta    072 072 X(001) Branco
        'agencia_conta_dv' => array(
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome da Empresa                          073 102 X(030) Obrigatório
        'nome_empresa' => array(
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Nome do Banco                            103 132 X(030) Banco Santander
        'nome_banco' => array(
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   133 142 X(010) Brancos
        'filler2' => array(
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Código Remessa / Retorno                 143 143 9(001) 1=Remessa / 2=Retorno
        'codigo_remessa' => array(
            'tamanho' => 1,
            'default' => '2',
            'tipo' => 'int',
            'required' => true
        ),
        // Data da Geração do Arquivo               144 151 9(008) DDMMAAAA
        'data_geracao' => array(
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true
        ),
        // Hora da Geração do Arquivo               152 157 9(006) HHMMSS
        'hora_geracao' => array(
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'time',
            'required' => true
        ),
        // Número Sequencial do Arquivo             158 163 9(006) Nota G010
        'numero_sequencial_arquivo' => array(
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Número da Versão do Layout               164 166 9(003) 060
        'versao_layout' => array(
            'tamanho' => 3,
            'default' => '060',
            'tipo' => 'int',
            'required' => true
        ),
        // Densidade de Gravação Arquivo            167 171 9(005) Opcional
        'densidade_gravacao_arquivo' => array(
            'tamanho' => 5,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Uso Reservado do Banco                   172 191 X(020) Brancos
        'uso_banco' => array(
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Uso Reservado da Empresa                 192 211 X(020) Opcional
        'uso_empresa' => array(
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Filler                                   212 230 X(019) Brancos
        'filler3' => array(
            'tamanho' => 19,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Ocorrências para o Retorno               231 240 X(010) Nota G007
        'ocorrencia' => array(
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
    );

    public function __construct($linhaTxt)
    {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
        $this->inserirDetalhe();
    }

    public function inserirDetalhe()
    {
        while (RetornoAbstract::$linesCounter < (count(RetornoAbstract::$lines) - 4))
        {
            $class = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout . '\Registro1';
            $lote = new $class(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
            $class = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout . '\Registro5';
            $lote->trailler = new $class(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
            $this->children[] = $lote;
        }
    }
}
