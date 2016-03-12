---
layout: post
author: Gustavo Paes
title:  Firebug para Internet Explorer
description: Use o IE Developer Toolbar para debugar markup e CSS no Internet Explorer. Ele é o Firebug para o Internet Explorer.
date: 2007-02-22 12:00pm
image: http://wim.com
categories: blog, front-end, browser
---
O Firefox é pesado, consome 500 MB de sua concorrida memória mas, infelizmente, é muito bom para desenvolvimento Web, principalmente devido ao plugin Firebug.

Sem esse plugin estaríamos executando muitos `alert` e `document.write` para debugar e ainda dependeríamos de programas como o [Fiddler 2](http://www.fiddler2.com/fiddler2/) para observar os requests realizados na página.

Tudo isso é bom e ajuda muito no desenvolvimento. Mas, infelizmente desenvolvemos também para o Internet Explorer e, não tão raras exceções, o site não funciona com deveria nesse navegador.

E como debugar sem o Firebug? Instalando o [IE Developer Toolbar](http://www.microsoft.com/downloads/en/details.aspx?FamilyID=95e06cbe-4940-4218-b75d-b8856fced535).

[![Working with HTML and CSS on IE Developer Toolbar](//gustavopaes.net/images/2007_firebug-para-internet-explorer.png "Working with HTML and CSS on IE Developer Toolbar")](http://blogs.msdn.com/b/ie/archive/2008/09/03/developer-tools-in-internet-explorer-8-beta-2.aspx)

A partir do Internet Explorer 8 o IE Dev Toolbar vem por padrão e para ativar na página basta pressionar o F12. Não é tão bom quanto o Firebug mas é melhor do que nada. Não é possível obter os requests da página, mas para isso podemos verificar no próprio Firefox.

O importante do IE Dev Toolbar é a visualização do markup final da página e modificação in-loco do CSS.