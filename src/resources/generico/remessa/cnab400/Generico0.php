<?php
namespace PagForPHP\resources\generico\remessa\cnab400;
use PagForPHP\RegistroRemAbstract;
use PagForPHP\RemessaAbstract;
use Exception;

class Generico0 extends RegistroRemAbstract
{
    protected $counter = 1;
    public function get_counter(){
        $this->counter++;
        return $this->counter;
    }
    
    public function inserirDetalhe($data)
    {
        $class = 'PagForPHP\resources\\B'.RemessaAbstract::$banco.'\remessa\\'.RemessaAbstract::$layout.'\Registro1';
        $this->children[] = new $class($data);
    }
    
    protected function set_data_gravacao($value)
    {
        $this->data['data_gravacao'] = date('Y-m-d');
    }
    protected function set_numero_inscricao($value)
    {
        $this->data['numero_inscricao'] = str_ireplace(array('.','/','-'),array(''), $value);

    }


}
