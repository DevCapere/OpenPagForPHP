<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;

/**
 * SISPAG Itaú — Retorno: Segmento J (liquidação de boleto).
 */
class Registro3J extends AbstractDetalhe {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '3', 'tipo' => 'int', 'required' => true],
        'numero_registro' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_segmento' => ['tamanho' => 1, 'default' => 'J', 'tipo' => 'alfa', 'required' => true],
        'tipo_movimento' => ['tamanho' => 3, 'default' => '000', 'tipo' => 'int', 'required' => true],
        'codigo_barras_banco' => ['tamanho' => 3, 'default' => '', 'tipo' => 'int', 'required' => true],
        'codigo_barras_moeda' => ['tamanho' => 1, 'default' => '9', 'tipo' => 'int', 'required' => true],
        'codigo_barras_dv' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_barras_vencimento' => ['tamanho' => 4, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_barras_valor' => ['tamanho' => 10, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_barras_campo_livre' => ['tamanho' => 25, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_favorecido' => ['tamanho' => 30, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'data_vencimento' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'valor_titulo' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'descontos' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'acrescimos' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'data_pagamento' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'valor_pagamento' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'zeros1' => ['tamanho' => 15, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'seu_numero' => ['tamanho' => 20, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'filler1' => ['tamanho' => 13, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'nosso_numero' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        $this->inserirSegmentoJ52();
    }

    private function inserirSegmentoJ52(): void {
        if (
            isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter])
            && substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 13, 1) === 'J'
            && substr(RetornoAbstract::$lines[RetornoAbstract::$linesCounter], 17, 2) === '52'
        ) {
            $ns = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout;
            $this->children[] = new ($ns . '\\Registro3J52')(RetornoAbstract::$lines[RetornoAbstract::$linesCounter]);
        }
    }

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

}
