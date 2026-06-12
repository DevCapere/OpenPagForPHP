<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L080\Generico5;

/**
 * SISPAG Itaú — Retorno: Trailer de Lote.
 */
class Registro5 extends Generico5 {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '5', 'tipo' => 'int', 'required' => true],
        'filler1' => ['tamanho' => 9, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'qtd_registros' => ['tamanho' => 6, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'total_valor' => ['tamanho' => 16, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'zeros1' => ['tamanho' => 18, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'filler2' => ['tamanho' => 171, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
    }

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

}
