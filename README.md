# OpenPagForPHP 

Este projeto é baseado no [QuilhaSoft/OpenCnabPHP](https://github.com/QuilhaSoft/OpenCnabPHP)

<li>
Um arquivo remessaAbstract cuida das questões sobre arquivos em geral.
</li>
<li>
A classe para cada Remessa herda remssaAbstract e seta o nome do banco que é a pasta para os layouts personalizados
</li>
<li>
RegistroAbstract cuida de metodos unicos para qualquer registro de qualquer layout,
</li>
<li>
Uma classe genérico herda registroAbstract e implementa setters e getters comuns ao registro de um determinado layout
</li>
e por fim uma classe registro herda de genérico e define o layout que sera usado e se por ventura for necessario sobrepõe ou implementa novos getters e setters do arquivo generico.
</li><br>

## Utilizando docker:
Esteja na raiz do projeto e execute:
```shell
docker-compose up -d
```
## Instalando via composer:


Adicione "devcapere/openpagforphp": "dev-master" ao seu composer.json e rode update ou install

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
</table>


## Licença

* MIT License
