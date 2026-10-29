<?php

namespace PagForPHP\resources\B237\retorno\L089;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L089\Generico3;

/**
 * Retorno Multipag Bradesco 237 — segmento B quando a câmara do A é 009.
 * A chave PIX de 99 fica em informacao_12. filler1 não ocupa posição.
 */
class Registro3BPix extends Generico3
{
    protected $meta = array(
        'codigo_banco' => array(
            'tamanho' => 3,
            'default' => '237',
            'tipo' => 'alfa',
            'required' => true
        ),
        'codigo_lote' => array(
            'tamanho' => 4,
            'default' => 1,
            'tipo' => 'int',
            'required' => true
        ),
        'tipo_registro' => array(
            'tamanho' => 1,
            'default' => '3',
            'tipo' => 'int',
            'required' => true
        ),
        'numero_registro' => array(
            'tamanho' => 5,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        'codigo_segmento' => array(
            'tamanho' => 1,
            'default' => 'B',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 015–017 — tipo de chave (03 = CPF/CNPJ)
        'forma_iniciacao' => array(
            'tamanho' => 3,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 018
        'tipo_documento_favorecido' => array(
            'tamanho' => 1,
            'default' => '0',
            'tipo' => 'int',
            'required' => true
        ),
        // 019–032
        'documento_favorecido' => array(
            'tamanho' => 14,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 033–067
        'informacao_10' => array(
            'tamanho' => 35,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 068–127
        'informacao_11' => array(
            'tamanho' => 60,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 128–226 — chave PIX
        'informacao_12' => array(
            'tamanho' => 99,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 227–232 — UG
        'filler2' => array(
            'tamanho' => 6,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 233–240 — ISPB
        'identificacao_spb' => array(
            'tamanho' => 8,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => true
        ),
    );

    public function __construct($data = null)
    {
        if (empty($this->data)) {
            parent::__construct($data);
        }
        $this->data['filler1'] = '';
        RetornoAbstract::$linesCounter++;
    }
}
