<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Itaú — Segmento A (TED / PIX Transferência / crédito em conta).
 *
 * PIX Transferência (forma 45): câmara SPI 009 + identificação transferência 04 (chave).
 *
 * @see sispag_cnab_itau_B341.txt — REGISTRO DETALHE SEGMENTO A
 */
class Registro3A extends Generico3 {

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
            'default' => 'A',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_movimento' => [
            'tamanho' => 3,
            'default' => '000',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_camara' => [
            'tamanho' => 3,
            'default' => '018',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_banco_favorecido' => [
            'tamanho' => 3,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'agencia_conta_favorecido' => [
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'nome_favorecido' => [
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'seu_numero' => [
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'data_pagamento' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'tipo_moeda' => [
            'tamanho' => 3,
            'default' => 'REA',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'codigo_ispb' => [
            'tamanho' => 8,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'identificacao_transferencia' => [
            'tamanho' => 2,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'zeros1' => [
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'valor' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'nosso_numero' => [
            'tamanho' => 15,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 5,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'data_efetiva' => [
            'tamanho' => 8,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'valor_efetivo' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'finalidade_detalhe' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'numero_documento' => [
            'tamanho' => 6,
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
        'finalidade_doc' => [
            'tamanho' => 2,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'finalidade_ted' => [
            'tamanho' => 5,
            'default' => '00010',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 5,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'aviso_favorecido' => [
            'tamanho' => 1,
            'default' => '0',
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

    public function __construct($data = null) {
        parent::__construct($data);

        if ($this->shouldIncludeSegmentoB($data)) {
            $this->inserirSegmentoB($data ?? []);
        }
    }

    protected function set_codigo_camara($value) {
        if ($this->isPixChave()) {
            $explicit = $this->entryData['codigo_camara'] ?? null;
            $this->data['codigo_camara'] = ($explicit !== null && $explicit !== '')
                ? $explicit
                : '009';
            return;
        }

        if ($value !== '' && $value !== null) {
            $this->data['codigo_camara'] = $value;
            return;
        }

        $this->data['codigo_camara'] = $this->entryData['codigo_camara'] ?? $this->meta['codigo_camara']['default'];
    }

    protected function set_identificacao_transferencia($value) {
        if ($this->isPixChave()) {
            $explicit = $this->entryData['identificacao_transferencia'] ?? null;
            $this->data['identificacao_transferencia'] = ($explicit !== null && trim((string) $explicit) !== '')
                ? $explicit
                : '04';
            return;
        }

        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['identificacao_transferencia'] = $value;
            return;
        }

        $this->data['identificacao_transferencia'] = $this->entryData['identificacao_transferencia']
            ?? $this->meta['identificacao_transferencia']['default'];
    }

    protected function set_agencia_conta_favorecido($value) {
        if ($value !== '' && $value !== null) {
            $this->data['agencia_conta_favorecido'] = $value;
            return;
        }

        if ($this->isPixChave()) {
            // Modelo chave: conta do favorecido não é usada; preencher com brancos/zeros.
            $this->data['agencia_conta_favorecido'] = str_repeat('0', 5) . ' ' . str_repeat('0', 12) . '  ';
            return;
        }

        $agencia = str_pad(preg_replace('/\D/', '', $this->entryData['agencia_favorecido'] ?? '0'), 5, '0', STR_PAD_LEFT);
        $conta = str_pad(preg_replace('/\D/', '', $this->entryData['conta_favorecido'] ?? '0'), 12, '0', STR_PAD_LEFT);
        $dvConta = $this->entryData['conta_dv_favorecido'] ?? ' ';
        $dvAgencia = $this->entryData['agencia_dv_favorecido'] ?? ' ';

        $this->data['agencia_conta_favorecido'] = $agencia . $dvAgencia . $conta . ' ' . $dvConta;
    }

    protected function set_numero_inscricao_favorecido($value) {
        $documento = ($value !== '' && $value !== null && $value !== '0' && $value !== 0)
            ? $value
            : ($this->entryData['documento_favorecido']
                ?? $this->entryData['numero_inscricao_favorecido']
                ?? '0');

        $digits = preg_replace('/\D/', '', (string) $documento) ?: '';

        // RN-36b: chave CPF/CNPJ pode preencher inscrição no A quando titular veio vazio.
        if ($digits === '' && $this->isPixChave()) {
            $tipoChave = str_pad(
                trim((string) ($this->entryData['tipo_chave_pix'] ?? $this->entryData['tipo_chave'] ?? '')),
                2,
                '0',
                STR_PAD_LEFT
            );
            if ($tipoChave === '03') {
                $digits = preg_replace(
                    '/\D/',
                    '',
                    (string) ($this->entryData['chave_pix'] ?? $this->entryData['pix_chave'] ?? '')
                ) ?: '';
            }
        }

        $this->data['numero_inscricao_favorecido'] = $digits !== '' ? $digits : '0';
    }

    protected function set_data_pagamento($value) {
        if ($value !== '' && $value !== null) {
            $this->data['data_pagamento'] = $value;
            return;
        }

        $this->data['data_pagamento'] = $this->entryData['data_pagamento'] ?? date('Y-m-d');
    }

    protected function set_seu_numero($value) {
        $this->data['seu_numero'] = $value !== '' ? $value : ($this->entryData['documento_id'] ?? $this->entryData['seu_numero'] ?? '');
    }

    protected function set_nome_favorecido($value) {
        $this->data['nome_favorecido'] = $value !== '' ? $value : ($this->entryData['nome_favorecido'] ?? '');
    }

    protected function set_codigo_banco_favorecido($value) {
        if ($value !== '' && $value !== null) {
            $this->data['codigo_banco_favorecido'] = $value;
            return;
        }

        if ($this->isPixChave()) {
            $this->data['codigo_banco_favorecido'] = $this->entryData['banco_favorecido'] ?? '000';
            return;
        }

        $this->data['codigo_banco_favorecido'] = $this->entryData['banco_favorecido'] ?? '';
    }

    private function isPixChave(): bool {
        $data = $this->entryData;

        if (!empty($data['pix']) || !empty($data['chave_pix']) || !empty($data['pix_chave'])) {
            return true;
        }

        $camara = (string) ($data['codigo_camara'] ?? '');
        $ident = (string) ($data['identificacao_transferencia'] ?? '');

        return $camara === '009' || $ident === '04';
    }

    private function shouldIncludeSegmentoB($data): bool {
        if (isset($data['incluir_segmento_b'])) {
            return (bool) $data['incluir_segmento_b'];
        }

        if ($this->isPixChave()) {
            $chave = $data['chave_pix'] ?? $data['pix_chave'] ?? '';
            return $chave !== '' && $chave !== null;
        }

        $documento = $data['documento_favorecido'] ?? $data['numero_inscricao_favorecido'] ?? '';

        return $documento !== '' && $documento !== null;
    }

    private function inserirSegmentoB(array $data): void {
        $ns = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout;
        $class = $this->isPixChave()
            ? $ns . '\Registro3BPix'
            : $ns . '\Registro3B';
        $this->children[] = new $class($data);
    }

}
