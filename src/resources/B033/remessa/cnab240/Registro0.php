<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico0;

/**
 * SISPAG Santander — Header de Arquivo (manual PagFor V11.7).
 *
 * Pos. 009-017 brancos · 033-052 convênio (G009) · 158-163 NSA · 164-166 versão 060.
 *
 * @see pagamento-fornecedores-layout-CNAB-240.pdf — 3.1 HEADER DE ARQUIVO
 */
class Registro0 extends Generico0 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '033',
            'tipo' => 'int',
            'required' => true,
        ],
        'codigo_lote' => [
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'tipo_registro' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 9,
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
        // G009: BBBB(033) + AAAA(agência) + CCCCCCCCCCCC(convênio)
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
        'nome_banco' => [
            'tamanho' => 30,
            'default' => 'BANCO SANTANDER SA',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler5' => [
            'tamanho' => 10,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'codigo_remessa' => [
            'tamanho' => 1,
            'default' => '1',
            'tipo' => 'int',
            'required' => true,
        ],
        'data_geracao' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'hora_geracao' => [
            'tamanho' => 6,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_sequencial_arquivo' => [
            'tamanho' => 6,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'versao_layout' => [
            'tamanho' => 3,
            'default' => '060',
            'tipo' => 'int',
            'required' => true,
        ],
        'densidade_gravacao' => [
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'uso_reservado_banco' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'uso_reservado_empresa' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler6' => [
            'tamanho' => 19,
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

    protected function set_hora_geracao($value) {
        $this->data['hora_geracao'] = $value !== '' ? $value : date('His');
    }

    /**
     * G009 — Código do Convênio (pos. 033-052, X(020)):
     * BBBBAAAA + CCCCCCCCCCCC
     * BBBB = banco "033" (4 pos., literal do manual → "033 ")
     * AAAA = agência sem DV (4)
     * C…C = nº convênio à direita com zeros à esquerda (12)
     */
    protected function set_codigo_convenio($value) {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            $this->data['codigo_convenio'] = $value;
            return;
        }

        $convenio = preg_replace('/\D/', '', (string) ($this->entryData['codigo_empresa_banco'] ?? ''));
        $agencia = preg_replace('/\D/', '', (string) ($this->entryData['agencia'] ?? '0'));
        $agencia4 = substr(str_pad($agencia !== '' ? $agencia : '0', 4, '0', STR_PAD_LEFT), -4);
        $convenio12 = str_pad($convenio !== '' ? $convenio : '0', 12, '0', STR_PAD_LEFT);

        $this->data['codigo_convenio'] = str_pad('033', 4, ' ', STR_PAD_RIGHT) . $agencia4 . $convenio12;
    }

    protected function set_numero_sequencial_arquivo($value) {
        if ($value !== '' && $value !== null && $value !== '0' && $value !== 0) {
            $this->data['numero_sequencial_arquivo'] = $value;
            return;
        }

        $this->data['numero_sequencial_arquivo'] = $this->entryData['numero_sequencial_arquivo']
            ?? $this->meta['numero_sequencial_arquivo']['default'];
    }

}
