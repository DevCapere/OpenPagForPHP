<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Itaú — Segmento B para PIX Transferência (modelo chave).
 *
 * Layout distinto do Segmento B de TED (endereço): tipo de chave + chave PIX.
 *
 * @see sispag_cnab.txt — REGISTRO DETALHE SEGMENTO B (OBRIGATÓRIO PARA PIX)
 */
class Registro3BPix extends Generico3 {

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
        'filler2' => [
            'tamanho' => 30,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'informacao_usuario' => [
            'tamanho' => 65,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'chave_pix' => [
            'tamanho' => 100,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler3' => [
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

    protected function set_chave_pix($value) {
        $chave = $value !== '' && $value !== null
            ? $value
            : ($this->entryData['chave_pix'] ?? $this->entryData['pix_chave'] ?? '');

        // SisPag Itaú: telefone (01) e CPF/CNPJ (03) só com dígitos — defesa na lib.
        $this->data['chave_pix'] = $this->normalizarChavePixPorTipo(
            (string) $chave,
            (string) ($this->data['tipo_chave_pix'] ?? $this->entryData['tipo_chave_pix'] ?? '')
        );
    }

    /**
     * Remove máscara de CPF/CNPJ/telefone; e-mail (02) e aleatória (04) preservam o texto.
     * Também trata chave com máscara de documento mesmo se o tipo vier inconsistente.
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

        $this->data['numero_inscricao_favorecido'] = preg_replace('/\D/', '', (string) $documento);
    }

    protected function set_informacao_usuario($value) {
        if ($value !== '' && $value !== null) {
            $this->data['informacao_usuario'] = $value;
            return;
        }

        $this->data['informacao_usuario'] = $this->entryData['informacao_usuario'] ?? ' ';
    }

}
