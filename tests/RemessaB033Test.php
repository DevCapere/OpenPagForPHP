<?php

namespace PagForPHP\Tests;

use PagForPHP\Remessa;
use PHPUnit\Framework\TestCase;

class RemessaB033Test extends TestCase {

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
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $conteudo = rtrim($remessa->getText(), "\r\n");
        $linhas = explode("\r\n", $conteudo);

        $this->assertCount(2, $linhas);

        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
            $this->assertSame('033', substr($linha, 0, 3));
        }

        $header = $linhas[0];
        $this->assertSame('0', substr($header, 7, 1));
        $this->assertSame(str_repeat(' ', 9), substr($header, 8, 9)); // pos 009-017
        $this->assertSame('060', substr($header, 163, 3)); // pos 164-166
        $this->assertSame('1', substr($header, 142, 1));
        $this->assertStringContainsString('BANCO SANTANDER SA', $header);

        $trailer = $linhas[1];
        $this->assertSame('9999', substr($trailer, 3, 4));
        $this->assertSame('9', substr($trailer, 7, 1));
        $this->assertSame('000002', substr($trailer, 23, 6));
    }

    public function testHeaderLoteTed(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '031',
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
        $this->assertSame('031', substr($headerLote, 13, 3));

        $trailer = $linhas[2];
        $this->assertSame('000001', substr($trailer, 17, 6));
        $this->assertSame('000003', substr($trailer, 23, 6));
    }

    public function testHeaderLoteBoleto(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
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
        // Manual layout 030: pos. 033-052 = BRANCOS (não identificacao/num_empresa).
        $this->assertSame(str_repeat(' ', 20), substr($headerLote, 32, 20));
    }

    public function testHeaderArquivoComNsaEVersao060(): void {
        $remessa = new Remessa('033', 'cnab240', array_merge($this->headerData(), [
            'codigo_empresa_banco'      => '203531',
            'numero_sequencial_arquivo' => 99,
        ]));
        $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '31',
            'versao_layout'   => '030',
        ]);

        $headerArquivo = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[0];

        // Manual V11.7: NSA 158-163 + versão layout 164-166 = 060
        $this->assertSame('000099', substr($headerArquivo, 157, 6));
        $this->assertSame('060', substr($headerArquivo, 163, 3));
        // G009: BBBB="033 " + AAAA(agência) + CCCCCCCCCCCC(convênio)
        $this->assertSame('033 1234000000203531', substr($headerArquivo, 32, 20));
        // Boleto 030: convênio em branco no header de lote
        $headerLote = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[1];
        $this->assertSame(str_repeat(' ', 20), substr($headerLote, 32, 20));
    }

    public function testRemessaTedComSegmentosAB(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '031',
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
            $this->assertSame('033', substr($linha, 0, 3));
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
        $codigoBarras = '03391090000012345678901234567890123456789012';

        $remessa = new Remessa('033', 'cnab240', $this->headerData());
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
        $this->assertSame('033', substr($segmentoJ, 17, 3));
        // Posições 18–61 (0-based 17–60): 44 dígitos do código de barras intactos
        $this->assertSame($codigoBarras, substr($segmentoJ, 17, 44));
        $this->assertStringContainsString('CEDENTE BOLETO LTDA', $segmentoJ);

        $segmentoJ52 = $linhas[3];
        $this->assertSame('J', substr($segmentoJ52, 13, 1));
        $this->assertSame('52', substr($segmentoJ52, 17, 2));
        // Produção/portal Santander: J-52 sobe o sequencial (J=00001, J-52=00002) — arquivo aceito cliente
        $this->assertSame('00001', substr($segmentoJ, 8, 5));
        $this->assertSame('00002', substr($segmentoJ52, 8, 5));

        $trailerLote = $linhas[4];
        $this->assertSame('5', substr($trailerLote, 7, 1));
        $this->assertSame('000004', substr($trailerLote, 17, 6));
        // TOTAL VALOR PAGTOS (024-041) = soma valor_pagamento do Segmento J — não zeros
        $this->assertSame('000000000000250000', substr($trailerLote, 23, 18));
    }

    /**
     * SUS-4117 — campo livre 25 dígitos não pode passar por float/number_format.
     * Prova do bug: number_format('1234567890123456789012345') ≠ input.
     */
    public function testRemessaBoletoCampoLivreNaoCorrompePorFloat(): void {
        $campoLivre = '1234567890123456789012345';
        $this->assertNotSame(
            $campoLivre,
            number_format($campoLivre, 0, '', ''),
            'Pré-condição: number_format corrompe 25 dígitos (float IEEE-754)'
        );

        // 033 + 9 + DAC + fator + valor(10) + campo_livre(25) = 44
        $codigoBarras = '0339' . '7' . '1528' . '0000035288' . $campoLivre;
        $this->assertSame(44, strlen($codigoBarras));

        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '30',
            'versao_layout'   => '030',
        ]);

        $lote->inserirBoleto([
            'codigo_barras'   => $codigoBarras,
            'nome_favorecido' => 'LAMPEIRO',
            'data_vencimento' => '2026-08-03',
            'data_pagamento'  => '2026-08-03',
            'valor_pagamento' => 352.88,
            'documento_id'    => 'FELIX-001',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $segmentoJ = $linhas[2];

        $this->assertSame('J', substr($segmentoJ, 13, 1));
        $this->assertSame($codigoBarras, substr($segmentoJ, 17, 44));
        $this->assertSame($campoLivre, substr($segmentoJ, 36, 25));
        $this->assertSame('0000035288', substr($segmentoJ, 26, 10));

        // Retorno Santander 29/07/2026 Felix: "VALOR CALCULADO DIFERENTE DO INFORMADO (0,00)"
        // Trailer lote informava zeros; deve espelhar R$ 352,88 do Segmento J.
        $trailerLote = $linhas[4];
        $this->assertSame('5', substr($trailerLote, 7, 1));
        $this->assertSame('000004', substr($trailerLote, 17, 6));
        $this->assertSame('000000000000035288', substr($trailerLote, 23, 18));
    }

    public function testRemessaMultiLoteTedTedEBoleto(): void {
        $codigoBarras = '03391090000012345678901234567890123456789012';

        $remessa = new Remessa('033', 'cnab240', $this->headerData());

        $loteTed = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '41',
            'versao_layout'   => '031',
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
        $itau = '03391090000012345678901234567890123456789012';
        $outro = '23791090000012345678901234567890123456789012';

        $this->assertSame('30', \PagForPHP\resources\B033\remessa\cnab240\Registro3J::formaPagamentoPorCodigoBarras($itau));
        $this->assertSame('31', \PagForPHP\resources\B033\remessa\cnab240\Registro3J::formaPagamentoPorCodigoBarras($outro));
    }

    public function testRemessaPixTransferenciaComChaveEmail(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '031',
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
        $this->assertSame(str_repeat('0', 15), substr($segmentoA, 104, 15)); // qtd moeda 105-119
        $this->assertSame('000000000009990', substr($segmentoA, 119, 15)); // valor 99.90

        $segmentoB = $linhas[3];
        $this->assertSame('B', substr($segmentoB, 13, 1));
        $this->assertSame('02', substr($segmentoB, 14, 2)); // G032
        $this->assertSame(' ', substr($segmentoB, 16, 1));
        $this->assertSame('98765432000111', substr($segmentoB, 18, 14)); // CPF/CNPJ 019-032
        $chaveNoArquivo = rtrim(substr($segmentoB, 127, 99)); // Info12 128-226
        $this->assertSame('FORNECEDOR@EXEMPLO.COM.BR', $chaveNoArquivo);
        $this->assertSame('00000000', substr($segmentoB, 232, 8)); // ISPB 233-240
    }

    /**
     * @dataProvider providerChavesPix
     */
    public function testRemessaPixTiposDeChave(string $tipoChave, string $chave): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '031',
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

        $chaveEsperada = in_array($tipoChave, ['01', '03'], true)
            ? (preg_replace('/\D/', '', $chave) ?? '')
            : $chave;
        $this->assertStringContainsString(strtoupper($chaveEsperada), strtoupper($segmentoB));
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

    public function testRemessaPixInscricaoEChaveNoSegmentoB(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '031',
        ]);

        $lote->inserirTransferencia([
            'nome_favorecido'      => 'FRIGOBOI COMERCIO DE ALIMENTOS',
            'documento_favorecido' => '05017924000114',
            'documento_id'         => '10309',
            'data_pagamento'       => '2026-08-26',
            'valor'                => 1249.20,
            'chave_pix'            => '05017924000114',
            'tipo_chave_pix'       => '03',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $segmentoA = $linhas[2];
        $segmentoB = $linhas[3];

        // Manual V11.7: CPF/CNPJ no Segmento B (019-032); Info 2 do A é mensagem (não inscrição).
        $this->assertSame(str_repeat(' ', 40), substr($segmentoA, 177, 40));
        $this->assertSame('05017924000114', substr($segmentoB, 18, 14));
        $this->assertSame('05017924000114', rtrim(substr($segmentoB, 127, 99)));
    }

    public function testRemessaPixCpfComMascaraRemovePontuacaoNoSegmentoB(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '45',
            'versao_layout'   => '031',
        ]);

        $lote->inserirTransferencia([
            'nome_favorecido'      => 'MILENA FUNARI',
            'documento_favorecido' => '03026723037',
            'documento_id'         => '9908',
            'data_pagamento'       => '2026-07-31',
            'valor'                => 1.00,
            'chave_pix'            => '030.267.230-37',
            'tipo_chave_pix'       => '03',
        ]);

        $segmentoB = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[3];
        $chaveNoArquivo = rtrim(substr($segmentoB, 127, 99));

        $this->assertSame('03', substr($segmentoB, 14, 2));
        $this->assertSame('03026723037', $chaveNoArquivo);
        $this->assertStringNotContainsString('030.267.230-37', $segmentoB);
    }

    /**
     * SUS-4127 — forma 47: J + J-52 PIX (QR estático = chave sem TXID).
     */
    public function testRemessaPixQrEstaticoComChave(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '47',
            'versao_layout'   => '030',
        ]);

        $lote->inserirPixQr([
            'nome_favorecido'      => 'FORNECEDOR QR LTDA',
            'documento_favorecido' => '11222333000181',
            'documento_id'         => 'QR-EST-001',
            'data_vencimento'      => '2026-08-15',
            'data_pagamento'       => '2026-08-11',
            'valor_pagamento'      => 150.25,
            'chave_pagamento'      => 'fornecedor.qr@exemplo.com.br',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));

        $this->assertCount(6, $linhas);
        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
        }

        $headerLote = $linhas[1];
        $this->assertSame('47', substr($headerLote, 11, 2));
        $this->assertSame('030', substr($headerLote, 13, 3));

        $segmentoJ = $linhas[2];
        $this->assertSame('J', substr($segmentoJ, 13, 1));
        $this->assertSame('00001', substr($segmentoJ, 8, 5));
        // Nota 18: barras zeradas no QR
        $this->assertSame(str_repeat('0', 44), substr($segmentoJ, 17, 44));
        $this->assertSame('000000000015025', substr($segmentoJ, 152, 15)); // valor pagamento 150.25

        $segmentoJ52 = $linhas[3];
        $this->assertSame('J', substr($segmentoJ52, 13, 1));
        $this->assertSame('52', substr($segmentoJ52, 17, 2));
        $this->assertSame('00002', substr($segmentoJ52, 8, 5));
        $chaveNoArquivo = rtrim(substr($segmentoJ52, 131, 77));
        $txidNoArquivo = rtrim(substr($segmentoJ52, 208, 32));
        $this->assertSame('fornecedor.qr@exemplo.com.br', $chaveNoArquivo);
        $this->assertSame('', $txidNoArquivo);

        $trailerLote = $linhas[4];
        $this->assertSame('000004', substr($trailerLote, 17, 6));
        $this->assertSame('000000000000015025', substr($trailerLote, 23, 18));
    }

    /**
     * SUS-4127 — QR dinâmico: URL sem https + TXID (Notas 41/38).
     */
    public function testRemessaPixQrDinamicoUrlSemHttpsETxid(): void {
        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '47',
            'versao_layout'   => '030',
        ]);

        $lote->inserirPixQr([
            'nome_favorecido'      => 'RECEBEDOR DINAMICO',
            'documento_favorecido' => '12345678901',
            'documento_id'         => 'QR-DIN-001',
            'data_pagamento'       => '2026-08-11',
            'valor'                => 99.90,
            'chave_pagamento'      => 'https://qr.example.com/pix/abc123',
            'txid'                 => 'TXIDDINAMICO001ABCDEFGHIJKLMN',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));
        $segmentoJ52 = $linhas[3];

        $chaveNoArquivo = rtrim(substr($segmentoJ52, 131, 77));
        $txidNoArquivo = rtrim(substr($segmentoJ52, 208, 32));

        $this->assertSame('qr.example.com/pix/abc123', $chaveNoArquivo);
        $this->assertStringNotContainsString('https://', $chaveNoArquivo);
        $this->assertSame('TXIDDINAMICO001ABCDEFGHIJKLMN', $txidNoArquivo);

        $segmentoJ = $linhas[2];
        $this->assertSame(str_repeat('0', 44), substr($segmentoJ, 17, 44));
        $this->assertSame('000000000009990', substr($segmentoJ, 152, 15));
    }

    public function testNormalizarChavePagamentoRemoveHttps(): void {
        $this->assertSame(
            'pix.itau.com.br/qr/v2/abc',
            \PagForPHP\resources\B033\remessa\cnab240\Registro3J52Pix::normalizarChavePagamento(
                'https://pix.itau.com.br/qr/v2/abc'
            )
        );
        $this->assertSame(
            'pix.itau.com.br/qr/v2/abc',
            \PagForPHP\resources\B033\remessa\cnab240\Registro3J52Pix::normalizarChavePagamento(
                'HTTP://pix.itau.com.br/qr/v2/abc'
            )
        );
        $this->assertSame(
            '03026723037',
            \PagForPHP\resources\B033\remessa\cnab240\Registro3J52Pix::normalizarChavePagamento('03026723037')
        );
    }

    /**
     * SUS-4127 / SUS-4230 — forma 13: Segmento O com óptico 44 (linha 48 é convertida).
     */
    public function testRemessaConcessionariaSegmentoOForma13(): void {
        $linha48 = '858300005299088103852623320716262189498928313022';
        $optico44 = '85830000529088103852623207162621849892831302';
        $this->assertSame(48, strlen($linha48));
        $this->assertSame(44, strlen($optico44));

        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '13',
            'versao_layout'   => '030',
        ]);

        $lote->inserirConcessionaria([
            'codigo_barras'        => $linha48,
            'nome_concessionaria'  => 'RECEITA FEDERAL INSS',
            'data_vencimento'      => '2026-08-19',
            'data_pagamento'       => '2026-08-19',
            'valor_a_pagar'        => 52908.81,
            'documento_id'         => '10291',
        ]);

        $linhas = explode("\r\n", rtrim($remessa->getText(), "\r\n"));

        $this->assertCount(5, $linhas);
        foreach ($linhas as $linha) {
            $this->assertSame(240, strlen($linha));
        }

        $headerLote = $linhas[1];
        $this->assertSame('13', substr($headerLote, 11, 2));
        $this->assertSame('030', substr($headerLote, 13, 3));

        $segmentoO = $linhas[2];
        $this->assertSame('O', substr($segmentoO, 13, 1));
        $this->assertSame('00001', substr($segmentoO, 8, 5));
        // Linha 48 → óptico 44 + pad (Santander rejeita linha com DV campo mod11 / id 8)
        $this->assertSame($optico44 . '    ', substr($segmentoO, 17, 48));
        $this->assertSame('REA', substr($segmentoO, 103, 3));
        $this->assertSame('000000005290881', substr($segmentoO, 121, 15)); // valor a pagar 52908.81

        $trailerLote = $linhas[3];
        $this->assertSame('5', substr($trailerLote, 7, 1));
        $this->assertSame('000003', substr($trailerLote, 17, 6)); // header + O + trailer
        $this->assertSame('000000000005290881', substr($trailerLote, 23, 18));
    }

    public function testRemessaConcessionariaAceitaBarras44PadDireita(): void {
        $barras44 = '85830000529088103852623207162621849892831302';
        $this->assertSame(44, strlen($barras44));

        $remessa = new Remessa('033', 'cnab240', $this->headerData());
        $lote = $remessa->addLote([
            'tipo_pagamento'  => '20',
            'forma_pagamento' => '13',
            'versao_layout'   => '030',
        ]);
        $lote->inserirConcessionaria([
            'codigo_barras'   => $barras44,
            'nome_favorecido' => 'CONCESSIONARIA X',
            'data_pagamento'  => '2026-08-11',
            'valor'           => 10.00,
            'documento_id'    => 'UT-44',
        ]);

        $segmentoO = explode("\r\n", rtrim($remessa->getText(), "\r\n"))[2];
        $campoBarras = substr($segmentoO, 17, 48);
        $this->assertSame($barras44 . '    ', $campoBarras);
    }

    public function testNormalizarCodigoBarrasArrecadacaoRejeita45(): void {
        $this->expectException(\Exception::class);
        \PagForPHP\resources\B033\remessa\cnab240\Registro3O::normalizarCodigoBarrasArrecadacao(
            '858300005290881038526232071626218498928313022' // 45 — bug Capere 10291
        );
    }

}
