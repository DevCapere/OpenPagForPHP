<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Itaú — Segmento B (complemento favorecido / TED).
 *
 * @see sispag_cnab_itau_B341.txt — REGISTRO DETALHE SEGMENTO B
 */
class Registro3B extends Generico3 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '341',
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
            'default' => '3',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_registro' => [
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_segmento' => [
            'tamanho' => 1,
            'default' => 'B',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_inscricao_favorecido' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao_favorecido' => [
            'tamanho' => 14,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'endereco' => [
            'tamanho' => 30,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'numero_endereco' => [
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'complemento_endereco' => [
            'tamanho' => 15,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'bairro' => [
            'tamanho' => 15,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'cidade' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'cep' => [
            'tamanho' => 8,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'estado' => [
            'tamanho' => 2,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'email' => [
            'tamanho' => 100,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 3,
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

    protected function set_tipo_inscricao_favorecido($value) {
        if ($value === 1 || $value === 2 || $value === '1' || $value === '2') {
            $this->data['tipo_inscricao_favorecido'] = (int) $value;
            return;
        }

        $documento = preg_replace('/\D/', '', (string) ($this->entryData['documento_favorecido'] ?? ''));
        $this->data['tipo_inscricao_favorecido'] = strlen($documento) > 11 ? 2 : 1;
    }

    protected function set_numero_inscricao_favorecido($value) {
        $documento = $value !== '' && $value !== '0'
            ? $value
            : ($this->entryData['documento_favorecido'] ?? '0');

        $this->data['numero_inscricao_favorecido'] = preg_replace('/\D/', '', (string) $documento);
    }

}
