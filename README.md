## Laravel - Facilita

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/laravel-facilita.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/laravel-facilita)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Envia as conversões para o Facilita

## Acessar o Facilita
**No menu** posicione seu mouse acima de marketing para ativar o hover do dropdown.
Apos o hover, clique em **Listar Integrações**

![Perfil > Integrações](https://github.com/agenciafmd/laravel-facilita/raw/master/docs/print-1.jpg "Perfil > Integrações")

Essa proxima parte varia de Produto para Produto, porem nesse exemplo só tinha 2 integrações ativas, e como não estamos integrando com o facebook, selecionamos a opção de Captura de formulario

Clique em **Gerenciar** e **não clique** em outras opções que o cta seja ativar, para não ativar campanha sem querer 

![Campanha > Integrações](https://github.com/agenciafmd/laravel-facilita/raw/master/docs/print-2.jpg "Campanha > Integrações")

Após listar todas as Integrações da campanha de "captura de formularios", vai estar sendo listados todas as integrações, a nossa no caso é essa que o **FormId esta riscado de Verde**

o seu FormId estara nessa posição também, que no seu .env sera o valor de ```FACILITA_CUSTOM_SELECTOR=```

![Integra > Integrações](https://github.com/agenciafmd/laravel-facilita/raw/master/docs/print-3.jpg "Integra > Integrações")

e essa opção **API para desenvolveres** que esta circulada ira abrir esse modal

![Modal > Integrações](https://github.com/agenciafmd/laravel-facilita/raw/master/docs/print-4.jpg "Modal > Integrações")
 
os campos de **URL e metodo** serão dos valores para o .env

## Instalação

```bash
composer require agenciafmd/laravel-facilita:dev-master
```

Colocamos esta url no nosso .env

```dotenv
FACILITA_WEBHOOK=https://xxxxxxxxxxxxxxxx.api.facilitavendas.com/public/trackerform
FACILITA_CUSTOM_SELECTOR=idformulario
```

## Uso

Envie os campos no formato de array para o SendConversionsToFacilita.

Para que o processo funcione pelos **jobs**, é preciso passar os valores dos cookies conforme mostrado abaixo.

Envio dos campos obrigatórios:

facilita_custom_page: Título da página
facilita_custom_url: http://www.urldapagina.com.br
facilita_custom_selector: idformulario

Envio dos campos com informações do Lead:
name
email
phone
mobile
cpf
obs
message

Considerações:

O id do formulário (facilita_custom_selector) não pode ser alterado, caso contrário será necessário configurar novamente o mapeamento dos campos.

```php
use Agenciafmd\Facilita\Jobs\SendConversionsToFacilita;
use Agenciafmd\Facilita\Jobs\SendConversionsToFacilitaWebhook;
use Illuminate\Support\Facades\Cookie;

//campos não obrigatorios (igual ao print do modal)
$data['email'] = 'irineu@fmd.ag';
$data['name'] = 'Irineu Junior';
$data['phone'] = '(99) 99999-9999';
$data['mobile'] = '(99) 99999-9999';
$data['cpf'] = '999.999.999-99';
$data['obs'] = 'teste FMD';
$data['property'] = 'teste FMD';
$data['message'] = 'Mensagem de teste F&MD';
//Fim campos não obrigatorios

//Campos obrigatorios
$data['facilita_custom_page'] = 'Título da página';
$data['facilita_custom_url'] = 'http://www.urldapagina.com.br';
$data['facilita_custom_selector'] = 'idformulario';
//Fim campos obrigatorios

SendConversionsToFacilita::dispatch($data)
    ->delay(5)
    ->onQueue('low');
```

Note que no nosso exemplo, enviamos o job para a fila **low**.

Certifique-se de estar rodando no seu queue:work esteja semelhante ao abaixo.

```shell
php artisan queue:work --tries=3 --delay=5 --timeout=60 --queue=high,default,low
```