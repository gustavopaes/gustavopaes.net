---
layout: post
author: Gustavo Paes
title: Criando CSS específico para impressão
description: Criar um CSS específico para impressão é simples e evita aborrecimento de seus usuários. Veja no artigo do Klaus como permitir a impressão correta do seu site.
date: 2010-11-21 12:00pm
categories: blog, front-end, css
---

Em 2007 havia escrito um artigo sobre CSS para impressão. Faz tempo. E hoje o artigo não existe mais, porém é um dos mais visitados no meu blog &#8212; dá página 404 obviamente.

Pensei em reescrevê-lo, mas nas minhas pesquisas acabei encontrando um post muito bom do [Klaus](http://blog.klaus.pro.br/). Para não escrever a mesma coisa, peço que você vá lá ler. Abrange mais do que o necessário para a maioria.

[CSS para impressão, de Klaus Paiva.](http://blog.klaus.pro.br/2007/ler/css-para-impressao/index.html)

## Quebrando a linha na tag `pre`

Se o seu blog fala de programação, provavelmente você utiliza a tag `pre` para exibir corretamente os códigos. Uma característica peculiar dessa tag é que ela não quebra a linha quando o limite da largura é alcançado.

Isso é bom na _web_, pois um código as vezes não pode ser quebrado em duas linhas. Mas na impressão você vai acabar perdendo o código que extrapolou a largura. Para resolver isso, use as regras CSS abaixo, **em seu arquivo CSS de impressão**, para forçar a quebra de linha da tag `pre`:

    pre {
      /* css-3 */
      white-space: pre-wrap;
      
      /* Mozilla, since 1999 */
      white-space: -moz-pre-wrap !important;
      
      /* Opera 4-6 */
      white-space: -pre-wrap;
      
      /* Opera 7 */
      white-space: -o-pre-wrap;
      
      /* Internet Explorer 5.5+ */
      word-wrap: break-word;
    }

