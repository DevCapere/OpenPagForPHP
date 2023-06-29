<?php
namespace PagForPHP\Tests;

use PagForPHP\Especie;
use PHPUnit\Framework\TestCase;

/**
 * Especie Test Case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class EspecieTest extends TestCase
{
    /**
     * The Especie Object
     * 
     * @var Especie
     */
    private $especie;

    /**
     * Setup
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->especie = new Especie(104);
    }

    /**
     * Shutdown
     */
    public function tearDown()
    {
        $this->especie = null;
        
        parent::tearDown();
    }

    /**
     * @test
     * @covers \PagForPHP\Especie::__construct
     * @covers \PagForPHP\Especie::getAbr
     */
    public function getAbr()
    {
        $this->markTestIncomplete();

        $abr = $this->especie->getAbr('DM');
        
        $this->assertNotEmpty($abr);
    }

    /**
     * @test
     * @covers \PagForPHP\Especie::__construct
     * @covers \PagForPHP\Especie::getBanco
     */
    public function getBancoReturnBancoAttribute()
    {
        $banco = $this->especie->getBanco();

        $this->assertNotEmpty($banco);
    }

    /**
     * @test
     * @covers \PagForPHP\Especie::__construct
     * @covers \PagForPHP\Especie::getCodigo
     */
    public function getCodigoReturnNotEmptyWithValidAbr()
    {
        $abr = 'DM';
        $codigo = $this->especie->getCodigo($abr);
        
        $this->assertNotEmpty($codigo);
    }

    /**
     * @test
     * @covers \PagForPHP\Especie::__construct
     * @covers \PagForPHP\Especie::getCodigo
     */
    public function getCodigoReturnNullWithInvalidAbr()
    {
        $abr = 'FOO';
        $codigo = $this->especie->getCodigo($abr);
        
        $this->assertNull($codigo);
    }


}