<?php

namespace PagForPHP\resources\generico\retorno\L080;

use PagForPHP\RegistroRetAbstract;

class Generico0 extends RegistroRetAbstract {

    public function getRegistros($lote = 1) {
        return $this->children[$lote - 1]->getChilds();
    }

}
