<?php

namespace PagForPHP\resources\B341\retorno\L080;

/**
 * SISPAG Itaú — Retorno: Segmento J-52 (sacado/cedente/sacador).
 */
class Registro3J52 extends AbstractDetalhe {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '3', 'tipo' => 'int', 'required' => true],
        'numero_registro' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_segmento' => ['tamanho' => 1, 'default' => 'J', 'tipo' => 'alfa', 'required' => true],
        'tipo_movimento' => ['tamanho' => 3, 'default' => '000', 'tipo' => 'int', 'required' => true],
        'codigo_registro' => ['tamanho' => 2, 'default' => '52', 'tipo' => 'int', 'required' => true],
        'tipo_inscricao_sacado' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'numero_inscricao_sacado' => ['tamanho' => 15, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_sacado' => ['tamanho' => 40, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'tipo_inscricao_cedente' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'numero_inscricao_cedente' => ['tamanho' => 15, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_cedente' => ['tamanho' => 40, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'tipo_inscricao_sacador' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'numero_inscricao_sacador' => ['tamanho' => 15, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_sacador' => ['tamanho' => 40, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler1' => ['tamanho' => 53, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

}
