<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L080\Generico0;

/**
 * SISPAG Itaú — Retorno: Header de Arquivo (layout 080).
 */
class Registro0 extends Generico0 {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'filler1' => ['tamanho' => 6, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'versao_layout' => ['tamanho' => 3, 'default' => '080', 'tipo' => 'int', 'required' => true],
        'tipo_inscricao' => ['tamanho' => 1, 'default' => '', 'tipo' => 'int', 'required' => true],
        'numero_inscricao' => ['tamanho' => 14, 'default' => '', 'tipo' => 'int', 'required' => true],
        'filler2' => ['tamanho' => 20, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'agencia' => ['tamanho' => 5, 'default' => '', 'tipo' => 'int', 'required' => true],
        'filler3' => ['tamanho' => 1, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'conta' => ['tamanho' => 12, 'default' => '', 'tipo' => 'int', 'required' => true],
        'filler4' => ['tamanho' => 1, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'dac' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_empresa' => ['tamanho' => 30, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'nome_banco' => ['tamanho' => 30, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'filler5' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'codigo_remessa' => ['tamanho' => 1, 'default' => '2', 'tipo' => 'int', 'required' => true],
        'data_geracao' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'hora_geracao' => ['tamanho' => 6, 'default' => '', 'tipo' => 'int', 'required' => true],
        'zeros1' => ['tamanho' => 9, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'densidade_gravacao' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'filler6' => ['tamanho' => 69, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
        $this->inserirDetalhe();
    }

    public function inserirDetalhe(): void {
        $ns = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout;

        while (RetornoAbstract::$linesCounter < (count(RetornoAbstract::$lines) - 1)) {
            $linha = RetornoAbstract::$lines[RetornoAbstract::$linesCounter] ?? '';
            if (strlen($linha) < 8 || substr($linha, 7, 1) !== '1') {
                break;
            }

            $class = $ns . '\\Registro1';
            $lote = new $class($linha);
            $this->children[] = $lote;
        }
    }

}
