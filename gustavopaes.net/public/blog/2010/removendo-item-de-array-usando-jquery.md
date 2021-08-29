---
author: Gustavo Paes
title: Removendo item de array usando jQuery
description: Simples código, utilizando jQuery, para remover item intermediário de array
date: 2010-03-27 12:00pm
categories: blog, front-end, javascript, jquery
---

O código abaixo foi criado para a seguinte finalidade: remover um ítem, com determinado valor, de um `array` simples. Ou seja, ele não remove um item através do índice, mas sim através do conteúdo.

``` javascript
arr = [1, 2, 3, 4, 5] // array inicial
var removeItem = 2;   // item do array que devera ser removido

arr = jQuery.grep(arr, function(value)) {
	return value != removeItem;
});

// new array
// [1, 3, 4, 5]
```

O método [`grep`](http://api.jquery.com/jQuery.grep/ "jQuery.grep() - jQuery API") do [jQuery](http://jquery.com/ "jQuery - Javascript Library") percorre todos os índices de um `array` e retorna aqueles que você deseja.

Os valores retornados formarão um segundo `array`, neste caso, um `array` sem o item indesejado.

Nada impede que você adicione esse código em uma função e _importe_ ela para seu jQuery, criando algo como `jQuery.removeArrayItem()`.

