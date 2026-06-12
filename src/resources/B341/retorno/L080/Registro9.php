<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\resources\generico\retorno\L080\Generico9;

/**
 * SISPAG Itaú — Retorno: Trailer de Arquivo.
 */
class Registro9 extends Generico9 {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => '9999', 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '9', 'tipo' => 'int', 'required' => true],
        'filler1' => ['tamanho' => 9, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'qtd_lotes' => ['tamanho' => 6, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'qtd_registros' => ['tamanho' => 6, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'filler2' => ['tamanho' => 211, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

}
