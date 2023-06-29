<?php
namespace PagForPHP\Tests;

use PagForPHP\Retorno;
use PHPUnit\Framework\TestCase;

/**
 * Retorno Test Case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class RetornoTest extends TestCase
{
    /**
     * The Retorno Object
     * 
     * @var Retorno
     */
    private $retorno;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $retorno = file_get_contents(__DIR__ . '/../samples/teste.ret');

        $this->retorno = new Retorno($retorno);
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->retorno = null;
        
        parent::tearDown();
    }

    

    /**
     * @test
     * @covers \PagForPHP\Retorno::__construct
     * @covers \PagForPHP\Retorno::getRegistrosRaiz
     */
    public function getRegistrosRaizMustBeReturnArray()
    {
        $registro = $this->retorno->getRegistrosRaiz();

        $this->assertNotEmpty($registro);
        $this->assertTrue(is_array($registro));
    }

    /**
     * @test
     * @covers \PagForPHP\Retorno::__construct
     * @covers \PagForPHP\Retorno::getRegistros
     */
    public function getRegistros()
    {
        $lote = 1;
        $registros = $this->retorno->getRegistros($lote);
        
        $this->assertNotNull($registros);
    }

    /**
     * @test
     * @covers \PagForPHP\Retorno::__construct
     * @covers \PagForPHP\Retorno::getChilds
     */
    public function getChilds()
    {
        $registros = $this->retorno->getChilds();
        
        $this->assertNotNull($registros);
    }

    /**
     * @test
     * @covers \PagForPHP\Retorno::__construct
     * @covers \PagForPHP\Retorno::getChild
     */
    public function getChild()
    {
        $registros = $this->retorno->getChild();
        
        $this->assertNotNull($registros);
    }

    /**
     * @test
     * @covers \PagForPHP\Retorno::__construct
     * @covers \PagForPHP\Retorno::getLayout
     */
    public function getLayoutMustBeReturnString()
    {
        $registros = $this->retorno->getLayout();
        
        $this->assertNotEmpty($registros);
        $this->assertTrue(is_string($registros));
    }
}