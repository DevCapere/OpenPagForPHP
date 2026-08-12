<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L080\Generico1;

/**
 * SISPAG Itaú — Retorno: Header de Lote.
 */
class Registro1 extends Generico1 {

    public $trailler;

    protected $meta = [
        'codigo_banco' => ['tamanho' => 3, 'default' => '341', 'tipo' => 'int', 'required' => true],
        'codigo_lote' => ['tamanho' => 4, 'default' => 1, 'tipo' => 'int', 'required' => true],
        'tipo_registro' => ['tamanho' => 1, 'default' => '1', 'tipo' => 'int', 'required' => true],
        'operacao' => ['tamanho' => 1, 'default' => 'C', 'tipo' => 'alfa', 'required' => true],
        'tipo_pagamento' => ['tamanho' => 2, 'default' => '20', 'tipo' => 'int', 'required' => true],
        'forma_pagamento' => ['tamanho' => 2, 'default' => '41', 'tipo' => 'int', 'required' => true],
        'versao_layout' => ['tamanho' => 3, 'default' => '040', 'tipo' => 'int', 'required' => true],
        'filler1' => ['tamanho' => 1, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'tipo_inscricao' => ['tamanho' => 1, 'default' => '', 'tipo' => 'int', 'required' => true],
        'numero_inscricao' => ['tamanho' => 14, 'default' => '', 'tipo' => 'int', 'required' => true],
        'identificacao_lancamento' => ['tamanho' => 4, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler2' => ['tamanho' => 16, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'agencia' => ['tamanho' => 5, 'default' => '', 'tipo' => 'int', 'required' => true],
        'filler3' => ['tamanho' => 1, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'conta' => ['tamanho' => 12, 'default' => '', 'tipo' => 'int', 'required' => true],
        'filler4' => ['tamanho' => 1, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'dac' => ['tamanho' => 1, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'nome_empresa' => ['tamanho' => 30, 'default' => '', 'tipo' => 'alfa', 'required' => true],
        'finalidade_lote' => ['tamanho' => 30, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'historico_cc' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'endereco_empresa' => ['tamanho' => 30, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'numero_endereco' => ['tamanho' => 5, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'complemento_endereco' => ['tamanho' => 15, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'cidade' => ['tamanho' => 20, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'cep' => ['tamanho' => 8, 'default' => '0', 'tipo' => 'int', 'required' => true],
        'estado' => ['tamanho' => 2, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'filler5' => ['tamanho' => 8, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
        'ocorrencias' => ['tamanho' => 10, 'default' => ' ', 'tipo' => 'alfa', 'required' => true],
    ];

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
        $this->inserirDetalhe();
        $this->inserirTrailerLote();
    }

    private function inserirDetalhe(): void {
        $ns = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout;

        while ($this->isLinhaDetalheDoLote()) {
            $linhaAtual = RetornoAbstract::$linesCounter;
            $linha = RetornoAbstract::$lines[$linhaAtual];

            if ($this->isSegmentoJ52($linha)) {
                $this->children[] = new ($ns . '\\Registro3J52')($linha);
            } elseif (substr($linha, 13, 1) === 'A') {
                $this->children[] = new ($ns . '\\Registro3A')($linha);
            } elseif (substr($linha, 13, 1) === 'B') {
                $this->children[] = new ($ns . '\\Registro3B')($linha);
            } elseif (substr($linha, 13, 1) === 'J') {
                $this->children[] = new ($ns . '\\Registro3J')($linha);
            } elseif (substr($linha, 13, 1) === 'O') {
                // SUS-4258 — UTILIDADES / arrecadação (forma 13/91)
                $this->children[] = new ($ns . '\\Registro3O')($linha);
            } else {
                RetornoAbstract::$linesCounter++;
            }

            if ($linhaAtual === RetornoAbstract::$linesCounter) {
                RetornoAbstract::$linesCounter++;
            }
        }
    }

    private function inserirTrailerLote(): void {
        $linha = RetornoAbstract::$lines[RetornoAbstract::$linesCounter] ?? '';
        if (strlen($linha) >= 8 && substr($linha, 7, 1) === '5') {
            $ns = 'PagForPHP\resources\\B' . RetornoAbstract::$banco . '\retorno\\' . RetornoAbstract::$layout;
            $this->trailler = new ($ns . '\\Registro5')($linha);
        }
    }

    private function isLinhaDetalheDoLote(): bool {
        if (!isset(RetornoAbstract::$lines[RetornoAbstract::$linesCounter])) {
            return false;
        }

        $linha = RetornoAbstract::$lines[RetornoAbstract::$linesCounter];

        return (int) $this->data['codigo_lote'] === (int) substr($linha, 3, 4)
            && substr($linha, 7, 1) === '3';
    }

    private function isSegmentoJ52(string $linha): bool {
        return substr($linha, 13, 1) === 'J' && substr($linha, 17, 2) === '52';
    }

    public function get_arrayOcorrencias(): array {
        return CodigosOcorrencia::getRelacao($this->ocorrencias);
    }

}
