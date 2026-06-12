<?php

namespace PagForPHP\resources\B341\retorno\L080;

/**
 * Códigos de ocorrência SISPAG Itaú (subset Febraban / manual B341).
 */
class CodigosOcorrencia {

    const LISTA = [
        ['id' => '00', 'descricao' => 'Pagamento Efetuado'],
        ['id' => '01', 'descricao' => 'Insuficiência de Fundos'],
        ['id' => '02', 'descricao' => 'Crédito ou Débito Cancelado'],
        ['id' => 'BD', 'descricao' => 'Inclusão Efetuada com Sucesso'],
        ['id' => 'BE', 'descricao' => 'Alteração Efetuada com Sucesso'],
        ['id' => 'BF', 'descricao' => 'Exclusão Efetuada com Sucesso'],
        ['id' => 'HA', 'descricao' => 'Lote Não Aceito'],
        ['id' => 'HI', 'descricao' => 'Arquivo não aceito'],
        ['id' => 'AE', 'descricao' => 'Tipo/Número de Inscrição Inválido'],
        ['id' => 'AG', 'descricao' => 'Agência/Conta Corrente/DV Inválido'],
        ['id' => 'AP', 'descricao' => 'Data de Pagamento Inválida'],
        ['id' => 'AR', 'descricao' => 'Valor do Lançamento Inválido'],
        ['id' => 'BI', 'descricao' => 'Inconsistência no Segmento J-52'],
    ];

    public static function getDescricao(string $codigo): ?string {
        foreach (self::LISTA as $ocorrencia) {
            if ($ocorrencia['id'] === $codigo) {
                return $ocorrencia['descricao'];
            }
        }

        return null;
    }

    public static function getRelacao(string $ocorrencias): array {
        $ocorrencias = trim($ocorrencias);
        $relacao = [];

        while ($ocorrencias !== '') {
            $ocorrencia = substr($ocorrencias, 0, 2);
            $ocorrencias = substr($ocorrencias, 2);

            if ($ocorrencia === '' || $ocorrencia === '  ') {
                break;
            }

            $descricao = self::getDescricao($ocorrencia) ?? 'Ocorrência não identificada';
            $relacao[] = $ocorrencia . ' - ' . $descricao;
        }

        return $relacao;
    }

}
