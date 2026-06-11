<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico1;

/**
 * SISPAG Itaú — Registro Header de Lote.
 *
 * versao_layout: 040 (TED/transferência) ou 030 (boleto).
 *
 * @see sispag_cnab_itau_B341.txt — REGISTRO HEADER DE LOTE
 */
class Registro1 extends Generico1 {

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
            'default' => '040',
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
        'identificacao_lancamento' => [
            'tamanho' => 4,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 16,
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

    protected function set_identificacao_lancamento($value) {
        if ($value !== '' && $value !== null) {
            $this->data['identificacao_lancamento'] = $value;
            return;
        }

        $codigoEmpresa = RemessaAbstract::$entryData['codigo_empresa_banco']
            ?? RemessaAbstract::$entryData['codigo_beneficiario']
            ?? '';

        $this->data['identificacao_lancamento'] = substr((string) $codigoEmpresa, 0, 4);
    }

    public function inserirBoleto($data) {
        $class = 'PagForPHP\resources\\B' . RemessaAbstract::$banco . '\remessa\\' . RemessaAbstract::$layout . '\Registro3J';
        $this->children[] = new $class($data);
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
            $valor = $child->getUnformated('valor')
                ?? $child->getUnformated('vlr_pagamento')
                ?? $child->getUnformated('vlr_nominal')
                ?? 0;
            $valorTotal += (float) $valor;
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
