<?php

namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PagForPHP\Retorno;
use PHPUnit\Framework\TestCase;

class RetornoB237Test extends TestCase {

    private function headerData(): array {
        return [
            'nome_empresa'              => 'ATLANTICA CAP',
            'tipo_inscricao'            => 2,
            'numero_inscricao'          => '12345678000199',
            'agencia'                   => '01234',
            'agencia_dv'                => ' ',
            'conta'                     => '000000987654',
            'conta_dv'                  => '1',
            'codigo_empresa_banco'      => '12345678901234567890',
            'numero_sequencial_arquivo' => 42,
        ];
    }

    private function remessaTedParaRetorno(string $ocorrenciaSegmentoA = '00        '): string {
        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '045',
        ]);
        $lote->inserirTransferencia([
            'banco_favorecido'     => '001',
            'agencia_favorecido'   => '1234',
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
        $linhas[2] = substr_replace($linhas[2], $ocorrenciaSegmentoA, 230, 10);

        return implode("\r\n", $linhas) . "\r\n";
    }

    public function testDetectaLayoutL089(): void {
        $conteudo = $this->remessaTedParaRetorno();
        $retorno = new Retorno($conteudo);

        $this->assertSame('L089', Retorno::$layout);
        $this->assertEquals('089', $retorno->getLayout());
    }

    public function testParseRetornoOcorrenciaPos231a240(): void {
        $conteudo = $this->remessaTedParaRetorno('BD        ');
        $linhaA = explode("\r\n", trim($conteudo))[2];
        $this->assertSame('BD', substr($linhaA, 230, 2));

        $retorno = new Retorno($conteudo);
        $segmentoA = $retorno->getRegistros(1)[0];

        $this->assertSame('A', $segmentoA->codigo_segmento);
        $this->assertSame('BD', trim($segmentoA->codigo_ocorrencia));

        $ocorrencias = $segmentoA->get_arrayOcorrencias();
        $this->assertCount(1, $ocorrencias);
        $this->assertStringContainsString('BD -', $ocorrencias[0]);
        $this->assertStringContainsString('Inclusão Efetuada', $ocorrencias[0]);
    }

    public function testParseRetornoTedSegmentosAB(): void {
        $retorno = new Retorno($this->remessaTedParaRetorno());
        $detalhes = $retorno->getRegistros(1);

        $this->assertCount(1, $detalhes);
        $segmentoA = $detalhes[0];
        $this->assertSame('00', trim($segmentoA->codigo_ocorrencia));
        $this->assertCount(1, $segmentoA->getChilds());
        $this->assertSame('B', $segmentoA->getChilds()[0]->codigo_segmento);
    }

}
