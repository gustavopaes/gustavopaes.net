---
author: Gustavo Paes
title: CronJS
description: Lib para gerenciar setTimeout() e setInterval().
date: 2012-08-13 12:00pm
categories: blog, javascript
---

[**CronJS**](https://github.com/gustavopaes/CronJS "CronJS: Gerenciamento de setTimeout() e setInterval()") é uma **lib js** que controla ações de intervalos de tempo. Com ela fica mais fácil interpretar e gerenciar os intervalos de tempo de seu código.

## `every`

`every()` é um método que permite definir um código a ser **executado sempre**, a cada período de tempo.

``` javascript
  execute.every("30 seconds", function() {
    console.log("Se passaram 30 segundos.");
  });
```

## `after`

`after()` é o método que permite definir um código a ser **executado apenas uma vez**, após um período de tempo.

``` javascript
execute.after("30 seconds", function() {
  console.log("Depois dessa, nunca mais.");
});
```

## `stop`

O método `stop()` permite que um _cron_ registrado anteriormente seja parado. Para usá-lo é necessário guardar a instância da criação do _cron_ em uma variável:

``` javascript
var my_cron = execute.after("30 seconds", function() {
  console.log("Depois dessa, nunca mais.");
});

my_cron.stop();
```

**Importante:** o `stop()` não funciona como _pause_. Uma vez aplicado em um _cron_, não será possível reiniciar a contagem do ponto em que parou.

## `play`

De uso semelhante ao `stop()`, o método `play()` reinicia um cron. Dessa forma é possível reutilizar tanto o intervalo de tempo `every()`, como o `after()`

``` javascript
  my_cron.play();
```

**Importante:** o `play()` irá funcionar apenas se o cron estiver parado e, quando começar, será da contagem inicial.

## Definições de tempo

CronJS reconhece as seguintes definições de tempo:

<ul><li>XX milliseconds (default)</li><li>XX seconds</li><li>XX minutes</li><li>XX hours</li><li>XX days</li></ul>