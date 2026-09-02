<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico5;

/**
 * SISPAG Santander — Registro Trailer de Lote.
 *
 * @see sispag_cnab_santander_B341.txt — REGISTRO TRAILER DE LOTE
 */
class Registro5 extends Generico5 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_lote' => [
            'tamanho' => 4,
            'default' => 1,
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_registro' => [
            'tamanho' => 1,
            'default' => '5',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 9,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'qtd_registros' => [
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'total_valor' => [
            'tamanho' => 16,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'zeros1' => [
            'tamanho' => 18,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 171,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'ocorrencias' => [
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
    ];

    protected function set_codigo_lote($value) {
        $this->data['codigo_lote'] = $value !== '' && $value !== null
            ? $value
            : RemessaAbstract::$loteCounter;
    }

}
