---
author: Gustavo Paes
title:  innerHTML ou createElement: qual o melhor?
description: Qual o mais rápido: innerHTML ou o createElement com appendChild? Os testes mostram que o innerHTML pode ser muito mais rápido, mas cuidado, se usar errado pode deixar seu script lento e ineficiente.
date: 2011-07-09 12:00pm
categories: blog, javascript, front-end
---

É aquela história história de sempre: depende. Fiz <a title="createElement vs innerHTML" href="http://jsperf.com/feed-with-innerhtml-or-createelement/2" target="_blank">alguns testes</a> no site <a title="jsperf" href="http://jsperf.com" target="_blank">jsperf</a> para descobrir qual a melhor versão.

A conclusão é a seguinte:
O `innerHTML` é muito mais rápido quando se utiliza apenas uma vez, ou seja, quando se concatena todo o conteúdo que será criado em uma `string` e só depois usa o `innerHTML`.

Se isso não for possível, com toda certeza, utilize o `createElement` com o `appendChild`, que são muito mais eficientes em _loop_ do que o `innerHTML`

## Guardar referências em variáveis

O teste serviu também para mostrar o quão importante é guardar referências de elementos HTML em uma variável para evitar o processamento do DOM novamente.

Por exemplo, dentro de um `for` para que utilizar sempre o `getElementById("meu-id")` se é possível fazer isso apenas uma vez fora do `for` guardando a referência em uma variável.

``` javascript
// modo errado
for (letter in items)
  document.getElementById("my-list").appendChild( ... );

// modo certo
var elem = document.getElementById("my-list");
  for (letter in items)
    elem.appendChild( ... );
```

Essa pequena mudança traz um ganho considerável no processamento do seu script.

