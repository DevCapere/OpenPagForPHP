<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico0;

/**
 * SISPAG Itaú — Registro Header de Arquivo (layout 080).
 *
 * @see sispag_cnab_itau_B341.txt — REGISTRO HEADER DE ARQUIVO
 */
class Registro0 extends Generico0 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '341',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_lote' => [
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_registro' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 6,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'versao_layout' => [
            'tamanho' => 3,
            'default' => '080',
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_inscricao' => [
            'tamanho' => 1,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao' => [
            'tamanho' => 14,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'agencia' => [
            'tamanho' => 5,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler3' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'conta' => [
            'tamanho' => 12,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler4' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'dac' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'nome_empresa' => [
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'nome_banco' => [
            'tamanho' => 30,
            'default' => 'BANCO ITAU SA',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler5' => [
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'codigo_remessa' => [
            'tamanho' => 1,
            'default' => '1',
            'tipo' => 'int',
            'required' => true,
        ],
        'data_geracao' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'hora_geracao' => [
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        // SisPag layout 080: pos. 158-166 = ZEROS (complemento). Não há NSA no header de arquivo.
        // Sequencial da remessa Capere fica no nome do .rem / seq_remessa — não neste campo.
        'zeros1' => [
            'tamanho' => 9,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        // Nota 2: teleprocessamento → zeros.
        'densidade_gravacao' => [
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler6' => [
            'tamanho' => 69,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
    ];

    protected function set_dac($value) {
        $this->data['dac'] = $value !== '' ? $value : ($this->entryData['conta_dv'] ?? $this->meta['dac']['default']);
    }

    protected function set_hora_geracao($value) {
        $this->data['hora_geracao'] = $value !== '' ? $value : date('His');
    }

}
