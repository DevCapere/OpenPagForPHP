<?php

/*
 * PagForPHP - Geração de arquivos de remessa e retorno em PHP
 *
 * LICENSE: The MIT License (MIT)
 *
 * Copyright (C) 2013 Ciatec.net
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify,
 * merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace PagForPHP;

use PagForPHP\RegistroAbstract;
use Exception;

abstract class RegistroRemAbstract extends RegistroAbstract {

    protected $entryData;

    /**
     * Método __construct()
     * instancia registro qualquer
     * @$data = array de dados para o registro
     */
    public function __construct($data = NULL) {
        if ($data) { // se o ID for informado
            // carrega o objeto correspondente
            $this->entryData = $data;
            foreach ($this->meta as $key => $value) {
                $this->$key = (isset($data[$key])) ? $data[$key] : $this->meta[$key]['default'];
            }
        }
    }

    /**
     * Método __set()
     * executado sempre que uma propriedade for atribu?da.
     */
    public function __set($prop, $value) {
        // verifica se existe Método set_<propriedade>
        if (method_exists($this, 'set_' . $prop)) {
            // executa o Método set_<propriedade>
            call_user_func(array($this, 'set_' . $prop), $value);
        } else {
            $metaData = (isset($this->meta[$prop])) ? $this->meta[$prop] : null;
            if (($value == "" || $value === NULL) && $metaData['default'] != "") {
                $this->data[$prop] = $metaData['default'];
            } else {
                // SUS-4117: campos int/digitos longos devem permanecer string (não float).
                $tipo = $metaData['tipo'] ?? null;
                if (($tipo === 'int' || $tipo === 'digitos') && is_string($value)) {
                    $this->data[$prop] = preg_replace('/\D/', '', $value);
                } elseif (($tipo === 'int' || $tipo === 'digitos') && (is_int($value) || is_float($value))) {
                    // Contadores/códigos curtos: int ok; float longo já é perda — cast string sem number_format
                    $this->data[$prop] = is_int($value)
                        ? (string) $value
                        : preg_replace('/\D/', '', (string) $value);
                } else {
                    $this->data[$prop] = $value;
                }
            }
        }
    }

    /**
     * Método __get()
     * executado sempre que uma propriedade for requerida
     */
    public function __get($prop) {
        // verifica se existe Método get_<propriedade>
        if (method_exists($this, 'get_' . $prop)) {
            // executa o Método get_<propriedade>
            return call_user_func(array($this, 'get_' . $prop));
        } else {
            return $this->___get($prop);
        }
    }

    /**
     * Método ___get()
     * metodo auxiliar para ser chamado para dentro de metodo get personalizado
     */
    public function ___get($prop) {
        // retorna o valor da propriedade
        if (isset($this->meta[$prop])) {
            $metaData = (isset($this->meta[$prop])) ? $this->meta[$prop] : null;
            $this->data[$prop] = !isset($this->data[$prop]) || $this->data[$prop] == '' ? $metaData['default'] : $this->data[$prop];
            if ($metaData['required'] == true && ($this->data[$prop] == '' || !isset($this->data[$prop]))) {
                if (isset($this->data['nosso_numero'])) {
                    throw new Exception('Campo faltante ou com valor nulo:' . $prop . " Boleto Numero:" . $this->data['nosso_numero']);
                } else {
                    throw new Exception('Campo faltante ou com valor nulo:' . $prop);
                }
            }
            // set_error_handler(function ($severity, $message, $file, $line,$errcontext) {
            //     throw new \ErrorException(json_encode($errcontext)."->".$message, $severity, $severity, $file, $line);
            // });

            switch ($metaData['tipo']) {
                case 'decimal':
                    $retorno = (($this->data[$prop] && trim($this->data[$prop]) !== "" ? number_format($this->data[$prop], $metaData['precision'], '', '') : (isset($metaData['default']) ? $metaData['default'] : '')));
                    return str_pad($retorno, $metaData['tamanho'] + $metaData['precision'], '0', STR_PAD_LEFT);
                case 'int':
                case 'digitos':
                    // Digitos longos (ex.: campo livre 25 do boleto) NÃO podem passar por
                    // number_format()/float — IEEE-754 corrompe a partir de ~15 dígitos (SUS-4117).
                    if (isset($this->data[$prop]) && trim((string) $this->data[$prop]) !== '') {
                        $value = $this->data[$prop];
                        if (is_float($value)) {
                            // Já tipado float = dados já perdidos; evitar number_format (mesma falha).
                            $retorno = preg_replace('/\D/', '', sprintf('%.0F', $value));
                        } else {
                            $retorno = preg_replace('/\D/', '', (string) $value);
                        }
                    } else {
                        $retorno = isset($metaData['default']) ? preg_replace('/\D/', '', (string) $metaData['default']) : '';
                    }
                    if ($retorno === '') {
                        $retorno = '0';
                    }
                    return str_pad($retorno, $metaData['tamanho'], '0', STR_PAD_LEFT);
                case 'alfa':
                    $retorno = (isset($this->data[$prop])) ? $this->prepareText($this->data[$prop]) : '';
                    return $this->mb_str_pad(mb_substr($retorno, 0, $metaData['tamanho'], "UTF-8"), $metaData['tamanho'], ' ', STR_PAD_RIGHT);
                case 'alfa2':
                    $retorno = (isset($this->data[$prop])) ? $this->data[$prop] : '';
                    return $this->mb_str_pad(mb_substr($retorno, 0, $metaData['tamanho'], "UTF-8"), $metaData['tamanho'], ' ', STR_PAD_RIGHT);
                case $metaData['tipo'] == 'date' && $metaData['tamanho'] == 6:
                    $retorno = ($this->data[$prop]) ? date("dmy", strtotime($this->data[$prop])) : '';
                    return str_pad($retorno, $metaData['tamanho'], '0', STR_PAD_LEFT);
                case $metaData['tipo'] == 'date' && $metaData['tamanho'] == 8:
                    $retorno = ($this->data[$prop]) ? date("dmY", strtotime($this->data[$prop])) : '';
                    return str_pad($retorno, $metaData['tamanho'], '0', STR_PAD_LEFT);
                case $metaData['tipo'] == 'dateReverse':
                    $retorno = ($this->data[$prop]) ? date("Ymd", strtotime($this->data[$prop])) : '';
                    return str_pad($retorno, $metaData['tamanho'], '0', STR_PAD_LEFT);
                default:
                    return null;
            }
            restore_error_handler();
        }
    }

    public function getFileName() {
        return 'R' . RemessaAbstract::$banco . str_pad($this->entryData['numero_sequencial_arquivo'], 4, '0', STR_PAD_LEFT) . '.rem';
    }

}
