---
author: Gustavo Paes
title: Ordenar Array de Objetos no Javascript
description: Veja como ordenar arrays com objetos usando o método sort() do Javascript.
date: 2010-07-02 12:00pm
categories: blog, front-end, javascript
---

`Array` de objetos esta mais comum com o aumento no uso do [JSON](http://json.org/ "Introducing JSON"). Alguns problemas aparecem ao se usar um `array` com dados complexos, como por exemplo a ordenação.

A função `sort()` do Javascript não sabe ordenar um objeto justamente por esse poder ser diferente de seus _vizinhos_ e, principalmente, por não saber qual dado deve ser usado para a ordenação.

O programador deve então criar uma função que informe ao Javascript os dados que devem ser usados na comparação. Então, tendo como exemplo um array com os dados de usuários, iremos criar duas formas de ordenação: por idade e por nome.

``` javascript
var arr_usuarios = [
	{
		"nome": "Pedro",
		"idade": 18,
		"cidade": "São Paulo"
	},

	{
		"nome": "Carlos",
		"idade": 25,
		"cidade": "Barueri"
	},

	{
		"nome": "Ana",
		"idade": 21,
		"cidade": "Santos"
	}
];

// Ordena pelo nome do usuário
function byname(user_a, user_b) {
	return user_a.nome > user_b.nome;
}

// Ordena pela idade do usuário
function byage(user_a, user_b) {
	return user_a.idade > user_b.idade;
}

console.dir(arr_usuarios);
console.dir(arr_usuarios.sort(byname));
console.dir(arr_usuarios.sort(byage));
```

Recomendo digitar o código acima no [Firebug](http://getfirebug.com/) ou no console do [Chrome](http://www.google.com/chrome/). Mais informações sobre `array` no Javascript, leia a [documentação da W3Schools](http://www.w3schools.com/jsref/jsref_obj_array.asp "Javascript Array Object: W3Schools").

Abaixo três imagens com o resultado de cada um dos `console.dir()` do código.

[![](//gustavopaes.net/images/posts/2010/07/array-original.gif)](//gustavopaes.net/images/posts/2010/07/array-original.gif "Array sem ordenação")
[![](//gustavopaes.net/images/posts/2010/07/array-ordenado-por-nome.gif)](//gustavopaes.net/images/posts/2010/07/array-ordenado-por-nome.gif "Array ordenado pelo nome")
[![](//gustavopaes.net/images/posts/2010/07/array-ordenado-por-idade.gif)](//gustavopaes.net/images/posts/2010/07/array-ordenado-por-idade.gif "Array ordenado pela idade")

Perceba que, para alterar o tipo de ordenação &#8212; crescente ou decrescente &#8212; basta alterar o símbolo de comparação. Dessa forma, para ordenar por idade, de forma decrescente, a função ficaria da seguinte forma:

``` javascript
// Ordena pela idade do usuário, de forma decrescente
function byage(user_a, user_b) {
	return user_a.idade < user_b.idade;
}
```

O mesmo vale para outros tipos de dado, como `String` ou até mesmo `Date` ou `Time`.

