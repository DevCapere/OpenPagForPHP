<?php

namespace PagForPHP\resources\B341\remessa\cnab240;

use Exception;
use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * SISPAG Itaú — Segmento O (concessionárias / tributos com código de barras).
 *
 * Forma de pagamento **13** · layout lote **030**. Campo código de barras = X(48)
 * = óptico FEBRABAN 44 + 4 espaços (linha 48 é convertida para óptico).
 *
 * @see sispag_cnab_ITAU.txt — SEGMENTO O – OBRIGATÓRIO / Anexo B
 * @see SUS-4127 / SUS-4230
 */
class Registro3O extends Generico3 {

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
            'default' => 'O',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_movimento' => [
            'tamanho' => 3,
            'default' => '000',
            'tipo' => 'int',
            'required' => true,
        ],
        // Pos. 018-065 — Nota 18: X(48) arrecadação / concessionária
        'codigo_barras' => [
            'tamanho' => 48,
            'default' => ' ',
            'tipo' => 'alfa2',
            'required' => true,
        ],
        'nome_concessionaria' => [
            'tamanho' => 30,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'data_vencimento' => [
            'tamanho' => 8,
            'default' => '',
            'tipo' => 'date',
            'required' => true,
        ],
        'codigo_moeda' => [
            'tamanho' => 3,
            'default' => 'REA',
            'tipo' => 'alfa',
            'required' => true,
        ],
        // 9(07)V9(08) — Real: zeros (Nota 19); valor vai em valor_a_pagar
        'quantidade_moeda' => [
            'tamanho' => 7,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 8,
            'required' => true,
        ],
        'valor_a_pagar' => [
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
        // Retorno: valor pago. Remessa: zeros.
        'valor_pago' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'nota_fiscal' => [
            'tamanho' => 9,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'seu_numero' => [
            'tamanho' => 20,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler3' => [
            'tamanho' => 21,
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

    protected function set_codigo_barras($value) {
        $raw = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['codigo_barras']
                ?? $this->entryData['linha_digitavel']
                ?? '');

        $this->data['codigo_barras'] = self::normalizarCodigoBarrasArrecadacao((string) $raw);
    }

    protected function set_nome_concessionaria($value) {
        $this->data['nome_concessionaria'] = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['nome_concessionaria']
                ?? $this->entryData['nome_favorecido']
                ?? $this->entryData['nome_contribuinte']
                ?? ' ');
    }

    protected function set_data_vencimento($value) {
        $this->data['data_vencimento'] = ($value !== '' && $value !== null)
            ? $value
            : ($this->entryData['data_vencimento']
                ?? $this->entryData['data_pagamento']
                ?? date('Y-m-d'));
    }

    protected function set_data_pagamento($value) {
        $this->data['data_pagamento'] = ($value !== '' && $value !== null)
            ? $value
            : ($this->entryData['data_pagamento'] ?? date('Y-m-d'));
    }

    protected function set_valor_a_pagar($value) {
        if ($value !== '' && $value !== null && $value !== '0') {
            $this->data['valor_a_pagar'] = $value;
            return;
        }

        $this->data['valor_a_pagar'] = $this->entryData['valor_a_pagar']
            ?? $this->entryData['valor_pagamento']
            ?? $this->entryData['valor']
            ?? '0';
    }

    protected function set_seu_numero($value) {
        $this->data['seu_numero'] = $value !== '' && $value !== ' '
            ? $value
            : ($this->entryData['documento_id'] ?? $this->entryData['seu_numero'] ?? ' ');
    }

    /**
     * Campo X(48) do Segmento O: óptico FEBRABAN 44 + 4 espaços.
     *
     * Se receber linha digitável 48, converte para óptico (remove DV de cada bloco de 12).
     * Motivo: Itaú Anexo B consistência a representação numérica com módulo 10 nos campos;
     * FEBRABAN id valor 8/9 usa módulo 11 — linha “válida” no padrão nacional é rejeitada
     * como COD.BAR. INVALIDO no SisPag. O óptico só exige DV geral (mod 10/11 conforme id).
     *
     * @throws Exception se vazio ou comprimento inválido
     */
    public static function normalizarCodigoBarrasArrecadacao(string $valor): string {
        $digits = preg_replace('/\D/', '', $valor) ?? '';
        $len = strlen($digits);

        if ($len === 48) {
            $optico = '';
            for ($i = 0; $i < 48; $i += 12) {
                $optico .= substr($digits, $i, 11);
            }

            return $optico . str_repeat(' ', 4);
        }

        if ($len === 44) {
            return $digits . str_repeat(' ', 4);
        }

        if ($digits === '') {
            throw new Exception('Segmento O exige codigo_barras ou linha_digitavel (arrecadação).');
        }

        throw new Exception(
            'Segmento O: codigo_barras/linha_digitavel deve ter 44 ou 48 dígitos (recebido ' . $len . ').'
        );
    }

}
