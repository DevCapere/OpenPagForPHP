<?php

namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PagForPHP\Retorno;
use PHPUnit\Framework\TestCase;

class RetornoB341Test extends TestCase {

    private function headerData(): array {
        return [
            'nome_empresa'              => 'ATLANTICA CAP',
            'tipo_inscricao'            => 2,
            'numero_inscricao'          => '12345678000199',
            'agencia'                   => '01234',
            'agencia_dv'                => ' ',
            'conta'                     => '000000987654',
            'conta_dv'                  => '1',
            'codigo_empresa_banco'      => '123456',
            'numero_sequencial_arquivo' => 42,
        ];
    }

    private function remessaTedParaRetorno(string $ocorrenciaSegmentoA = '00        ', ?string $dataEfetiva = '15062026'): string {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
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
        $linhas[2] = substr_replace($linhas[2], $ocorrenciaSegmentoA, 230, 10);
        if ($dataEfetiva !== null) {
            $linhas[2] = substr_replace($linhas[2], $dataEfetiva, 154, 8);
            $valorEnc = substr($linhas[2], 119, 15);
            $linhas[2] = substr_replace($linhas[2], $valorEnc, 162, 15);
        }

        return implode("\r\n", $linhas) . "\r\n";
    }

    private function remessaBoletoParaRetorno(string $ocorrenciaSegmentoJ = '00        '): string {
        $codigoBarras = '34191090000012345678901234567890123456789012';

        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '30',
            'versao_layout'   => '030',
        ]);
        $lote->inserirBoleto([
            'codigo_barras'      => $codigoBarras,
            'nome_favorecido'    => 'CEDENTE BOLETO LTDA',
            'documento_cedente'  => '11222333000181',
            'data_vencimento'    => '2026-07-01',
            'data_pagamento'     => '2026-06-20',
            'valor_pagamento'    => 2500.00,
            'documento_id'       => 'BOL-001',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $linhas[0] = substr_replace($linhas[0], '2', 142, 1);
        $linhas[2] = substr_replace($linhas[2], $ocorrenciaSegmentoJ, 230, 10);

        return implode("\r\n", $linhas) . "\r\n";
    }

    public function testDetectaLayoutL080(): void {
        $conteudo = $this->remessaTedParaRetorno();
        $retorno = new Retorno($conteudo);

        $this->assertSame('L080', Retorno::$layout);
        $this->assertEquals('080', $retorno->getLayout());
    }

    public function testParseRetornoTedSegmentosAB(): void {
        $retorno = new Retorno($this->remessaTedParaRetorno());
        $detalhes = $retorno->getRegistros(1);

        $this->assertCount(1, $detalhes);

        $segmentoA = $detalhes[0];
        $this->assertSame('A', $segmentoA->codigo_segmento);
        $this->assertEquals('237', $segmentoA->codigo_banco_favorecido);
        $this->assertStringContainsString('FORNECEDOR TESTE LTDA', $segmentoA->nome_favorecido);
        $this->assertSame('00', trim($segmentoA->ocorrencias));
        $this->assertSame('2026-06-15', $segmentoA->data_efetiva);
        $this->assertSame('2026-06-15', $segmentoA->data_pagamento);

        $ocorrencias = $segmentoA->get_arrayOcorrencias();
        $this->assertCount(1, $ocorrencias);
        $this->assertStringContainsString('00 - Pagamento Efetuado', $ocorrencias[0]);

        $filhosA = $segmentoA->getChilds();
        $this->assertCount(1, $filhosA);
        $segmentoB = $filhosA[0];
        $this->assertSame('B', $segmentoB->codigo_segmento);
        $this->assertEquals('98765432000111', $segmentoB->numero_inscricao_favorecido);
    }

    public function testParseRetornoTedDataEfetivaZerada(): void {
        $retorno = new Retorno($this->remessaTedParaRetorno('00        ', null));
        $segmentoA = $retorno->getRegistros(1)[0];

        $this->assertSame('', $segmentoA->data_efetiva);
    }

    public function testParseRetornoBoletoSegmentosJJ52(): void {
        $retorno = new Retorno($this->remessaBoletoParaRetorno());
        $detalhes = $retorno->getRegistros(1);

        $this->assertCount(1, $detalhes);

        $segmentoJ = $detalhes[0];
        $this->assertSame('J', $segmentoJ->codigo_segmento);
        $this->assertEquals('341', $segmentoJ->codigo_barras_banco);
        $this->assertSame('00', trim($segmentoJ->ocorrencias));

        $filhosJ = $segmentoJ->getChilds();
        $this->assertCount(1, $filhosJ);
        $segmentoJ52 = $filhosJ[0];
        $this->assertSame('J', $segmentoJ52->codigo_segmento);
        $this->assertEquals('52', $segmentoJ52->codigo_registro);
    }

    public function testParseRetornoUtilidadesSegmentoO(): void {
        // Evidência prod SUS-4258 — PAG_341_3294_21224_11082607.RET (forma 13 / RJIK)
        $conteudo = implode("\r\n", [
            '34100000      080221753338000194          VANNEX    03294 000000021224 0FELIX HOTEIS LTDA             BANCO ITAU S/A                          21108202617584600053408006250                                                                     ',
            '34100011C2013080 221753338000194                    03294 000000021224 0FELIX HOTEIS LTDA                                                                                   00000                                   00000000                   ',
            '3410001300001O00085830000529088103852623207162621849892831302    RECEITA FEDERAL COD. 1162 - IN19082026REA00000000000000000000000529088119082026000000005290881               10291                                   0677818989000010RJIK      ',
            '34100015         000003000000000005290881000000000000000000                                                                                                                            ',
            '34199999         000001000005000000                                                                                                                                                    ',
        ]) . "\r\n";

        $retorno = new Retorno($conteudo);
        $detalhes = $retorno->getRegistros(1);

        $this->assertCount(1, $detalhes);
        $segmentoO = $detalhes[0];
        $this->assertSame('O', $segmentoO->codigo_segmento);
        $this->assertStringStartsWith('858300005290881', (string) $segmentoO->codigo_barras);
        $this->assertStringContainsString('RECEITA FEDERAL', (string) $segmentoO->nome_concessionaria);
        $this->assertSame('10291', trim((string) $segmentoO->seu_numero));
        $this->assertSame('RJIK', trim((string) $segmentoO->ocorrencias));
        $this->assertEquals(52908.81, (float) $segmentoO->valor_a_pagar);
    }

    public function testTrailerArquivo(): void {
        $retorno = new Retorno($this->remessaTedParaRetorno());
        $raiz = $retorno->getRegistrosRaiz();

        $this->assertCount(2, $raiz);
        $this->assertEquals('0', $raiz[0]->tipo_registro);
        $this->assertEquals('9', $raiz[1]->tipo_registro);
        $this->assertEquals('000001', $raiz[1]->qtd_lotes);
        $this->assertEquals('000006', $raiz[1]->qtd_registros);
    }

    public function testRejeitaArquivoRemessa(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '040',
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('arquivo de remessa');

        new Retorno($remessa->getText());
    }

}
