<?php
namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PagForPHP\Retorno;
use PHPUnit\Framework\TestCase;

/**
 * Retorno Test Case (API genérica via fixture B341 SISPAG).
 */
class RetornoTest extends TestCase
{
    /**
     * @var Retorno
     */
    private $retorno;

    private function buildRetornoFixture(): string
    {
        $remessa = new Remessa('341', 'cnab240', [
            'nome_empresa'              => 'ATLANTICA CAP',
            'tipo_inscricao'            => 2,
            'numero_inscricao'          => '12345678000199',
            'agencia'                   => '01234',
            'agencia_dv'                => ' ',
            'conta'                     => '000000987654',
            'conta_dv'                  => '1',
            'codigo_empresa_banco'      => '123456',
            'numero_sequencial_arquivo' => 42,
        ]);

        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '040',
        ]);

        $lote->inserirTransferencia([
            'banco_favorecido'     => '237',
            'agencia_favorecido'   => '0237',
            'conta_favorecido'     => '554433',
            'conta_dv_favorecido'  => '1',
            'nome_favorecido'      => 'FORNECEDOR TESTE LTDA',
            'documento_favorecido' => '98765432000111',
            'documento_id'         => 'DOC-001',
            'data_pagamento'       => '2026-06-15',
            'valor'                => 1500.55,
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $linhas[0] = substr_replace($linhas[0], '2', 142, 1);

        return implode("\r\n", $linhas) . "\r\n";
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->retorno = new Retorno($this->buildRetornoFixture());
    }

    public function tearDown(): void
    {
        $this->retorno = null;

        parent::tearDown();
    }

    public function testGetRegistrosRaizMustBeReturnArray(): void
    {
        $registro = $this->retorno->getRegistrosRaiz();

        $this->assertNotEmpty($registro);
        $this->assertIsArray($registro);
    }

    public function testGetRegistros(): void
    {
        $registros = $this->retorno->getRegistros(1);

        $this->assertNotNull($registros);
        $this->assertNotEmpty($registros);
    }

    public function testGetChilds(): void
    {
        $registros = $this->retorno->getChilds();

        $this->assertNotNull($registros);
        $this->assertNotEmpty($registros);
    }

    public function testGetChild(): void
    {
        $registros = $this->retorno->getChild();

        $this->assertNotNull($registros);
    }

    public function testGetLayoutMustBeReturnString(): void
    {
        $layout = $this->retorno->getLayout();

        $this->assertNotEmpty($layout);
    }

}
