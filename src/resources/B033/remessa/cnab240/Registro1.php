<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico1;

/**
 * SISPAG Santander — Registro Header de Lote.
 *
 * versao_layout: 031 (Segmento A — TED/PIX/crédito, Nota G031) ou 030 (boleto/J).
 *
 * @see pagamento-fornecedores-layout-CNAB-240.pdf — HEADER DE LOTE
 */
class Registro1 extends Generico1 {

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
            'default' => '1',
            'tipo' => 'int',
            'required' => true,
        ],
        'operacao' => [
            'tamanho' => 1,
            'default' => 'C',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_pagamento' => [
            'tamanho' => 2,
            'default' => '20',
            'tipo' => 'int',
            'required' => true,
        ],
        'forma_pagamento' => [
            'tamanho' => 2,
            'default' => '41',
            'tipo' => 'int',
            'required' => true,
        ],
        'versao_layout' => [
            'tamanho' => 3,
            'default' => '031',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
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
        // G009 — mesmo formato do header de arquivo (033+agência+convênio)
        'codigo_convenio' => [
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
        'finalidade_lote' => [
            'tamanho' => 30,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'historico_cc' => [
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'endereco_empresa' => [
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
        'filler5' => [
            'tamanho' => 8,
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

    protected function set_dac($value) {
        $this->data['dac'] = $value !== '' ? $value : ($this->entryData['conta_dv'] ?? $this->meta['dac']['default']);
    }

    /**
     * Pos. 033-052 — Código do Convênio (G009) para lotes Segmento A (versão 031).
     * Boleto / utilidades (versão 030): brancos (manual).
     */
    protected function set_codigo_convenio($value) {
        $versao = str_pad(
            (string) ($this->data['versao_layout']
                ?? $this->entryData['versao_layout']
                ?? $this->meta['versao_layout']['default']),
            3,
            '0',
            STR_PAD_LEFT
        );

        if ($versao === '030') {
            $this->data['codigo_convenio'] = str_repeat(' ', 20);
            return;
        }

        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['codigo_convenio'] = $value;
            return;
        }

        $convenio = preg_replace('/\D/', '', (string) ($this->entryData['codigo_empresa_banco'] ?? ''));
        $agencia = preg_replace('/\D/', '', (string) ($this->entryData['agencia'] ?? '0'));
        $agencia4 = substr(str_pad($agencia !== '' ? $agencia : '0', 4, '0', STR_PAD_LEFT), -4);
        $convenio12 = str_pad($convenio !== '' ? $convenio : '0', 12, '0', STR_PAD_LEFT);

        $this->data['codigo_convenio'] = str_pad('033', 4, '0', STR_PAD_LEFT) . $agencia4 . $convenio12;
    }

    public function inserirBoleto($data) {
        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro3J';
        $this->children[] = new $class($data);
    }

    /**
     * PIX QR-CODE (forma 47) — Segmento J + J-52 PIX (chave/URL + TXID).
     *
     * @see Registro3J52Pix
     * @see SUS-4127
     */
    public function inserirPixQr($data) {
        $data = is_array($data) ? $data : [];
        $data['pix_qr'] = true;
        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro3J';
        $this->children[] = new $class($data);
    }

    /**
     * Concessionárias / tributos com código de barras (forma 13) — Segmento O.
     *
     * @see Registro3O
     * @see SUS-4127 / SUS-4230
     */
    public function inserirConcessionaria($data) {
        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro3O';
        $this->children[] = new $class($data);
    }

    /**
     * Valor a somar no trailer (pos. 024-041 — TOTAL VALOR PAGTOS).
     *
     * TED/PIX chave (A): `valor` · Boleto/PIX QR (J): `valor_pagamento` · O: `valor_a_pagar`.
     * Sem isso o trailer sai 0,00 e o Santander rejeita: "VALOR CALCULADO DIFERENTE DO INFORMADO (0,00)".
     */
    private function valorPagamentoDetalhe($child): float {
        foreach (['valor_a_pagar', 'valor_pagamento', 'valor', 'vlr_pagamento', 'vlr_nominal', 'valor_titulo'] as $campo) {
            $raw = $child->getUnformated($campo);
            if ($raw !== null && $raw !== '' && $raw !== '0' && $raw !== 0 && $raw !== 0.0) {
                return (float) $raw;
            }
        }

        return 0.0;
    }

    public function getText() {
        $loteSalvo = RemessaAbstract::$loteCounter;
        RemessaAbstract::$loteCounter = (int) $this->data['codigo_lote'];

        $retorno = '';

        foreach ($this->meta as $key => $value) {
            $retorno .= $this->$key;
        }

        RemessaAbstract::$retorno[] = $retorno;

        if (!$this->children) {
            RemessaAbstract::$loteCounter = $loteSalvo;
            return;
        }

        $valorTotal = 0.0;

        foreach ($this->children as $child) {
            // Nota 17: soma só inclusão (000/001/002/003). Complementos (J-52) não são children do lote.
            $tipoMovimento = (string) ($child->getUnformated('tipo_movimento') ?? '000');
            if (in_array($tipoMovimento, ['000', '001', '002', '003'], true)) {
                $valorTotal += $this->valorPagamentoDetalhe($child);
            }
            $child->getText();
        }

        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro5';
        $registro5 = new $class([
            'codigo_lote'   => $this->data['codigo_lote'],
            'qtd_registros' => $this->counter + 2,
            'total_valor'   => $valorTotal,
        ]);
        $registro5->getText();

        RemessaAbstract::$loteCounter = $loteSalvo;
    }

}
