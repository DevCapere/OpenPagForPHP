<?php

namespace PagForPHP\resources\B341\retorno\L080;

/**
 * SISPAG Itaú — Retorno: Segmento O (concessionárias / tributos com código de barras).
 *
 * Forma **13** / **91** · layout lote tipicamente **080** no retorno.
 * Campo código de barras = X(48) (óptico 44 + padding).
 *
 * @see remessa Registro3O (SUS-4127)
 * @see SUS-4258
 */
class Registro3O extends AbstractDetalhe {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '3', 'tipo' => 'int', 'required' => true],
        'numero_registro' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_segmento' => ['tamanho' => 1, 'default' => 'O', 'tipo' => 'alfa', 'required' => true],
        'tipo_movimento' => ['tamanho' => 3, 'default' => '000', 'tipo' => 'int', 'required' => true],
        // Pos. 018-065 — Nota 18: X(48) arrecadação / concessionária
        'codigo_barras' => ['tamanho' => 48, 'default' => ' ', 'tipo' => 'alfa2', 'required' => true],
        'nome_concessionaria' => ['tamanho' => 30, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'data_vencimento' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'codigo_moeda' => ['tamanho' => 3, 'default' => 'REA', 'tipo' => 'alfa', 'required' => true],
        'quantidade_moeda' => ['tamanho' => 7, 'default' => '0', 'tipo' => 'decimal', 'precision' => 8, 'required' => true],
        'valor_a_pagar' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'data_pagamento' => ['tamanho' => 8, 'default' => '', 'tipo' => 'date', 'required' => true],
        'valor_pago' => ['tamanho' => 13, 'default' => '0', 'tipo' => 'decimal', 'precision' => 2, 'required' => true],
        'filler1' => ['tamanho' => 3, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'nota_fiscal' => ['tamanho' => 9, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'filler2' => ['tamanho' => 3, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'seu_numero' => ['tamanho' => 20, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler3' => ['tamanho' => 21, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'nosso_numero' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

}
