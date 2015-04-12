---
author: Gustavo Paes
title: Resolvendo erro "Cannot modify header information" no wordpress
description: Esse erro pode possuir diversas causas. Uma delas é salvar arquivos PHP com a codificação UTF-8 with BOM. Veja como encontrar e resolver o problema.
date: 2015-04-12 12:00pm
categories: blog, wordpress, php
---

Se você está obtendo a mensagem de erro abaixo ao tentar acessar sua conta administrativa no Wordpress, é possível que a causa do problema seja um erro no arquivo `wp-config.php` ou qualquer outro que você tenha editado alguma informação.


    Warning: Cannot modify header information - headers already sent by (output started at /home/xxxxxx/public_html/wordpress/wp-config.php:1) in /home/xxxxxx/public_html/wordpress/wp-includes/pluggable.php on line 881


A causa, no meu caso, é que o arquivo `wp-config.php` foi salvo com a codificação **UTF-8 with BOM**. De forma resumida, o _with BOM_ adiciona ao arquivo uma pequena sequência de caracteres que não permite ao PHP aplicar ao `header` o _redirect_ necessário, gerando a mensagem de erro.

Para solucionar o problema, basta salvar o arquivo novamente, com codificação **UTF-8**.

## Procurando por arquivos com codificação _UTF-8 with BOM_

Se você salvou o arquivo `wp-config.php` na codificação correta e ainda assim o problema persiste, pode ser que algum outro arquivo tenha sido salvo de forma errada.

Para descobrir isso, no terminar do seu servidor, onde os arquivos do Wordpress estão, digite o comando abaixo:

    grep -rlI $'\xEF\xBB\xBF' .

O resultado do comando será os arquivos que estão salvos com `BOM`. Se nenhum arquivo for retornado, então você está com outro tipo de problema.

Fonte: http://stackoverflow.com/a/2858757
