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

use PagForPHP\resources\generico\retorno\L060\Generico1;
use PagForPHP\RetornoAbstract;

class Registro1 extends Generico1
{

    public $trailler;

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
        // Tipo de Registro                         008 008 9(001) 1
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '1',
            'tipo' => 'int',
            'required' => true
        ),
        // Tipo da Operação                         009 009 X(001) 'C' – Crédito
        'operacao' => array(
            'tamanho' => 1,
            'default' => 'C',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Tipo de Serviço                          010 011 9(002) Nota G015
        'tipo_servico' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Forma de Lançamento                      012 013 9(002) Nota G002
        'forma_lancamento' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Número da Versão do Lote                 014 016 9(003) 031 (Nota G031)
        'versa_layout' => array(
            'tamanho' => 3,
            'default' => '031',
            'tipo' => 'int',
            'required' => true
        ),
        // Filler                                   017 017 X(001) Branco
        'filler1' => array(
            'tamanho' => 1,
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
        // Número de Inscrição da Empresa           019 032 9(014) CNPJ/CPF
        'numero_inscricao' => array(
            'tamanho' => 14,
            'default' => '',
            'tipo' => 'int',
            'required' => true
        ),
        // Código do Convenio no Banco              033 052 X(020) Nota G009
        'codigo_beneficiario' => array(
            'tamanho' => 20,
            'default' => '',
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
        // Dígito Verificador da Agência/Conta      072 072 X(001) Branco
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
        // Informação 1 - Mensagem                  103 142 X(040) Nota G016
        'informacao_1' => array(
            'tamanho' => 40,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // Endereço                                 143 172 X(030) Opcional
        'endereco_logradouro' => array(
            'tamanho' => 30,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Número                                   173 177 9(005) Opcional
        'endereco_numero' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => false
        ),
        // Complemento do Endereço                  178 192 X(015) Opcional
        'endereco_complemento' => array(
            'tamanho' => 15,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Cidade                                   193 212 X(020) Opcional
        'cidade' => array(
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // CEP                                      213 217 9(005) Opcional
        'prefixo_cep' => array(
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => false
        ),
        // Complemento do CEP                       218 220 9(003) Opcional
        'sufixo_cep' => array(
            'tamanho' => 3,
            'default' => '',
            'tipo' => 'int',
            'required' => false
        ),
        // UF                                       221 222 X(002) Opcional
        'uf' => array(
            'tamanho' => 2,
            'default' => '',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Filler                                   223 230 X(008) Brancos
        'filler2' => array(
            'tamanho' => 8,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // Ocorrências para o Retorno               231 240 X(010) Nota G007
        'codigo_ocorrencia' => array(
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
        $this->inserirDetalhe($linhaTxt);
    }
    /*
     * método inserirDetalhe()
     * Recebe os parametros
     * @$data = um array contendo os dados nessesarios para o arquvio
     */

    public function inserirDetalhe($linhaTxt)
    {
        while (
            isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]) &&
            $this->data['codigo_lote'] == abs(substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 3, 4)) && 
            substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 7, 1) == '3'
        ) {
            $linhaAtual = RetornoAbstract::$linesCounter;
            $this->inserirRegistro3Segmento('A');
            //# SEGMENTO B IMPORTADO DENTRO DO A POIS DEPENDE DE INFORMAÇÃO DO A PARA SABER O LAYOUT
            $this->inserirRegistro3Segmento('C');
            $this->inserirRegistro3Segmento('I');
            $this->inserirRegistro3Segmento('J');
            $this->inserirRegistro3Segmento('N');
            $this->inserirRegistro3Segmento('O');
            $this->inserirRegistro3Segmento('W');
            $this->inserirRegistro3Segmento('Z');

            if ($linhaAtual == RetornoAbstract::$linesCounter) {
                // A linha atual não tem nenhum registro do Layout atual
                RetornoAbstract::$linesCounter++;
            }
        }
    }

    private function inserirRegistro3Segmento($segmento) {
        if (
            isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]) &&
            substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 13, 1) == $segmento
        ) {
            $class = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout . '\Registro3' . $segmento;
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
        return CodigosOcorrencia::getRelacao($this->codigo_ocorrencia);
    }
}
