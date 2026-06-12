<?php

namespace PagForPHP\resources\B341\retorno\L080;

/**
 * SISPAG Itaú — Retorno: Segmento B (complemento favorecido).
 */
class Registro3B extends AbstractDetalhe {

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '3', 'tipo' => 'int', 'required' => true],
        'numero_registro' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'codigo_segmento' => ['tamanho' => 1, 'default' => 'B', 'tipo' => 'alfa', 'required' => true],
        'filler1' => ['tamanho' => 3, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'tipo_inscricao_favorecido' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'numero_inscricao_favorecido' => ['tamanho' => 14, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'endereco' => ['tamanho' => 30, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'numero_endereco' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'complemento_endereco' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'bairro' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'cidade' => ['tamanho' => 20, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'cep' => ['tamanho' => 8, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'estado' => ['tamanho' => 2, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'email' => ['tamanho' => 100, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler2' => ['tamanho' => 3, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

}
