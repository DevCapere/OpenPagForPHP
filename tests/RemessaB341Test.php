<?php

namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PHPUnit\Framework\TestCase;

class RemessaB341Test extends TestCase {

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

    public function testHeaderArquivoSemLotes(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(2, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
            $this->assertSame('341', substr($linha, 0, 3));
        }

        $header = $linhas[0];
        $this->assertSame('0', substr($header, 7, 1));
        $this->assertSame('080', substr($header, 14, 3));
        $this->assertSame('1', substr($header, 142, 1));
        $this->assertStringContainsString('BANCO ITAU SA', $header);

        $trailer = $linhas[1];
        $this->assertSame('9999', substr($trailer, 3, 4));
        $this->assertSame('9', substr($trailer, 7, 1));
        $this->assertSame('000002', substr($trailer, 23, 6));
    }

    public function testHeaderLoteTed(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '040',
        ]);

        $this->assertNotNull($lote);

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(3, $linhas);

        $headerLote = $linhas[1];
        $this->assertSame('1', substr($headerLote, 7, 1));
        $this->assertSame('C', substr($headerLote, 8, 1));
        $this->assertSame('20', substr($headerLote, 9, 2));
        $this->assertSame('41', substr($headerLote, 11, 2));
        $this->assertSame('040', substr($headerLote, 13, 3));

        $trailer = $linhas[2];
        $this->assertSame('000001', substr($trailer, 17, 6));
        $this->assertSame('000003', substr($trailer, 23, 6));
    }

    public function testHeaderLoteBoleto(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '31',
            'versao_layout'   => '030',
        ]);

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);
        $headerLote = $linhas[1];

        $this->assertSame('31', substr($headerLote, 11, 2));
        $this->assertSame('030', substr($headerLote, 13, 3));
    }

    public function testRemessaTedComSegmentosAB(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '040',
        ]);

        $lote->inserirTransferencia([
            'banco_favorecido'      => '237',
            'agencia_favorecido'    => '0237',
            'conta_favorecido'      => '554433',
            'conta_dv_favorecido'   => '1',
            'nome_favorecido'       => 'FORNECEDOR TESTE LTDA',
            'documento_favorecido'  => '98765432000111',
            'documento_id'          => 'DOC-001',
            'data_pagamento'        => '2026-06-15',
            'valor'                 => 1500.55,
        ]);

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(6, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
            $this->assertSame('341', substr($linha, 0, 3));
        }

        $segmentoA = $linhas[2];
        $this->assertSame('A', substr($segmentoA, 13, 1));
        $this->assertSame('018', substr($segmentoA, 17, 3));
        $this->assertSame('237', substr($segmentoA, 20, 3));
        $this->assertStringContainsString('FORNECEDOR TESTE LTDA', $segmentoA);

        $segmentoB = $linhas[3];
        $this->assertSame('B', substr($segmentoB, 13, 1));
        $this->assertSame('2', substr($segmentoB, 17, 1));

        $trailerLote = $linhas[4];
        $this->assertSame('5', substr($trailerLote, 7, 1));
        $this->assertSame('000004', substr($trailerLote, 17, 6));

        $trailerArquivo = $linhas[5];
        $this->assertSame('000001', substr($trailerArquivo, 17, 6));
        $this->assertSame('000006', substr($trailerArquivo, 23, 6));
    }

    public function testRemessaBoletoComSegmentosJJ52(): void {
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

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(6, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
        }

        $segmentoJ = $linhas[2];
        $this->assertSame('J', substr($segmentoJ, 13, 1));
        $this->assertSame('341', substr($segmentoJ, 17, 3));
        $this->assertStringContainsString('CEDENTE BOLETO LTDA', $segmentoJ);

        $segmentoJ52 = $linhas[3];
        $this->assertSame('J', substr($segmentoJ52, 13, 1));
        $this->assertSame('52', substr($segmentoJ52, 17, 2));

        $trailerLote = $linhas[4];
        $this->assertSame('5', substr($trailerLote, 7, 1));
        $this->assertSame('000004', substr($trailerLote, 17, 6));
    }

    public function testRemessaMultiLoteTedTedEBoleto(): void {
        $codigoBarras = '34191090000012345678901234567890123456789012';

        $remessa = new Remessa('341', 'cnab240', $this->headerData());

        $loteTed = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '040',
        ]);
        $loteTed->inserirTransferencia([
            'banco_favorecido'     => '237',
            'agencia_favorecido'   => '0237',
            'conta_favorecido'     => '554433',
            'conta_dv_favorecido'  => '1',
            'nome_favorecido'      => 'FORNECEDOR 1',
            'documento_favorecido' => '98765432000111',
            'documento_id'         => 'DOC-1',
            'data_pagamento'       => '2026-06-15',
            'valor'                => 100.00,
        ]);
        $loteTed->inserirTransferencia([
            'banco_favorecido'     => '001',
            'agencia_favorecido'   => '1234',
            'conta_favorecido'     => '999888',
            'conta_dv_favorecido'  => '2',
            'nome_favorecido'      => 'FORNECEDOR 2',
            'documento_favorecido' => '11222333000181',
            'documento_id'         => 'DOC-2',
            'data_pagamento'       => '2026-06-16',
            'valor'                => 200.00,
        ]);

        $loteBoleto = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '30',
            'versao_layout'   => '030',
        ]);
        $loteBoleto->inserirBoleto([
            'codigo_barras'     => $codigoBarras,
            'nome_favorecido'   => 'CEDENTE BOLETO',
            'documento_cedente' => '11222333000181',
            'data_vencimento'   => '2026-07-01',
            'data_pagamento'    => '2026-06-20',
            'valor_pagamento'   => 2500.00,
            'documento_id'      => 'BOL-1',
        ]);

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(12, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
        }

        $this->assertSame('0001', substr($linhas[1], 3, 4));
        $this->assertSame('0001', substr($linhas[6], 3, 4));
        $this->assertSame('5', substr($linhas[6], 7, 1));
        $this->assertSame('000006', substr($linhas[6], 17, 6));

        $this->assertSame('0002', substr($linhas[7], 3, 4));
        $this->assertSame('030', substr($linhas[7], 13, 3));
        $this->assertSame('0002', substr($linhas[10], 3, 4));
        $this->assertSame('000004', substr($linhas[10], 17, 6));

        $trailerArquivo = $linhas[11];
        $this->assertSame('000002', substr($trailerArquivo, 17, 6));
        $this->assertSame('000012', substr($trailerArquivo, 23, 6));
    }

    public function testFormaPagamentoDetectaBancoDoCodigoBarras(): void {
        $itau = '34191090000012345678901234567890123456789012';
        $outro = '23791090000012345678901234567890123456789012';

        $this->assertSame('30', \PagForPHP\resources\B341\remessa\cnab240\Registro3J::formaPagamentoPorCodigoBarras($itau));
        $this->assertSame('31', \PagForPHP\resources\B341\remessa\cnab240\Registro3J::formaPagamentoPorCodigoBarras($outro));
    }

    public function testRemessaPixTransferenciaComChaveEmail(): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '040',
        ]);

        $lote->inserirTransferencia([
            'nome_favorecido'      => 'FORNECEDOR PIX LTDA',
            'documento_favorecido' => '98765432000111',
            'documento_id'         => 'PIX-001',
            'data_pagamento'       => '2026-06-15',
            'valor'                => 99.90,
            'chave_pix'            => 'fornecedor@exemplo.com.br',
            'tipo_chave_pix'       => '02',
        ]);

        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(6, $linhas);
        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
        }

        $headerLote = $linhas[1];
        $this->assertSame('45', substr($headerLote, 11, 2));

        $segmentoA = $linhas[2];
        $this->assertSame('A', substr($segmentoA, 13, 1));
        $this->assertSame('009', substr($segmentoA, 17, 3));
        $this->assertSame('04', substr($segmentoA, 112, 2));

        $segmentoB = $linhas[3];
        $this->assertSame('B', substr($segmentoB, 13, 1));
        $this->assertSame('02', substr($segmentoB, 14, 2)); // pos 015-016 (Nota 37)
        $this->assertSame(' ', substr($segmentoB, 16, 1));  // pos 017
        $chaveNoArquivo = rtrim(substr($segmentoB, 127, 100)); // pos 128-227
        $this->assertSame('FORNECEDOR@EXEMPLO.COM.BR', $chaveNoArquivo);
        $this->assertStringContainsString('FORNECEDOR@EXEMPLO.COM.BR', strtoupper($segmentoB));
    }

    /**
     * @dataProvider providerChavesPix
     */
    public function testRemessaPixTiposDeChave(string $tipoChave, string $chave): void {
        $remessa = new Remessa('341', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '040',
        ]);

        $lote->inserirTransferencia([
            'nome_favorecido'      => 'PIX TESTE',
            'documento_favorecido' => '12345678901',
            'documento_id'         => 'PIX-T',
            'data_pagamento'       => '2026-06-15',
            'valor'                => 10.00,
            'chave_pix'            => $chave,
            'tipo_chave_pix'       => $tipoChave,
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $segmentoB = $linhas[3];

        $this->assertSame($tipoChave, substr($segmentoB, 14, 2));
        $this->assertStringContainsString(strtoupper($chave), strtoupper($segmentoB));
    }

    public static function providerChavesPix(): array {
        return [
            'telefone'  => ['01', '+5511999998888'],
            'email'     => ['02', 'pix@teste.com'],
            'cpf'       => ['03', '12345678901'],
            'cnpj'      => ['03', '12345678000199'],
            'aleatoria' => ['04', '123e4567-e89b-12d3-a456-426614174000'],
        ];
    }

}
