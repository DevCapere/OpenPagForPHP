<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use Exception;
use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Itaú — Segmento J (liquidação de boleto).
 *
 * @see sispag_cnab_itau_B341.txt — REGISTRO DETALHE SEGMENTO J
 */
class Registro3J extends Generico3 {

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
        'codigo_barras_banco' => [
            'tamanho' => 3,
            'default' => '',
            'tipo' => 'digitos',
            'required' => true,
        ],
        'codigo_barras_moeda' => [
            'tamanho' => 1,
            'default' => '9',
            'tipo' => 'digitos',
            'required' => true,
        ],
        'codigo_barras_dv' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'digitos',
            'required' => true,
        ],
        'codigo_barras_vencimento' => [
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'digitos',
            'required' => true,
        ],
        'codigo_barras_valor' => [
            'tamanho' => 10,
            'default' => '0',
            'tipo' => 'digitos',
            'required' => true,
        ],
        'codigo_barras_campo_livre' => [
            'tamanho' => 25,
            'default' => '0',
            // digitos: serialização segura sem float (SUS-4117)
            'tipo' => 'digitos',
            'required' => true,
        ],
        'nome_favorecido' => [
            'tamanho' => 30,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'data_vencimento' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'valor_titulo' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'descontos' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'acrescimos' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'data_pagamento' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'valor_pagamento' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'zeros1' => [
            'tamanho' => 15,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'seu_numero' => [
            'tamanho' => 20,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 13,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'nosso_numero' => [
            'tamanho' => 15,
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

    public function __construct($data = null) {
        $data = $this->enriquecerComCodigoBarras($data ?? []);
        parent::__construct($data);
        $this->inserirSegmentoJ52($data);
    }

    protected function set_valor_pagamento($value) {
        if ($value !== '' && $value !== null && $value !== '0') {
            $this->data['valor_pagamento'] = $value;
            return;
        }

        $this->data['valor_pagamento'] = $this->entryData['valor']
            ?? $this->entryData['valor_titulo']
            ?? $this->entryData['vlr_nominal']
            ?? '0';
    }

    protected function set_valor_titulo($value) {
        if ($value !== '' && $value !== null && $value !== '0') {
            $this->data['valor_titulo'] = $value;
            return;
        }

        $this->data['valor_titulo'] = $this->entryData['valor']
            ?? $this->entryData['valor_pagamento']
            ?? $this->entryData['vlr_nominal']
            ?? '0';
    }

    protected function set_seu_numero($value) {
        $this->data['seu_numero'] = $value !== '' ? $value : ($this->entryData['documento_id'] ?? $this->entryData['seu_numero'] ?? '');
    }

    protected function set_nome_favorecido($value) {
        $this->data['nome_favorecido'] = $value !== '' ? $value : ($this->entryData['nome_favorecido'] ?? $this->entryData['nome_beneficiario'] ?? '');
    }

    protected function set_data_pagamento($value) {
        $this->data['data_pagamento'] = ($value !== '' && $value !== null)
            ? $value
            : ($this->entryData['data_pagamento'] ?? date('Y-m-d'));
    }

    protected function set_data_vencimento($value) {
        $this->data['data_vencimento'] = ($value !== '' && $value !== null)
            ? $value
            : ($this->entryData['data_vencimento'] ?? $this->entryData['data_pagamento'] ?? date('Y-m-d'));
    }

    private function enriquecerComCodigoBarras(array $data): array {
        $codigoBarras = self::resolverCodigoBarras($data);

        return array_merge($data, [
            'codigo_barras_banco'       => substr($codigoBarras, 0, 3),
            'codigo_barras_moeda'       => substr($codigoBarras, 3, 1),
            'codigo_barras_dv'          => substr($codigoBarras, 4, 1),
            'codigo_barras_vencimento'  => substr($codigoBarras, 5, 4),
            'codigo_barras_valor'       => substr($codigoBarras, 9, 10),
            'codigo_barras_campo_livre' => substr($codigoBarras, 19, 25),
        ]);
    }

    public static function resolverCodigoBarras(array $data): string {
        if (!empty($data['codigo_barras'])) {
            $codigo = preg_replace('/\D/', '', (string) $data['codigo_barras']);
            if (strlen($codigo) !== 44) {
                throw new Exception('codigo_barras deve conter 44 dígitos.');
            }

            return $codigo;
        }

        $linha = preg_replace('/\D/', '', (string) ($data['linha_digitavel'] ?? ''));
        if ($linha === '') {
            throw new Exception('Boleto exige codigo_barras ou linha_digitavel.');
        }

        if (strlen($linha) === 44) {
            return $linha;
        }

        if (strlen($linha) === 47) {
            return substr($linha, 0, 3)
                . substr($linha, 3, 1)
                . substr($linha, 32, 1)
                . substr($linha, 33, 4)
                . substr($linha, 37, 10)
                . substr($linha, 4, 5)
                . substr($linha, 10, 10)
                . substr($linha, 21, 10);
        }

        throw new Exception('linha_digitavel deve conter 47 dígitos.');
    }

    public static function formaPagamentoPorCodigoBarras(string $codigoBarras): string {
        return substr($codigoBarras, 0, 3) === '341' ? '30' : '31';
    }

    private function inserirSegmentoJ52(array $data): void {
        // Sequencial próprio (00002…): alinhado a remessas aceitas pelo Itaú/portal.
        // Não reutilizar numero_registro do J (Nota 9 no papel ≠ arquivo real — SUS-4117).
        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro3J52';
        $this->children[] = new $class($data);
    }

}
