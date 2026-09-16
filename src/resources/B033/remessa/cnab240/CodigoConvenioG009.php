<?php

namespace PagForPHP\resources\B033\remessa\cnab240;

use PagForPHP\RemessaAbstract;

/**
 * Nota G009 — Código do Convênio / código de transmissão (pos. 033-052, X(020)).
 *
 * Manual: BBBBAAAACCCCCCCCCCCC.
 * BBBB = banco 4 posições. O PDF cita “033”; o código de transmissão homologado
 * pelo banco é “0033” (zero à esquerda) — evidência piloto 1236 / e-mail operacional.
 * AAAA = agência sem DV. C…C = convênio 12, zeros à esquerda.
 */
final class CodigoConvenioG009
{
    public static function montar(array $entryData, $value = null): string
    {
        if ($value !== '' && $value !== null && trim((string) $value) !== '') {
            return str_pad(substr((string) $value, 0, 20), 20, ' ', STR_PAD_RIGHT);
        }

        $fonte = array_merge(RemessaAbstract::$entryData ?? [], $entryData);
        $convenio = preg_replace('/\D/', '', (string) ($fonte['codigo_empresa_banco'] ?? '')) ?? '';
        $agencia = preg_replace('/\D/', '', (string) ($fonte['agencia'] ?? '0')) ?? '';
        $agencia4 = substr(str_pad($agencia !== '' ? $agencia : '0', 4, '0', STR_PAD_LEFT), -4);
        $convenio12 = str_pad($convenio !== '' ? $convenio : '0', 12, '0', STR_PAD_LEFT);

        return '0033' . $agencia4 . $convenio12;
    }
}
