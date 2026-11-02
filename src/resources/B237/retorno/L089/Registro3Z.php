<?php

namespace PagForPHP\resources\B237\retorno\L089;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L089\Generico3;

/**
 * Retorno Multipag Bradesco 237 layout 089 — segmento Z.
 * Autenticação 64 (015–078) pode vir vazia fora do PIX. Protocolo 25 fica em 079–103.
 */
class Registro3Z extends Generico3
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
            'default' => 'Z',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 015–078
        'autenticacao_pagamento' => array(
            'tamanho' => 64,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 079–103
        'protocolo_pagamento' => array(
            'tamanho' => 25,
            'default' => '',
            'tipo' => 'alfa',
            'required' => true
        ),
        // 104–230
        'filler1' => array(
            'tamanho' => 127,
            'default' => ' ',
            'tipo' => 'alfa',
            'required' => false
        ),
        // 231–240
        'codigo_ocorrencia' => array(
            'tamanho' => 10,
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
        RetornoAbstract::$linesCounter++;
    }

    public function get_arrayOcorrencias()
    {
        return CodigosOcorrencia::getRelacao($this->codigo_ocorrencia);
    }
}
