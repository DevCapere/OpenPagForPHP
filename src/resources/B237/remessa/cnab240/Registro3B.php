<?php

namespace PagForPHP\resources\B237\remessa\cnab240;

use PagForPHP\resources\generico\remessa\cnab240\Generico3;

/**
 * Segmento B de TED, crédito em conta, poupança, caixa e OP.
 *
 * Manual Pagamento a Fornecedores CNAB 240 V11.6, página 11.
 * Obrigatório para TED, caixa e OP. Opcional para crédito em conta e poupança.
 * Boleto e tributo sem código de barras usam as mesmas colunas (páginas 24 e 31).
 * PIX usa {@see Registro3BPix}.
 */
class Registro3B extends Generico3 {

    protected $meta = [
        'codigo_banco' => [
            'tamanho' => 3,
            'default' => '237',
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
            'default' => 'B',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'filler1' => [
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'tipo_inscricao_favorecido' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'numero_inscricao_favorecido' => [
            'tamanho' => 14,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'endereco' => [
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
        'bairro' => [
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
        'data_vencimento' => [
            'tamanho' => 8,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'vlr_documento' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'vlr_abatimento' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'vlr_desconto' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'vlr_mora' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'vlr_multa' => [
            'tamanho' => 13,
            'default' => '0',
            'tipo' => 'decimal',
            'precision' => 2,
            'required' => true,
        ],
        'hora_envio_ted' => [
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler2' => [
            'tamanho' => 11,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'codigo_historico' => [
            'tamanho' => 4,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'aviso' => [
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true,
        ],
        'filler3' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'ted_instituicao' => [
            'tamanho' => 1,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
        'identificacao_spb' => [
            'tamanho' => 8,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true,
        ],
    ];

    protected function set_tipo_inscricao_favorecido($value) {
        if ($value === 1 || $value === 2 || $value === '1' || $value === '2') {
            $this->data['tipo_inscricao_favorecido'] = (int) $value;
            return;
        }

        $documento = preg_replace('/\D/', '', (string) ($this->entryData['documento_favorecido'] ?? ''));
        $this->data['tipo_inscricao_favorecido'] = strlen($documento) > 11 ? 2 : 1;
    }

    protected function set_numero_inscricao_favorecido($value) {
        $documento = $value !== '' && $value !== '0'
            ? $value
            : ($this->entryData['documento_favorecido'] ?? '0');

        $this->data['numero_inscricao_favorecido'] = preg_replace('/\D/', '', (string) $documento);
    }

}
