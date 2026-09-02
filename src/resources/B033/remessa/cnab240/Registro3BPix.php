<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Santander — Segmento B PIX (chave / dados bancários).
 *
 * Manual V11.7 p.16 + G032–G035:
 * 015-016 forma iniciação · 033-067 Info10 · 068-127 Info11 · 128-226 Info12 (chave) · 233-240 ISPB.
 *
 * @see pagamento-fornecedores-layout-CNAB-240.pdf — SEGMENTO B PIX
 */
class Registro3BPix extends Generico3 {

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
            'default' => 'B',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // G032 — Forma de Iniciação
        'tipo_chave_pix' => [
            'tamanho' => 2,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 1,
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
        // G033 — TXID (opcional; QR estático em A+B)
        'informacao_10' => [
            'tamanho' => 35,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // G034 — livre / info ao recebedor
        'informacao_11' => [
            'tamanho' => 60,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // G035 — chave PIX (99)
        'chave_pix' => [
            'tamanho' => 99,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler_reservado' => [
            'tamanho' => 6,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // G030 — ISPB (zeros quando iniciação por chave)
        'codigo_ispb' => [
            'tamanho' => 8,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
    ];

    protected function set_tipo_chave_pix($value) {
        if ($value !== '' && $value !== null) {
            $this->data['tipo_chave_pix'] = str_pad((string) $value, 2, '0', STR_PAD_LEFT);
            return;
        }

        $fromEntry = $this->entryData['tipo_chave_pix'] ?? $this->entryData['tipo_chave'] ?? '';
        $this->data['tipo_chave_pix'] = $fromEntry !== ''
            ? str_pad((string) $fromEntry, 2, '0', STR_PAD_LEFT)
            : '  ';
    }

    protected function set_informacao_10($value) {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['informacao_10'] = $value;
            return;
        }

        $this->data['informacao_10'] = $this->entryData['informacao_10']
            ?? $this->entryData['txid']
            ?? ' ';
    }

    protected function set_informacao_11($value) {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['informacao_11'] = $value;
            return;
        }

        // Compat: campo antigo informacao_usuario
        $this->data['informacao_11'] = $this->entryData['informacao_11']
            ?? $this->entryData['informacao_usuario']
            ?? ' ';
    }

    protected function set_chave_pix($value) {
        $chave = $value !== '' && $value !== null
            ? $value
            : ($this->entryData['chave_pix'] ?? $this->entryData['pix_chave'] ?? '');

        $this->data['chave_pix'] = $this->normalizarChavePixPorTipo(
            (string) $chave,
            (string) ($this->data['tipo_chave_pix'] ?? $this->entryData['tipo_chave_pix'] ?? '')
        );
    }

    /**
     * Telefone (01) e CPF/CNPJ (03) só dígitos; e-mail (02) e aleatória (04) preservam texto.
     */
    private function normalizarChavePixPorTipo(string $chave, string $tipoChave): string {
        $chave = trim($chave);
        $tipo = str_pad(trim($tipoChave), 2, '0', STR_PAD_LEFT);

        if (in_array($tipo, ['01', '03'], true)) {
            return preg_replace('/\D/', '', $chave) ?? '';
        }

        if ($this->chavePareceDocumentoComMascara($chave)) {
            return preg_replace('/\D/', '', $chave) ?? '';
        }

        return $chave;
    }

    private function chavePareceDocumentoComMascara(string $chave): bool {
        if ($chave === '' || !preg_match('/^[\d.\-\/\s]+$/', $chave)) {
            return false;
        }

        $digits = preg_replace('/\D/', '', $chave) ?? '';

        return strlen($digits) === 11 || strlen($digits) === 14;
    }

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

        $digits = preg_replace('/\D/', '', (string) $documento) ?: '';

        // G035: tipo 03 — chave CPF/CNPJ = mesmo documento 019-032
        if ($digits === '') {
            $tipo = str_pad(
                trim((string) ($this->data['tipo_chave_pix'] ?? $this->entryData['tipo_chave_pix'] ?? '')),
                2,
                '0',
                STR_PAD_LEFT
            );
            if ($tipo === '03') {
                $digits = preg_replace(
                    '/\D/',
                    '',
                    (string) ($this->entryData['chave_pix'] ?? $this->entryData['pix_chave'] ?? '')
                ) ?: '';
            }
        }

        $this->data['numero_inscricao_favorecido'] = $digits !== '' ? $digits : '0';
    }

    protected function set_codigo_ispb($value) {
        if ($value !== '' && $value !== null && $value !== '0' && $value !== 0) {
            $this->data['codigo_ispb'] = $value;
            return;
        }

        $this->data['codigo_ispb'] = $this->entryData['codigo_ispb']
            ?? $this->entryData['ispb']
            ?? '0';
    }

}
