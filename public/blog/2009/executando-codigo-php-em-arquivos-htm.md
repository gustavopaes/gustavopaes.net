---
layout: post
author: Gustavo Paes
title:  Executando código PHP em arquivos .htm
description: Aprenda a configurar seu site para que arquivos HTML tenham os códigos PHP interpretados.
date: 2009-11-04 12:00pm
categories: blog, apache, php
---

Supondo que você tenha um site todo em `.htm` puro e quer implementar alguns códigos PHP nas páginas. Você teria que sair renomeando todos os arquivos para `.php` para que o código fosse interpretado.

A linha abaixo resolve isso permitindo que arquivos `.htm / .html` tenham também os códigos PHP interpretados. Para funcionar, é preciso que o servidor seja **linux** e que ele permita configurações através do arquivo **.htaccess**

1. Crie um arquivo &#8212; caso ele não exista &#8212; `.htaccess` na raíz do seu site ou no diretório onde ficam os arquivos HTML;

2. Coloque o seguinte código no arquivo

    
    AddType application/x-httpd-php .html .htm
    

Pronto, agora seus arquivos `.html` e `.htm` irão interpretar PHP.

