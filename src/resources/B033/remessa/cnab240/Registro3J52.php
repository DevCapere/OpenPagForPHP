<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Santander — Segmento J-52 (sacado/cedente/sacador do boleto).
 *
 * @see sispag_cnab_santander_B341.txt — REGISTRO DETALHE SEGMENTO J-52
 *
 * Sequencial (009-013): incremental no lote (J=00001, J-52=00002), como nas remessas
 * aceitas em produção/portal Santander. A Nota 9 do manual pede reutilizar o nº do J, mas
 * arquivos reais (ex.: forma 31) e o validador usam sequência contínua — SUS-4117.
 */
class Registro3J52 extends Generico3 {

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
            'default' => 'J',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_movimento' => [
            'tamanho' => 3,
            'default' => '000',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_registro' => [
            'tamanho' => 2,
            'default' => '52',
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_inscricao_sacado' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao_sacado' => [
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'nome_sacado' => [
            'tamanho' => 40,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_inscricao_cedente' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao_cedente' => [
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'nome_cedente' => [
            'tamanho' => 40,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_inscricao_sacador' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao_sacador' => [
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'nome_sacador' => [
            'tamanho' => 40,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 53,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
    ];

    protected function set_tipo_inscricao_sacado($value) {
        $this->data['tipo_inscricao_sacado'] = $this->resolveTipoInscricao(
            $value,
            $this->entryData['documento_sacado'] ?? $this->entryData['numero_inscricao_sacado'] ?? null,
            RemessaAbstract::$entryData['tipo_inscricao'] ?? 2
        );
    }

    protected function set_numero_inscricao_sacado($value) {
        $documento = $value !== '' && $value !== '0'
            ? $value
            : ($this->entryData['documento_sacado']
                ?? $this->entryData['numero_inscricao_sacado']
                ?? RemessaAbstract::$entryData['numero_inscricao']
                ?? '0');

        $this->data['numero_inscricao_sacado'] = preg_replace('/\D/', '', (string) $documento);
    }

    protected function set_nome_sacado($value) {
        $this->data['nome_sacado'] = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['nome_sacado'] ?? RemessaAbstract::$entryData['nome_empresa'] ?? ' ');
    }

    protected function set_tipo_inscricao_cedente($value) {
        $this->data['tipo_inscricao_cedente'] = $this->resolveTipoInscricao(
            $value,
            $this->entryData['documento_cedente'] ?? $this->entryData['numero_inscricao_cedente'] ?? null,
            2
        );
    }

    protected function set_numero_inscricao_cedente($value) {
        $documento = $value !== '' && $value !== '0'
            ? $value
            : ($this->entryData['documento_cedente']
                ?? $this->entryData['numero_inscricao_cedente']
                ?? $this->entryData['documento_favorecido']
                ?? '0');

        $this->data['numero_inscricao_cedente'] = preg_replace('/\D/', '', (string) $documento);
    }

    protected function set_nome_cedente($value) {
        $this->data['nome_cedente'] = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['nome_cedente']
                ?? $this->entryData['nome_favorecido']
                ?? $this->entryData['nome_beneficiario']
                ?? ' ');
    }

    protected function set_tipo_inscricao_sacador($value) {
        $documento = $this->entryData['documento_sacador'] ?? $this->entryData['numero_inscricao_sacador'] ?? '';
        $this->data['tipo_inscricao_sacador'] = $documento === '' ? 0 : $this->resolveTipoInscricao($value, $documento, 0);
    }

    protected function set_numero_inscricao_sacador($value) {
        $documento = $value !== '' && $value !== '0'
            ? $value
            : ($this->entryData['documento_sacador'] ?? $this->entryData['numero_inscricao_sacador'] ?? '0');

        $this->data['numero_inscricao_sacador'] = preg_replace('/\D/', '', (string) $documento);
    }

    protected function set_nome_sacador($value) {
        $this->data['nome_sacador'] = $value !== '' ? $value : ($this->entryData['nome_sacador'] ?? ' ');
    }

    private function resolveTipoInscricao($value, $documento, $fallback): int {
        if ($value === 1 || $value === 2 || $value === '1' || $value === '2') {
            return (int) $value;
        }

        $digits = preg_replace('/\D/', '', (string) ($documento ?? ''));

        if ($digits === '') {
            return (int) $fallback;
        }

        return strlen($digits) > 11 ? 2 : 1;
    }

}
