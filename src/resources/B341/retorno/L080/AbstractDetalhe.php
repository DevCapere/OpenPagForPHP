<?php

namespace PagForPHP\resources\B341\retorno\L080;

use PagForPHP\RetornoAbstract;
use PagForPHP\resources\generico\retorno\L080\Generico3;

abstract class AbstractDetalhe extends Generico3 {

    public function __construct($linhaTxt) {
        parent::__construct($linhaTxt);
        RetornoAbstract::$linesCounter++;
    }

}
