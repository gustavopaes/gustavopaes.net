---
author: Gustavo Paes
title:  Evento click no iPad e iPhone
description: O evento click não funciona em iPad e iPod. O evento semelhante nesses aparelhos é o touchstart e touchend. Veja um exemplo em jQuery.
date: 2011-02-29 12:00pm
categories: blog, front-end
---

Descobri esses dias que o evento `click`, normal em navegadores Web tradicionais, não funciona em elementos que não sejam do tipo `a` (link), no iPad e iPhone. Ai fode, pensei eu.

Mas uma procura rápida e encontrei a maneira correta de contornar o _problema_. Esses aparelhos do tipo _touch_ da Apple possuem eventos que indicam o início e o fim do _dedo do cara na tela_.

Os eventos são: `touchstart` e `touchend`. Usando eles no jQuery, ficaria assim:

``` javascript
// versão do jQuery: >= 1.7
jQuery("body").on("click touchend", ".seletor", function() {
  alert("evento click");
});
```

Destaco que só é preciso usar o evento `touch` quando este for em algum elemento que não seja um link, como o `div`, por exemplo.

**Fonte e mais leitura, necessariamente na ordem:**
http://stackoverflow.com/questions/3038898/ipad-iphone-hover-problem-causes-the-user-to-double-click-a-link
http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariJSRef/SafariJSRef.pdf

