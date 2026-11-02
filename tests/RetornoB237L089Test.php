<?php

namespace PagForPHP\Tests;

use PagForPHP\resources\B237\retorno\L089\Registro3B;
use PagForPHP\resources\B237\retorno\L089\Registro3BPix;
use PagForPHP\Retorno;
use PHPUnit\Framework\TestCase;

class RetornoB237L089Test extends TestCase
{
    private function ler(string $arquivo): Retorno
    {
        $path = __DIR__ . '/fixtures/sus-5423/' . $arquivo;
        return new Retorno((string) file_get_contents($path));
    }

    private function porSegmento(Retorno $retorno, string $segmento): array
    {
        $achados = [];
        foreach ($retorno->getRegistros(1) as $detalhe) {
            if ($detalhe->codigo_segmento === $segmento) {
                $achados[] = $detalhe;
            }
            foreach ($detalhe->getChilds() ?: [] as $filho) {
                if ($filho->codigo_segmento === $segmento) {
                    $achados[] = $filho;
                }
            }
        }

        return $achados;
    }

    public function testAgendadoSemSegmentoZ(): void
    {
        $retorno = $this->ler('PAG_237_453401_261021_00004.RET');
        $this->assertSame([], $this->porSegmento($retorno, 'Z'));

        $segmentoA = $this->porSegmento($retorno, 'A')[0];
        $this->assertSame('BD', $segmentoA->codigo_ocorrencia);
        $this->assertInstanceOf(Registro3B::class, $segmentoA->getChilds()[0]);
    }

    public function testPagoComSegmentoZ(): void
    {
        $boleto = $this->porSegmento($this->ler('PAG_237_453410_261022_00001.RET'), 'Z')[0];
        $linhaBoleto = $boleto->linha;
        $this->assertSame('', $boleto->autenticacao_pagamento);
        $this->assertSame('', trim(substr($linhaBoleto, 14, 64)));
        $this->assertSame(trim(substr($linhaBoleto, 78, 25)), $boleto->protocolo_pagamento);
        $this->assertNotSame('', $boleto->protocolo_pagamento);
        $this->assertSame('00', $boleto->codigo_ocorrencia);

        $pix = $this->porSegmento($this->ler('PAG_237_453401_261026_00006.RET'), 'Z')[0];
        $linhaPix = $pix->linha;
        $this->assertSame(trim(substr($linhaPix, 14, 64)), $pix->autenticacao_pagamento);
        $this->assertNotSame('', $pix->autenticacao_pagamento);
        $this->assertSame(trim(substr($linhaPix, 78, 25)), $pix->protocolo_pagamento);
        $this->assertStringStartsWith('E60746948', $pix->autenticacao_pagamento);
    }

    public function testPixForma45(): void
    {
        $segmentoA = $this->porSegmento($this->ler('PAG_237_453401_261026_00002.RET'), 'A')[0];
        $this->assertSame(9, (int) $segmentoA->codigo_camara_compensacao);

        $segmentoB = $segmentoA->getChilds()[0];
        $this->assertInstanceOf(Registro3BPix::class, $segmentoB);
        $this->assertSame('03', $segmentoB->forma_iniciacao);
        $this->assertSame('', $segmentoB->filler1);

        $chave = trim(substr($segmentoB->linha, 127, 99));
        $this->assertSame(14, strlen($chave));
        $this->assertSame($chave, $segmentoB->informacao_12);
        $this->assertSame('64110997000115', $segmentoB->informacao_12);
    }

    public function testConcessionariaForma11(): void
    {
        $segmentoO = $this->porSegmento($this->ler('PAG_237_453401_261022_00001.RET'), 'O')[0];
        $linha = $segmentoO->linha;

        $this->assertSame(48, strlen(substr($linha, 17, 48)));
        $this->assertStringStartsWith('84660000015245500240202405000060009975012609', $segmentoO->codigo_barras);
        $this->assertSame('OI SA - EM RECUPERACAO JUDICIA', $segmentoO->nome_concessionaria);
        $this->assertStringStartsWith('OI SA', $segmentoO->nome_concessionaria);
        $this->assertSame('2026-10-23', $segmentoO->data_vencimento);
        $this->assertSame('REA', $segmentoO->codigo_moeda);
        $this->assertEquals(1524.55, $segmentoO->vlr_pagamento);
        $this->assertSame('20750', $segmentoO->seu_numero);
        $this->assertStringStartsWith('HL', $segmentoO->codigo_ocorrencia);
    }

    public function testDataRealZerada(): void
    {
        $agendado = $this->porSegmento($this->ler('PAG_237_453401_261026_00002.RET'), 'A')[0];
        $this->assertSame('00000000', substr($agendado->linha, 154, 8));
        $this->assertSame('', $agendado->data_pagamento_real);

        $pago = $this->porSegmento($this->ler('PAG_237_453401_261021_00002.RET'), 'A')[0];
        $this->assertSame('21102026', substr($pago->linha, 154, 8));
        $this->assertSame('2026-10-21', $pago->data_pagamento_real);
    }
}
