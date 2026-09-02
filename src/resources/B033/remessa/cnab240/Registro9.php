<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico9;

/**
 * SISPAG Santander — Registro Trailer de Arquivo.
 *
 * @see sispag_cnab_santander_B341.txt — REGISTRO TRAILER DE ARQUIVO
 */
class Registro9 extends Generico9 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_lote' => [
            'tamanho' => 4,
            'default' => '9999',
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_registro' => [
            'tamanho' => 1,
            'default' => '9',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 9,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'qtd_lotes' => [
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'qtd_registros' => [
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 211,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
    ];

    protected function set_qtd_lotes($value) {
        $this->data['qtd_lotes'] = count(RemessaAbstract::$hearder->children ?? []);
    }

    protected function set_qtd_registros($value) {
        $this->data['qtd_registros'] = count(RemessaAbstract::$retorno) + 1;
    }

    public function getText() {
        $this->data['qtd_lotes'] = count(RemessaAbstract::$hearder->children ?? []);
        $this->data['qtd_registros'] = count(RemessaAbstract::$retorno) + 1;

        parent::getText();
    }

}
