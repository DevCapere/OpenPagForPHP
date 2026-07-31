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

## Licença

* MIT License
