---
layout: post
author: Gustavo Paes
title:  Adicionando bloco de comentários do Facebook
description: Veja como facilitar o envio de mensagens de uma página par outra usando o conceito da variável "flash", do Rails.
date: 2010-05-08 12:00pm
categories: blog, programação, rails
---

_[atualizado em: 13/01/2010]_

Adicionar um módulo de comentários no site já foi tarefa difícil. Hoje em dia, grandes portais estão deixando de lado o desenvolvimento interno e partindo para as APIs abertas.

Um exemplo de API de comentários aberta é a do Facebook. Ela une a facilidade de uso &#8212; mais abaixo o código para inserir o bloco em seu site &#8212; com a capacidade de usar a base de dados com milhões de usuários cadastrados em todo o mundo.

## As duas formas para utilizar os comentários do Facebook

O Facebook permite incluir o bloco de comentários de duas formas:

1. utilizando iframe;
2. utilizando FBML (uma espécie de markup do Facebook).

O resultado será igual, seja usando diretamente o iframe, seja usando o FBML, que na realidade irá montar um iframe igual à primeira opção.

A recomendação do Facebook é que seja utilizado o FBML na maioria dos casos. Além de ser mais rápido (por ser assíncrono), permite também melhor manipulação. Portanto é essa forma que descreverei abaixo.

## Incluindo o bloco de comentários usando o FBML

Para que o FBML funcione, é preciso incluir um script do Facebook (http://connect.facebook.net/pt_BR/all.js). Isso pode ser feito da forma padrão:

    <head>
      ...    
      <script type="text/javascript" src="http://connect.facebook.net/pt_BR/all.js"></script>
      ...
    </head>

Depois, basta adicionar a tag `fb:comments`. É através dos parâmetros dessa tag que o script adicionado anteriormente irá criar o bloco de comentários. Os parâmetros disponíveis podem ser encontrados na [documentação do FBML](http://developers.facebook.com/docs/reference/fbml/comments/).

Você pode copiar o código que o próprio Facebook gera na seguinte página: [http://developers.facebook.com/docs/reference/plugins/comments](http://developers.facebook.com/docs/reference/plugins/comments)

Para deixar funcional basta usar o parâmetro `xid`, que deve conter um valor único, ou seja, de preferência a URL encodada.

No fim da página, ainda dentro da tag body, é preciso chamar a função init que irá montar o bloco de comentários dentro do markup `fb:comments`:

    <div id="fb-root"></div>
    <script type="text/javascript">
    FB.init({
      appId: "APP ID",
      status: true,
      cookie: true,
      xfbml: true
    });
    </script>

O APP ID deve ser trocado pelo APP ID da sua aplicação. Para conseguir um, acesse: [http://developers.facebook.com/setup/](http://developers.facebook.com/setup/)

Feito isso, o bloco de comentários já deve funcionar, como na imagem abaixo.

![](http://gustavopaes.net/images/posts/2010/05/bloco-de-comentario.gif "Bloco de comentários usando APP do Facebook")

## Personalizando o bloco

O Facebook permite mudanças no template através de CSS. Você pode adicionar um CSS externo passando a URL dele através do parâmetro `css`.

    <fb:comments xid="http://www.seusite.com.br/titulo-da-materia.html" css="http://www.seusite.com.br/css-comentarios.css"></fb:comments>

Para melhorar o desempenho o Facebook cacheia todos os CSS. Ou seja, quando você realizar alguma mudança no arquivo, atualize a URL do parâmetro adicionando algum timestamp ou versão, por exemplo, http://www.seusite.com.br/css-comentarios.css?v3. Só assim o Facebook irá usar a versão mais recente.

Mais informações sobre o FBML, acesse a [documentação oficial](http://developers.facebook.com/docs/reference/fbml/).

