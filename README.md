## Laravel - Facilita

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/laravel-facilita.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/laravel-facilita)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Envia as conversões para o Facilita

## Instalação

```bash
composer require agenciafmd/laravel-facilita:dev-master
```

Colocamos esta url no nosso .env

```dotenv
FACILITA_WEBHOOK=https://xxxxxxxxxxxxxxxx.api.facilitavendas.com/public/trackerform
FACILITA_CUSTOM_SELECTOR: idformulario
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
use Agenciafmd\Facilita\Jobs\SendConversionsToFacilitaWebhook;
use Illuminate\Support\Facades\Cookie;

$data['email'] = 'irineu@fmd.ag';
$data['name'] = 'Irineu Junior';
$data['phone'] = '(99) 99999-9999';
$data['mobile'] = '(99) 99999-9999';
$data['cpf'] = '999.999.999-99';
$data['obs'] = 'teste FMD';
$data['property'] = 'teste FMD';
$data['message'] = 'Mensagem de teste F&MD';
$data['facilita_custom_page'] = 'Título da página';
$data['facilita_custom_url'] = 'http://www.urldapagina.com.br';
$data['facilita_custom_selector'] = 'idformulario';

SendConversionsToFacilitaWebhook::dispatch($data)
    ->delay(5)
    ->onQueue('low');
```

Note que no nosso exemplo, enviamos o job para a fila **low**.

Certifique-se de estar rodando no seu queue:work esteja semelhante ao abaixo.

```shell
php artisan queue:work --tries=3 --delay=5 --timeout=60 --queue=high,default,low
```