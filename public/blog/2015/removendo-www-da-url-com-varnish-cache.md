---
author: Gustavo Paes
title: Removendo o www da url com Varnish Cache
description: Permitindo que o seu domínio responda com o www e sem ele, você pode duplicar conteúdo no Google e dividir relatórios de audiência. Veja como remover (ou sempre foçar) o www de sua URL e resolver esses problemas.
date: 2015-04-12 02:00pm
categories: blog, wordpress, php
---

Acessando **www.gustavopaes.net** você será automaticamente redirecionado para **gustavopaes.net**. Isso é feito para evitar que o conteúdo seja indexado duplicado ou então que a audiência no Google Analytics seja dividida em dois relatórios: um para cada domínio.

Uma vez que o _www_ não é necessário para se resolver um domínio, você pode forçar que seu site seja acessível sem ele, e apenas sem, ou com ele, e apenas com. Isso é uma escolha sua. A maioria dos sites remove o _www_ para facilitar a divulgação.

Independente da escolha, basta fazer um _redirect_ em seu servidor, apontando qualquer acesso diferente do que você definiu para a opção correta, com o código _HTTP 301 - Permanent Redirect_.

## Fazendo redirect com Varnish

O código abaixo deve ser adicionado no arquivo de configuração _default.vcl_. Lembre-se de trocar para o seu domínio na linha 3.


### Removendo o _www_

    sub vcl_recv {
        # Entra na regra apenas se o request origem estiver com www no início
        if ( req.http.host ~ "^www.seudominio.com.br" ) {
          # Remove o www da URL
          set req.http.host = regsub(req.http.host, "^www\.(.*)$", "\1");
          error 750 "http://" + req.http.host + req.url;
        }

        # Continuação do seu vcl_recv 
        # ...
    }

    sub vcl_error {
      if( obj.status == 750 ) {
        set obj.http.Location = obj.response;
        set obj.status = 301;
        return(deliver);
      }

      # Continuação do seu vcl_error
      # ...
    }

### Adicionando o _www_

    sub vcl_recv {
        # Entra na regra apenas se o request origem estiver com www no início
        if ( req.http.host == "seudominio.com.br" ) {
          # Remove o www da URL
          set req.http.host = regsub(req.http.host, "(.*)$", "www.\1");
          error 750 "http://" + req.http.host + req.url;
        }

        # Continuação do seu vcl_recv 
        # ...
    }

    sub vcl_error {
      if( obj.status == 750 ) {
        set obj.http.Location = obj.response;
        set obj.status = 301;
        return(deliver);
      }

      # Continuação do seu vcl_error
      # ...
    }

Depois de feita a alteração, execute o `reload` do varnish usando o comando abaixo:
    
    service varnish reload

O comando faz o varnish usar as novas configurações sem reiniciá-lo. Se houver erro na configuração ele irá alertar e não fará a modificação. Dessa forma você não fica com indisponibilidade.