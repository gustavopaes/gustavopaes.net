---
author: Gustavo Paes
title:  Adicionando códigos em uma função já declarada
description: Veja como adicionar códigos em uma função que já existe sem ter que criar uma outra função.
date: 2011-08-04 12:00pm
categories: blog, javascript
---

As vezes é preciso adicionar novos códigos à funções já existentes. Por exemplo, adicionar uma nova regra à uma função callback que já pode existir de outro script.

A solução é "concatenar" à função antiga seu novo código. Para isso é preciso guardar a versão antiga em uma variável temporária e redeclarar a função desejada com o seu novo código mais o código antigo.

O código abaixo faz exatamente isso, mas de uma forma mais limpa.

``` javascript
oldFunction = (function(temp) {
  return function() {
    if(typeof temp != "undefined")
      temp();
      // your new code here...
  }
})(oldFunction);
```

Onde o `oldFunction` é o nome da função que já existe. Bom proveito.

