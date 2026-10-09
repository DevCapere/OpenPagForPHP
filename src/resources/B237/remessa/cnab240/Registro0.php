<?php

namespace PagForPHP\resources\B237\remessa\cnab240;

use PagForPHP\RemessaAbstract;
use PagForPHP\resources\generico\remessa\cnab240\Generico0;

/**
 * Multipag Bradesco — Header de Arquivo (layout 089).
 *
 * Pos. 009-017 brancos · 033-052 convênio X(20) · 158-163 NSA · 164-166 versão 089.
 */
class Registro0 extends Generico0 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '237',
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
            'tamanho' => 13,
            'default' => '',
            'tipo' => 'int',
            'required' => true,
        ],
        'dac' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
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
            'default' => 'BANCO BRADESCO SA',
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
            'default' => '089',
            'tipo' => 'int',
            'required' => true,
        ],
        // 167-171. Multipag rejeita zeros: 01600 ou 06250.
        'densidade_gravacao' => [
            'tamanho' => 5,
            'default' => '01600',
            'tipo' => 'int',
            'required' => true,
        ],
        // 172-174. Manual Multipag (jan/2022): literal PIX em caixa alta. Sem isso a forma 45 não é reconhecida.
        'identificacao_remessa_pix' => [
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'uso_reservado_banco' => [
            'tamanho' => 17,
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

    /**
     * Bradesco PagFor: pos. 059-070 = conta com 12 dígitos; pos. 071 = dígito.
     * Conta que já chega com 13 dígitos não perde o último e não ganha outro dígito.
     */
    protected function set_conta($value) {
        $fonte = array_merge(RemessaAbstract::$entryData ?? [], $this->entryData ?? []);
        $contaInformada = $value !== '' && $value !== null ? $value : ($fonte['conta'] ?? '');
        $conta = preg_replace('/\D/', '', (string) $contaInformada) ?? '';

        if (strlen($conta) >= 13) {
            $this->data['conta'] = substr($conta, -13);
            return;
        }

        $dv = preg_replace('/\D/', '', (string) ($fonte['conta_dv'] ?? '')) ?? '';
        $dv = $dv !== '' ? substr($dv, -1) : '';

        if ($dv === '') {
            $this->data['conta'] = substr(str_pad($conta, 13, '0', STR_PAD_LEFT), -13);
            return;
        }

        $this->data['conta'] = str_pad($conta, 12, '0', STR_PAD_LEFT) . $dv;
    }

    /**
     * Bradesco PagFor: a posição 072 fica em branco. O dígito da conta fica na 071.
     */
    protected function set_dac($value) {
        $this->data['dac'] = ' ';
    }

    protected function set_hora_geracao($value) {
        $this->data['hora_geracao'] = $value !== '' ? $value : date('His');
    }

    /** Convênio Multipag — pos. 033-052, X(20) (sem formato G009 Santander). */
    protected function set_codigo_convenio($value) {
        $fonte = array_merge(RemessaAbstract::$entryData ?? [], $this->entryData ?? []);
        $informado = trim((string) ($value ?? ''));
        $raw = $informado !== ''
            ? $informado
            : ($fonte['codigo_convenio'] ?? $fonte['codigo_empresa_banco'] ?? '');
        $convenio = preg_replace('/\s+/', '', (string) $raw) ?? '';
        if ($convenio === '') {
            $this->data['codigo_convenio'] = str_repeat(' ', 20);
            return;
        }
        $this->data['codigo_convenio'] = str_pad(substr($convenio, 0, 20), 20, ' ', STR_PAD_RIGHT);
    }

    public function getText() {
        $this->data['identificacao_remessa_pix'] = $this->arquivoEhPix() ? 'PIX' : ' ';

        parent::getText();
    }

    /**
     * PIX Multipag vai em arquivo separado (formas 45 e 47).
     * A literal do header só entra nesse arquivo.
     */
    private function arquivoEhPix(): bool {
        foreach ($this->children ?? [] as $lote) {
            $forma = preg_replace('/\D/', '', (string) ($lote->getUnformated('forma_pagamento') ?? '')) ?? '';
            $forma = str_pad($forma, 2, '0', STR_PAD_LEFT);
            if ($forma === '45' || $forma === '47') {
                return true;
            }
        }

        return false;
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
