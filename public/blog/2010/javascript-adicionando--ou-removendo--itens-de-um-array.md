---
author: Gustavo Paes
title: Javascript: Adicionando (ou removendo) itens de um Array
description: Veja como trabalhar com itens intermediários de um array usando a função splice().
date: 2010-07-05 12:00pm
categories: blog, front-end, javascript
---

No texto anterior mostrei como [ordenar um array de objetos](http://gustavopaes.net/blog/2010/ordenar-array-de-objetos-no-javascript.html). Nesse, falando ainda de arrays, irei mostrar como adicionar ou remover um item de um array, esteja ele no início, no fim ou no meio.

## No início ou no fim

Adicionar ou remover itens no início ou no fim do array é mais fácil que roubar doce de criança. As funções `pop()`, `push()`, `shift()` e `unshift()` estão presentes em quase todas as linguagens de programação e é conhecida por praticamente todos que as programam.

As duas primeiras trabalham com os elementos finais do array, enquanto `shift()` e `unshift()` trabalham com os elementos iniciais. Abaixo um breve exemplo.

``` javascript
var arr = [1, 2, 3, 4, 5];
console.log("Array original..: " + arr);

arr.pop();
console.log("Após o pop()....: " + arr);

arr.push(0);
console.log("Após o push()...: " + arr);

arr.shift();
console.log("Após o shift()..: " + arr);

arr.unshift(9);
console.log("Após o unshift(): " + arr);
```

O código acima terá como resultado a seguinte seqüência:

<a href="http://gustavopaes.net/images/posts/2010/07/trabalhando-com-array-javascript.gif"><img class="aligncenter size-full wp-image-161" title="Resultado dos comandos" src="http://gustavopaes.net/images/posts/2010/07/trabalhando-com-array-javascript.gif" alt="Resultado dos comandos" width="197" height="89" /></a>

## Trabalhando com itens intermediários

Trabalhar com itens que estão no meio de um array não é tão fácil, caso você não conheça a função `splice()`. Sem ela, a única forma de adicionar ou remover um item intermediário é criar um segundo array, trabalho lento e desnecessário.

### O jeito porco

Sem a função `splice()`, portanto, o código para adicionar um elemento no meio do array ficaria mais ou menos assim:

``` javascript
var arr_original = [1, 2, 3, 4, 5];
var arr_temp     = [];

// Novo valor que deverá ser incluido no array
var novo_valor = 6;

// Posição que deverá ser incluido
var pos_item = 3;
while(arr_original.length) {
  if(arr_temp.length == pos_item) {
    arr_temp.push(novo_valor);
    continue;
  }

  arr_temp.push(arr_original.shift());
}

arr_original = arr_temp;
```

Como a idéia não é explicar o jeito errado, não vou explicar o código acima, apenas dizer que ele vai removendo os itens do array original, adicionando no temporário e, quando chega a hora do item novo entrar, ele entra e o processo de remover do original para o temporário prossegue até o original ficar sem itens.

A mesma lógica pode ser usada para remover um item.

### O jeito certo

O código é funcional, mas desnecessário. O javascript tem uma função que faz exatamente o que o código acima faz. E pode ter certeza que de forma mais rápida. A função é a [`splice()`](http://www.w3schools.com/jsref/jsref_splice.asp "W3Schools: JavaScript splice() Method").

Sua sintaxe é simples e exige os mesmos parâmetros que o código acima: o array original, a posição inicial, a quantidade de itens que serão afetados, e, se for para adicionar itens, eles próprios.

``` javascript
(Array) arr_original.splice(index, quantidade, elem1, ..., elemX);
```

Os exemplos abaixo mostram como remover dois itens do array, a partir do segundo elemento e como adicionar um novo elemento na 4 posição.

``` javascript
arr = [1, 2, 3, 4, 5];
arr.splice(2, 2);
// [1, 2, 5]

arr = [1, 2, 3, 4, 5];
arr.splice(3, 0, 6);
// [1, 2, 3, 6, 4, 5]
```

**Importante:** a função altera diretamente o array original. O que ela retorna é um array com os itens que foram afetados &#8212; adicionados ou removidos. Portanto, cuidado ao fazer `arr = arr.splice(2, 2)`. O resultado não será o que você esperava.

Para mais exemplos, acesse o [W3Schools](http://www.w3schools.com/jsref/jsref_obj_array.asp).

## Criando sua própria função

Convenhamos, o _core_ do Javascript deveria possuir uma função mais objetiva para adicionar e remover itens mais _claramente_. Bom, vamos criar nós mesmos:

``` javascript
<script>
Array.prototype.remove = function(start, end) {
  this.splice(start, end);
  return this;
}

Array.prototype.insert = function(pos, item) {
  this.splice(pos, 0, item);
  return this;
}

var arr = [1, 2, 3, 4, 5];

console.log(arr.remove(3, 1));
//  [1, 2, 3, 5]

console.log(arr.insert(3, 0));
// [1, 2, 3, 0, 5]
</script>
```

**Observação 1:** Lembre-se que a contagem de um item no array começa sempre no zero. Isso faz muita diferença :)

**Observação 2:** Trabalhar com _prototype_ nem sempre é uma boa idéia. Se não tem certeza do que pode ocorrer, ou se você adicionar o código acima e algo parar de funcionar, tente usar funções normais &#8212; _function removeItem(arr, start, end){ &#8230; }._

