<?php

namespace PagForPHP\resources\B033\retorno\L060;

class CodigosOcorrencia {
    const LISTA = [
        ['id' => '00', 'descricao' => 'Crédito ou Débito Efetivado'],
        ['id' => '01', 'descricao' => 'Insuficiência de Fundos - Débito Não Efetuado'],
        ['id' => '02', 'descricao' => 'Crédito ou Débito Cancelado pelo Pagador/Credor'],
        ['id' => '03', 'descricao' => 'Débito Autorizado pela Agência - Efetuado'],
        ['id' => 'AA', 'descricao' => 'Controle Inválido'],
        ['id' => 'AB', 'descricao' => 'Tipo de Operação Inválido'],
        ['id' => 'AC', 'descricao' => 'Tipo de Serviço Inválido'],
        ['id' => 'AD', 'descricao' => 'Forma de Lançamento Inválida'],
        ['id' => 'AE', 'descricao' => 'Tipo/Número de Inscrição Inválido (gerado na crítica ou para informar rejeição)*'],
        ['id' => 'AF', 'descricao' => 'Código de Convênio Inválido'],
        ['id' => 'AG', 'descricao' => 'Agência/Conta Corrente/DV Inválido'],
        ['id' => 'AH', 'descricao' => 'Número Sequencial do Registro no Lote Inválido'],
        ['id' => 'AI', 'descricao' => 'Código de Segmento de Detalhe Inválido'],
        ['id' => 'AJ', 'descricao' => 'Tipo de Movimento Inválido'],
        ['id' => 'AK', 'descricao' => 'Código da Câmara de Compensação do Banco do Favorecido/Depositário Inválido'],
        ['id' => 'AL', 'descricao' => 'Código do Banco do Favorecido, Instituição de Pagamento ou Depositário Inválido'],
        ['id' => 'AM', 'descricao' => 'Agência Mantenedora da Conta Corrente do Favorecido Inválida'],
        ['id' => 'AN', 'descricao' => 'Conta Corrente/DV /Conta de Pagamento do Favorecido Inválido'],
        ['id' => 'AO', 'descricao' => 'Nome do Favorecido não Informado'],
        ['id' => 'AP', 'descricao' => 'Data Lançamento Inválida/Vencimento Inválido/Data de Pagamento não permitida.'],
        ['id' => 'AQ', 'descricao' => 'Tipo/Quantidade da Moeda Inválido'],
        ['id' => 'AR', 'descricao' => 'Valor do Lançamento Inválido/Divergente/Zerado'],
        ['id' => 'AS', 'descricao' => 'Aviso ao Favorecido - Identificação Inválida'],
        ['id' => 'AT', 'descricao' => 'Tipo/Número de Inscrição do Favorecido/Contribuinte Inválido'],
        ['id' => 'AU', 'descricao' => 'Logradouro do Favorecido não Informado'],
        ['id' => 'AV', 'descricao' => 'Número do Local do Favorecido não Informado'],
        ['id' => 'AW', 'descricao' => 'Cidade do Favorecido não Informada'],
        ['id' => 'AX', 'descricao' => 'CEP/Complemento do Favorecido Inválido'],
        ['id' => 'AY', 'descricao' => 'Sigla do Estado do Favorecido Inválido'],
        ['id' => 'AZ', 'descricao' => 'Código/Nome do Banco Depositário Inválido'],
        ['id' => 'A1', 'descricao' => 'Sequencial De Arq. Diverge Do Esperado'],
        ['id' => 'A2', 'descricao' => 'Finalidade Do Doc/Ted Invalida'],
        ['id' => 'A3', 'descricao' => 'Banco/Tipo Registro/Cod Rem-Ret Invalido'],
        ['id' => 'A4', 'descricao' => 'Registro Do Arquivo Remessa Não Identificado'],
        ['id' => 'A5', 'descricao' => 'Registro Header Não Encontrado'],
        ['id' => 'A6', 'descricao' => 'Registro Trailler Não Encontrado'],
        ['id' => 'A7', 'descricao' => 'Remessa Sem Registros Detalhe'],
        ['id' => 'A8', 'descricao' => 'Arquivo Com Mais De Um Registro Header'],
        ['id' => 'A9', 'descricao' => 'Arquivo Com Mais De Um Registro Trailler'],
        ['id' => 'BB', 'descricao' => 'Número do Documento Inválido(Seu Número)'],
        ['id' => 'BC', 'descricao' => 'Nosso Número Invalido'],
        ['id' => 'BD', 'descricao' => 'Inclusão Efetuada com Sucesso'],
        ['id' => 'BE', 'descricao' => 'Alteração Efetuada com Sucesso'],
        ['id' => 'BF', 'descricao' => 'Exclusão Efetuada com Sucesso'],
        ['id' => 'BG', 'descricao' => 'Agência/Conta Impedida Legalmente'],
        ['id' => 'B1', 'descricao' => 'Bloqueado Pendente de Autorização'],
        ['id' => 'B3', 'descricao' => 'Bloqueado pelo cliente'],
        ['id' => 'B4', 'descricao' => 'Bloqueado pela captura de título da cobrança'],
        ['id' => 'B8', 'descricao' => 'Bloqueado pela Validação de Tributos'],
        ['id' => 'CA', 'descricao' => 'Código de barras - Código do Banco Inválido'],
        ['id' => 'CB', 'descricao' => 'Código de barras - Código da Moeda Inválido'],
        ['id' => 'CC', 'descricao' => 'Código de barras - Dígito Verificador Geral Inválido'],
        ['id' => 'CD', 'descricao' => 'Código de barras - Valor do Título Inválido'],
        ['id' => 'CE', 'descricao' => 'Código de barras - Campo Livre Inválido'],
        ['id' => 'CF', 'descricao' => 'Valor do Documento/Principal/menor que o mínimo Inválido'],
        ['id' => 'CH', 'descricao' => 'Valor do Desconto Inválido'],
        ['id' => 'CI', 'descricao' => 'Valor de Mora Inválido'],
        ['id' => 'CJ', 'descricao' => 'Valor da Multa Inválido'],
        ['id' => 'CK', 'descricao' => 'Valor do IR Inválido'],
        ['id' => 'CL', 'descricao' => 'Valor do ISS Inválido'],
        ['id' => 'CG', 'descricao' => 'Valor do Abatimento inválido'],
        ['id' => 'CM', 'descricao' => 'Valor do IOF Inválido'],
        ['id' => 'CN', 'descricao' => 'Valor de Outras Deduções Inválido'],
        ['id' => 'CO', 'descricao' => 'Valor de Outros Acréscimos Inválido'],
        ['id' => 'HA', 'descricao' => 'Lote Não Aceito'],
        ['id' => 'HB', 'descricao' => 'Inscrição da Empresa Inválida para o Contrato'],
        ['id' => 'HC', 'descricao' => 'Convênio com a Empresa Inexistente/Inválido para o Contrato'],
        ['id' => 'HD', 'descricao' => 'Agência/Conta Corrente da Empresa Inexistente/Inválida para o Contrato'],
        ['id' => 'HE', 'descricao' => 'Tipo de Serviço Inválido para o Contrato'],
        ['id' => 'HF', 'descricao' => 'Conta Corrente da Empresa com Saldo Insuficiente'],
        ['id' => 'HG', 'descricao' => 'Lote de Serviço fora de Sequência'],
        ['id' => 'HH', 'descricao' => 'Lote de Serviço Inválido'],
        ['id' => 'HI', 'descricao' => 'Arquivo não aceito'],
        ['id' => 'HJ', 'descricao' => 'Tipo de Registro Inválido'],
        ['id' => 'HL', 'descricao' => 'Versão de Layout Inválida'],
        ['id' => 'HU', 'descricao' => 'Data / hora de Envio Inválida'],
        ['id' => 'IA', 'descricao' => 'Pagamento exclusive em Cartório.'],
        ['id' => 'IJ', 'descricao' => 'Competência ou Período de Referência ou Número da Parcela invalido'],
        ['id' => 'IL', 'descricao' => 'Código Pagamento / Receita não numérico ou com zeros'],
        ['id' => 'IM', 'descricao' => 'Município Invalido'],
        ['id' => 'IN', 'descricao' => 'Número Declaração Invalido'],
        ['id' => 'IO', 'descricao' => 'Número Etiqueta invalido'],
        ['id' => 'IP', 'descricao' => 'Número Notificação invalido'],
        ['id' => 'IQ', 'descricao' => 'Inscrição Estadual invalida'],
        ['id' => 'IR', 'descricao' => 'Dívida Ativa Invalida'],
        ['id' => 'IS', 'descricao' => 'Valor Honorários ou Outros Acréscimos invalido'],
        ['id' => 'IT', 'descricao' => 'Período Apuração invalido'],
        ['id' => 'IU', 'descricao' => 'Valor ou Percentual da Receita invalido'],
        ['id' => 'IV', 'descricao' => 'Número referência invalida'],
        ['id' => 'PA', 'descricao' => 'Pix não efetivado'],
        ['id' => 'PB', 'descricao' => 'Transação interrompida devido a erro no PSP do Recebedor'],
        ['id' => 'PC', 'descricao' => 'Número da conta transacional encerrada no PSP do Recebedor'],
        ['id' => 'PD', 'descricao' => 'Tipo incorreto para a conta transacional especificada'],
        ['id' => 'PE', 'descricao' => 'Tipo de transação não é suportado/autorizado na conta transacional especificada'],
        ['id' => 'PF', 'descricao' => 'CPF/CNPJ do usuário recebedor não é consistente com o titular da conta transacional especificada'],
        ['id' => 'PG', 'descricao' => 'CPF/CNPJ do usuário recebedor incorreto'],
        ['id' => 'PH', 'descricao' => 'Ordem rejeitada pelo PSP do Recebedor'],
        ['id' => 'PI', 'descricao' => 'ISPB do PSP do Pagador inválido ou inexistente'],
        ['id' => 'PJ', 'descricao' => 'Chave não cadastrada no DICT'],
        ['id' => 'PK', 'descricao' => 'Qr Code Invalido/Vencido'],
        ['id' => 'PL', 'descricao' => 'Forma De Iniciação Invalida'],
        ['id' => 'PM', 'descricao' => 'Chave inválida ou inválida para o Favorecido'],
        ['id' => 'PN', 'descricao' => 'Chave De Pagamento Não Informada'],
        ['id' => 'SC', 'descricao' => 'Validação parcial'],
        ['id' => 'TA', 'descricao' => 'Lote não Aceito - Totais do Lote com Diferença'],
        ['id' => 'W1', 'descricao' => 'Sequencial De Arq. Diverge Do Esperado'],
        ['id' => 'WW', 'descricao' => 'Duplicidade De Sequencial De Arquivo'],
        ['id' => 'XB', 'descricao' => 'Número de Inscrição do Contribuinte Inválido'],
        ['id' => 'XC', 'descricao' => 'Código do Pagamento ou Competência ou Número de Inscrição Inválido'],
        ['id' => 'XF', 'descricao' => 'Código do Pagamento, Competência não Numérico ou igual a zeros'],
        ['id' => 'YA', 'descricao' => 'Título não Encontrado'],
        ['id' => 'YB', 'descricao' => 'Identificação Registro Opcional Inválido'],
        ['id' => 'YC', 'descricao' => 'Código Padrão Inválido'],
        ['id' => 'YD', 'descricao' => 'Código de Ocorrência Inválido'],
        ['id' => 'YE', 'descricao' => 'Complemento de Ocorrência Inválido'],
        ['id' => 'YF', 'descricao' => 'Alegação já Informada'],
        ['id' => 'ZA', 'descricao' => 'Transferência Devolvida'],
        ['id' => 'ZB', 'descricao' => 'Transferência mesma titularidade não permitida'],
        ['id' => 'ZC', 'descricao' => 'Código pagamento Tributo inválido'],
        ['id' => 'ZD', 'descricao' => 'Competência Inválida'],
        ['id' => 'ZE', 'descricao' => 'Título Bloqueado na base'],
        ['id' => 'ZF', 'descricao' => 'Sistema em Contingência – Título com valor maior que referência'],
        ['id' => 'ZG', 'descricao' => 'Sistema em Contingência – Título vencido (pagamento de cobrança)'],
        ['id' => 'ZG', 'descricao' => 'Banco destino não Recebe DOC/Pix (pagamentos/transferências)'],
        ['id' => 'ZH', 'descricao' => 'Sistema em contingência - Título indexado'],
        ['id' => 'ZI', 'descricao' => 'Beneficiário divergente'],
        ['id' => 'ZJ', 'descricao' => 'Limite de pagamentos parciais excedido'],
        ['id' => 'ZK', 'descricao' => 'Título já liquidado'],
        ['id' => 'ZT', 'descricao' => 'Valor “outras entidades” inválido'],
        ['id' => 'ZU', 'descricao' => 'Sistema Origem Inválido'],
        ['id' => 'ZW', 'descricao' => 'Banco Destino não recebe DOC'],
        ['id' => 'ZX', 'descricao' => 'Banco Destino inoperante para DOC'],
        ['id' => 'ZY', 'descricao' => 'Código do Histórico de Crédito Invalido'],
        ['id' => 'ZV', 'descricao' => 'Autorização iniciada no Internet Banking'],
        ['id' => 'Z0', 'descricao' => 'Conta com bloqueio*'],
        ['id' => 'Z1', 'descricao' => 'Conta fechada. É necessário ativar a conta*'],
        ['id' => 'Z2', 'descricao' => 'Conta com movimento controlado*'],
        ['id' => 'Z3', 'descricao' => 'Conta cancelada*'],
        ['id' => 'Z4', 'descricao' => 'Registro inconsistente (Título)*'],
        ['id' => 'Z5', 'descricao' => 'Apresentação indevida (Título)*'],
        ['id' => 'Z6', 'descricao' => 'Dados do destinatário inválidos*'],
        ['id' => 'Z7', 'descricao' => 'Agência ou conta destinatária do crédito inválida*'],
        ['id' => 'Z8', 'descricao' => 'Divergência na titularidade*'],
        ['id' => 'Z9', 'descricao' => 'Conta destinatária do crédito encerrada*'],
        ['id' => '99', 'descricao' => 'Bloqueado Outros Motivos'],
    ];

    public static function getDescricao($codigo) {
        foreach (self::LISTA as $i => $ocorrencia) {
            if ($ocorrencia['id'] == $codigo) {
                return $ocorrencia['descricao'];
            }
        }

        return NULL;
    }

    public static function getRelacao($ocorrencias) {
        $ocorrencias = trim($ocorrencias);

        $relacao = [];

        while (!empty($ocorrencias)) {
            $ocorrencia = substr($ocorrencias, 0, 2);
            $ocorrencias = substr($ocorrencias, 2);

            if (empty($ocorrencia)) {
                break;
            }

            $descricao = self::getDescricao($ocorrencia);

            if (empty($descricao)) {
                $descricao = 'Ocorrência não identificada';
            }

            $relacao[] = $ocorrencia . ' - ' . $descricao;
        }

        return $relacao;
    }
}