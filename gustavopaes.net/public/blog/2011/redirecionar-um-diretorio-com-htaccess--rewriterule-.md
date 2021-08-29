---
layout: post
author: Gustavo Paes
title:  Redirecionar um diretório com .htaccess (RewriteRule)
description: Veja como usar o arquivo .htaccess e a regra RewriteRule para redirecionar todos os arquivos de um diretório antigo para o novo.
date: 2011-03-31 12:00pm
categories: blog, linux, webservice
---

Vamos supor o seguinte cenário: você tem um site com um diretório **books/** e dentro dele diversos arquivos, todos indexados pelo google e linkados em dezenas de áreas do seu site e outros sites.

Mas **books** não é um bom nome para obter um bom resultado de busca no Brasil. O ideal seria **livros**. Você decide simplesmente renomear e pronto, problema resolvido. Não! Pior, você ganhou um grande problema. Todos os links e indexação serão perdidos e ninguém mais conseguirá chegar de forma simples e direta nas páginas.

O que fazer então para corrigir os links quebrados? Usar o arquivo `.htaccess` para redirecionar os usuários que chegarem pelos antigos links para a nova url.

O arquivo `.htaccess` permite que sejam (re)definidas algumas configurações sem que seja necessário a mudança no arquivo principal de configuração do Apache e nem que seja necessário um restart do sistema.

Nem todas as hospedagens permitem isso, mas a maioria sim. É importante que a hospedagem seja **linux** também.

Crie o arquivo **.htaccess** no antigo **books** com o seguinte conteúdo:

    RewriteEngine OnRewriteBase /booksRewriteRule   ^(.*?)$  /livros/$1 [R=301,L]

O código acima irá redirecionar os usuários que acessarem a seguinte url, por exemplo:
www.seusite.com.br/books/os-grandes-empreendedores.html -> /livros/os-grandes-empreendedores.html

Simples e eficiente (há alguns contras, mas não deixa de ser eficiente).
