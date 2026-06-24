<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;

/**
 * SISPAG Itaú — Retorno: Segmento A (TED / transferência).
 */
class Registro3A extends AbstractDetalhe {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '3', 'tipo' => 'int', 'required' => true],
        'numero_registro' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_segmento' => ['tamanho' => 1, 'default' => 'A', 'tipo' => 'alfa', 'required' => true],
        'tipo_movimento' => ['tamanho' => 3, 'default' => '000', 'tipo' => 'int', 'required' => true],
        'codigo_camara' => ['tamanho' => 3, 'default' => '018', 'tipo' => 'int', 'required' => true],
        'codigo_banco_favorecido' => ['tamanho' => 3, 'default' => '', 'tipo' => 'int', 'required' => true],
        'agencia_conta_favorecido' => ['tamanho' => 20, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'nome_favorecido' => ['tamanho' => 30, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'seu_numero' => ['tamanho' => 20, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'data_pagamento' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'tipo_moeda' => ['tamanho' => 3, 'default' => 'REA', 'tipo' => 'alfa', 'required' => true],
        'codigo_ispb' => ['tamanho' => 8, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'identificacao_transferencia' => ['tamanho' => 2, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'zeros1' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'valor' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'nosso_numero' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler1' => ['tamanho' => 5, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'data_efetiva' => ['tamanho' => 8, 'default' => '0', 'tipo' => 'date', 'required' => true],
        'valor_efetivo' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'finalidade_detalhe' => ['tamanho' => 20, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'numero_documento' => ['tamanho' => 6, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'numero_inscricao_favorecido' => ['tamanho' => 14, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'finalidade_doc' => ['tamanho' => 2, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'finalidade_ted' => ['tamanho' => 5, 'default' => '00010', 'tipo' => 'alfa', 'required' => true],
        'filler2' => ['tamanho' => 5, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'aviso_favorecido' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        $this->inserirSegmentoB();
    }

    private function inserirSegmentoB(): void {
        if (
            isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter])
            && substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 13, 1) === 'B'
        ) {
            $ns = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout;
            $this->children[] = new ($ns . '\\Registro3B')(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
        }
    }

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

    public function set_data_efetiva($value): void {
        $digits = preg_replace('/\D/', '', (string) $value);
        if ($digits === '' || preg_match('/^0+$/', $digits)) {
            $this->data['data_efetiva'] = '';
            return;
        }

        $data = \DateTime::createFromFormat('dmY', sprintf('%08d', $digits));
        $this->data['data_efetiva'] = $data ? $data->format('Y-m-d') : '';
    }

}
