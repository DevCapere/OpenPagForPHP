<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Santander — Segmento A (TED / PIX chave / crédito).
 *
 * Layout Febraban PagFor V11.7 (p.10 / p.15): quantidade de moeda 105-119 (zeros),
 * sem ISPB/identificação 04 do layout Itaú.
 * PIX chave: câmara 009 (G014); dados bancários do favorecido em zeros.
 *
 * @see pagamento-fornecedores-layout-CNAB-240.pdf — SEGMENTO A
 */
class Registro3A extends Generico3 {

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
            'default' => 'A',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // G011 (1) + G012 (2) — Inclusão liberada = 000
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
        // 9(010)V5 — zeros na remessa
        'quantidade_moeda' => [
            'tamanho' => 15,
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
            'tamanho' => 20,
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
        // G016 Informação 2 — mensagem (CPF do favorecido fica no Segmento B)
        'informacao_2' => [
            'tamanho' => 40,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler_finalidade' => [
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
        // G013 B — CC / PP (default CC se branco)
        'finalidade_complementar' => [
            'tamanho' => 2,
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

    protected function set_agencia_conta_favorecido($value) {
        if ($value !== '' && $value !== null) {
            $this->data['agencia_conta_favorecido'] = $value;
            return;
        }

        if ($this->isPixChave()) {
            // Modelo chave: conta do favorecido não é usada (zeros/brancos).
            $this->data['agencia_conta_favorecido'] = str_repeat('0', 5) . ' ' . str_repeat('0', 12) . '  ';
            return;
        }

        $agencia = str_pad(preg_replace('/\D/', '', $this->entryData['agencia_favorecido'] ?? '0'), 5, '0', STR_PAD_LEFT);
        $conta = str_pad(preg_replace('/\D/', '', $this->entryData['conta_favorecido'] ?? '0'), 12, '0', STR_PAD_LEFT);
        $dvConta = $this->entryData['conta_dv_favorecido'] ?? ' ';
        $dvAgencia = $this->entryData['agencia_dv_favorecido'] ?? ' ';

        $this->data['agencia_conta_favorecido'] = $agencia . $dvAgencia . $conta . ' ' . $dvConta;
    }

    protected function set_informacao_2($value) {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['informacao_2'] = $value;
            return;
        }

        // Compat: mensagens antigas enviadas como finalidade_detalhe
        $legacy = $this->entryData['informacao_2']
            ?? $this->entryData['finalidade_detalhe']
            ?? $this->entryData['mensagem']
            ?? ' ';
        $this->data['informacao_2'] = $legacy;
    }

    protected function set_finalidade_complementar($value) {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['finalidade_complementar'] = $value;
            return;
        }

        // Compat Itaú: finalidade_doc às vezes traz CC/PP
        $legacy = $this->entryData['finalidade_complementar']
            ?? $this->entryData['finalidade_doc']
            ?? ' ';
        $this->data['finalidade_complementar'] = $legacy;
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

        return (string) ($data['codigo_camara'] ?? '') === '009';
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
