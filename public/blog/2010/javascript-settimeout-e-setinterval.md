---
author: Gustavo Paes
title: Javascript: setTimeout e setInterval
description: Veja como controlar as execuções de tempos em tempos usando as funções setTimeout() e setInterval().
date: 2010-12-17 12:00pm
categories: blog, front-end, javascript
---

As duas funções (`setTimeout()` e `setInterval()`) permitem a execução de códigos de tempos em tempos. A diferença entre as duas está na repetição. Enquanto o `setTimeout` executa o código apenas uma vez após um determinado _delay_, o `setInterval` executa _indefinidamente_ de tempos em tempos.

Vejamos um exemplo das duas.

``` html
<div id="timeout"></div>
<hr>
<div id="interval"></div>
<script type="text/javascript">
function append(el) {
  var date = new Date();
  var txt  = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
  document.getElementById(el).innerHTML += txt + "<br>";
}

setTimeout("append(\"timeout\")", 1000);
setInterval("append(\"interval\")", 1000);
</script>
```

O código acima é um **relógio em javascript**, criado com o `setInterval`. O `setTimeout` imprime apenas um resultado.

O **primeiro parâmetro deve ser a função** que será executada e o **segundo parâmetro deve ser o tempo** (em milissegundos) de _delay_ entre uma execução e outra (ou apenas da primeira execução, no caso do `setTimeout`).

O que você vai ver no navegador é algo como a imagem abaixo.

<img src="http://gustavopaes.net/images/posts/2010/12/setTimeout_setInteval.gif" alt="setTimeout e setInterval" title="setTimeout e setInterval" width="369" height="152" class="alignnone size-full wp-image-460" />

## Formas de chamada

Ambas funções podem receber uma `string`, como no exemplo anterior, ou objetos e referências de funções. Por exemplo:

``` javascript
// Passando funções para execução
setTimeout(function() {
  var date = new Date();
  document.getElementById("timeout").innerHTML += "XXX";
}, 1000);

// Passando referências
setTimeout(nomeFuncao, 1000);
```

O grande problema em passar funções por referência é a impossibilidade de passar parâmetros para essa função. Uma forma de contornar esse problema é passar uma simples função anônima chamando a função desejada:

``` javascript
// Passando parâmetros
setTimeout(function() {
  nomeFuncao(param1, param2, param3);
}, 1000);
```

## Interrompendo os processos

Em determinados casos você pode querer interromper a próxima execução do `setTimeout` ou do `setInterval` Para isso, existem duas funções: `clearTimeout` e `clearInterval`.

Para funcionar é preciso passar a essas duas funções _clear_ o código do evento. Para obter esse código, quando você inicializar um `setTimeout` ou `setInterval`, armazene os valores em uma variável:

``` javascript
var interval = setInterval(function() {
  nomeFuncao(param1, param2, param3);
}, 5000);

// Interrompendo o Interval
clearInterval(interval);
```

## Conclusão

As duas funções são bastante úteis em sites com conteúdo carregados via Ajax. É com elas, por exemplo, que o Twitter atualiza os Tweets a cada 5 segundos ou o Facebook atualiza o mural em um tempo maior, sem dar o refresh nas páginas.

A recomendação, entretanto é **evitar ao máximo o `setInterval`**. Embora pareça mais úteis que o `setTimeout`, em determinadas situações você acaba perdendo o controle das execuções. Por exemplo, se houver um erro durante a execução da função, você não conseguirá atrasar a próxima chamada e isso pode gerar erros e fazer o navegador consumir mais recursos do que o necessário.

Portanto, a dica é: use somente `setTimeout` e dentro da própria função de execução chame novamente o `setTimeout`, criando o efeito do `setInterval`.

``` html
<div id="timeout"></div>
<script type="text/javascript">
function append(el) {
  var date = new Date();
  var txt  = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
  document.getElementById(el).innerHTML += txt + "<br>";
  // "agenda" novamente para o próximo segundo
  setTimeout(function() { append("timeout"); }, 1000);
}

append("timeout");</script>
```

## CronJS

Em projetos com diversos _jobs_ rodando sob `setTimeout / setIntervals`, é necessário possuir um controle maior sobre eles. Para isso, criei uma lib onde é possível reusar os _jobs_, parar e reiniciar. Além disso é possível ter uma visão de todos as definições de _jobs_ definidas.
https://github.com/gustavopaes/CronJS

