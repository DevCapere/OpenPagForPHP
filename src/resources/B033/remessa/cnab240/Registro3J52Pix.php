<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Santander — Segmento J-52 PIX (QR estático / dinâmico).
 *
 * Layout distinto do J-52 de boleto: após cedente vem Chave de pagamento (URL/chave)
 * + TXID — não reutilizar {@see Registro3J52}.
 *
 * @see sispag_cnab_SANTANDER.txt — SEGMENTO J-52 PIX (Notas 41 / 38)
 * @see SUS-4127
 */
class Registro3J52Pix extends Generico3 {

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
        // Pos. 132-208 — Nota 41: URL (sem https) ou chave PIX do QR
        // alfa2: preserva case da URL/TXID (paths e identificadores são case-sensitive)
        'chave_pagamento' => [
            'tamanho' => 77,
            'default' => ' ',
            'tipo' => 'alfa2',
            'required' => true,
        ],
        // Pos. 209-240 — Nota 38: TXID (obrigatório em QR dinâmico)
        'txid' => [
            'tamanho' => 32,
            'default' => ' ',
            'tipo' => 'alfa2',
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
            $this->entryData['documento_cedente']
                ?? $this->entryData['numero_inscricao_cedente']
                ?? $this->entryData['documento_favorecido']
                ?? null,
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

    protected function set_chave_pagamento($value) {
        $raw = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['chave_pagamento']
                ?? $this->entryData['url_pix']
                ?? $this->entryData['chave_pix']
                ?? $this->entryData['qr_code_pix']
                ?? '');

        $this->data['chave_pagamento'] = $this->normalizarChavePagamento((string) $raw);
    }

    protected function set_txid($value) {
        $txid = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['txid'] ?? $this->entryData['tx_id'] ?? '');

        $this->data['txid'] = trim((string) $txid);
    }

    /**
     * Nota 41: URL dinâmica sem esquema https:// (também remove http://).
     */
    public static function normalizarChavePagamento(string $chave): string {
        $chave = trim($chave);
        if ($chave === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $chave)) {
            $chave = preg_replace('#^https?://#i', '', $chave) ?? $chave;
        }

        return $chave;
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
