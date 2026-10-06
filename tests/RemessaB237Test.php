<?php

namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PHPUnit\Framework\TestCase;

class RemessaB237Test extends TestCase {

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

    public function testHeaderArquivoSemLotes(): void {
        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(2, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
            $this->assertSame('237', substr($linha, 0, 3));
        }

        $header = $linhas[0];
        $this->assertSame('0', substr($header, 7, 1));
        $this->assertSame(str_repeat(' ', 9), substr($header, 8, 9));
        $this->assertSame('089', substr($header, 163, 3));
        $this->assertSame('1', substr($header, 142, 1));
        $this->assertStringContainsString('BANCO BRADESCO SA', $header);
        $this->assertSame('12345678901234567890', substr($header, 32, 20));
    }

    public function testHeaderLoteTedFormasPermitidas(): void {
        foreach (['01', '03', '41', '43'] as $forma) {
            $remessa = new Remessa('237', 'cnab240', $this->headerData());
            $remessa->addLote([
                'tipo_pagamento'  => '20',
                'forma_pagamento' => $forma,
                'versao_layout'   => '045',
            ]);

            $headerLote = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[1];
            $this->assertSame($forma, substr($headerLote, 11, 2), "forma $forma");
            $this->assertSame('045', substr($headerLote, 13, 3));
        }
    }

    public function testHeaderLoteBoleto040(): void {
        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '31',
            'versao_layout'   => '040',
        ]);

        $headerLote = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[1];
        $this->assertSame('31', substr($headerLote, 11, 2));
        $this->assertSame('040', substr($headerLote, 13, 3));
    }

    public function testHeaderLoteUtilidades012Forma11(): void {
        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '11',
            'versao_layout'   => '012',
        ]);

        $headerLote = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[1];
        $this->assertSame('11', substr($headerLote, 11, 2));
        $this->assertSame('012', substr($headerLote, 13, 3));
    }

    public function testRemessaTedComSegmentosAB(): void {
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
        $this->assertCount(6, $linhas);
        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
            $this->assertSame('237', substr($linha, 0, 3));
        }

        $this->assertSame('A', substr($linhas[2], 13, 1));
        $this->assertSame('B', substr($linhas[3], 13, 1));
    }

    public function testRemessaBoletoComSegmentosJJ52(): void {
        $codigoBarras = '23791090000012345678901234567890123456789012';

        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '30',
            'versao_layout'   => '040',
        ]);

        $lote->inserirBoleto([
            'codigo_barras'     => $codigoBarras,
            'nome_favorecido'   => 'CEDENTE BOLETO LTDA',
            'documento_cedente' => '11222333000181',
            'data_vencimento'   => '2026-07-01',
            'data_pagamento'    => '2026-06-20',
            'valor_pagamento'   => 2500.00,
            'documento_id'      => 'BOL-001',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $this->assertCount(6, $linhas);
        $this->assertSame('J', substr($linhas[2], 13, 1));
        $this->assertSame($codigoBarras, substr($linhas[2], 17, 44));
        $this->assertSame('J', substr($linhas[3], 13, 1));
        $this->assertSame('52', substr($linhas[3], 17, 2));
    }

    public function testRemessaConcessionariaSegmentoO(): void {
        $barras44 = '85830000529088103852623207162621849892831302';

        $remessa = new Remessa('237', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '11',
            'versao_layout'   => '012',
        ]);

        $lote->inserirConcessionaria([
            'codigo_barras'       => $barras44,
            'nome_concessionaria' => 'RECEITA FEDERAL INSS',
            'data_vencimento'     => '2026-08-19',
            'data_pagamento'      => '2026-08-19',
            'valor_a_pagar'       => 52908.81,
            'documento_id'        => '10291',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $this->assertCount(5, $linhas);
        $this->assertSame('O', substr($linhas[2], 13, 1));
        $this->assertSame($barras44 . '    ', substr($linhas[2], 17, 48));
    }

}
