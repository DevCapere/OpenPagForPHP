# OpenPagForPHP 

Este projeto é baseado no [QuilhaSoft/OpenCnabPHP](https://github.com/QuilhaSoft/OpenCnabPHP)

## Utilizando docker:
Esteja na raiz do projeto e execute:
```shell
docker-compose up -d
```
## Instalando via composer:


Adicione `"devcapere/openpagforphp": "dev-master"` ao seu composer.json e rode update ou install

## Status de desenvolvimento
<table>
    <tr>
        <td>Banco</td>
        <td>Modelo</td>
        <td>Layout</td>
        <td>Remessa</td>
        <td>Retorno </td>
    </tr>
    <tr>
        <td>Santander</td>
        <td>Cnab240</td>
        <td>060</td>
        <td>Desenvolvimento</td>
        <td>Beta</td>
    </tr>
    <tr>
        <td>Itaú</td>
        <td>Cnab240</td>
        <td>080</td>
        <td>Em desenvolvimento (header/lote/TED A+B/Boleto J+J52/PIX B /trailer)</td>
        <td>Em desenvolvimento (L080 — TED A+B / Boleto J+J52)</td>
    </tr>
</table>

## PIX Transferência (Itaú SisPag — forma 45)

Segmento B (`Registro3BPix`): tipo de chave (Nota 37) + chave PIX.

| Tipo Itaú | Chave no arquivo |
|-----------|------------------|
| `01` telefone | **somente dígitos** (sem `+`, parênteses, hífen) |
| `02` e-mail | texto informado |
| `03` CPF/CNPJ | **somente dígitos** (sem máscara `000.000.000-00` / `00.000.000/0000-00`) |
| `04` aleatória | texto informado (UUID etc.) |

Defesa na lib: se a chave parecer CPF/CNPJ mascarado e o tipo vier inconsistente, a pontuação também é removida — evita rejeição no DICT/SisPag.

Relacionado Capere: **RN-36 / RN-36b** (`ItauCnabRemessaService`) — mesma regra na origem da remessa.

## PIX QR-CODE (Itaú SisPag — forma 47)

Segmento **J** + **J-52 PIX** (`Registro3J52Pix`) — não reutilizar J-52 de boleto.

| Campo (J-52 PIX) | Pos. | Conteúdo |
|------------------|------|----------|
| Chave de pagamento | 132–208 | QR estático: chave PIX · dinâmico: URL **sem** `https://` (Nota 41) |
| TXID | 209–240 | Identificador do QR (Nota 38; obrigatório no dinâmico) |

No Segmento J, campos de “código de barras” vão **zerados** (Nota 18). Hook: `$lote->inserirPixQr([...])`.

Relacionado Capere: **SUS-4127** / RN-4127-*.

## Concessionárias / arrecadação (Itaú SisPag — forma 13)

Segmento **O** (`Registro3O`) — código de barras **X(48)** = óptico FEBRABAN **44** + 4 espaços (linha 48 é convertida; início `8`).

Hook: `$lote->inserirConcessionaria([...])` com `forma_pagamento => '13'`, `versao_layout => '030'`.

Relacionado Capere: **SUS-4127** / **SUS-4230** / RN-4127-4.

## Licença

* MIT License
