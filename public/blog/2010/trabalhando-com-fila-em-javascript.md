---
layout: post
author: Gustavo Paes
title: Trabalhando com fila em Javascript
description: Entenda o que é (dah!), quando usar e um script básico de fila em Javascript.
date: 2010-10-08 12:00pm
categories: blog, front-end, javascript
---

Brasileiro gosta muito de fila. É só colocar um prazo para atualizar algum tipo de informação e esperamos até a data final para irmos enfrentar uma fila quilométrica.

Entretanto, programadores em geral, sejam eles brasileiros ou não, não costumam usar a idéia de fila em suas programações. Até porque, no dia-a-dia de um programador, são raros os sistemas que exijam tal recurso.

Porém, é sempre bom saber o conceito para poder usar assim que precisar. Aqui vai alguns pontos que aprendi esses dias usando fila em Javascript.

## Conceito de `fila`

O conceito de fila em computação é o mesmo que a fila do banco, do supermercado e as demais filas que enfrentamos no dia-a-dia, inclusive furar fila, seja por ter direito à atendimento preferencial, seja por ser um mal educado.

Dessa forma, entendemos como modelo de fila um modelo que o primeiro item à entrar na fila é o primeiro item a sair da fila. O segundo será o segundo e assim consecutivamente, enquanto a fila existir.

É importante saber que após um _cliente_ da fila ser atendido, os demais _clientes_ passa a ocupar uma posição a frente.

## Onde usar `filas`

As filas existem para evitar tumulto e que todos os pedidos feitos sejam atendidos da forma mais rápida e justa. Novamente, é assim no dia-a-dia e é assim na computação.

O sistema operacional usa as filas &#8212; num conceito mais complexo que o descrito acima, é verdade &#8212; para executar processos, serviços, gerenciar operações de _input / output_ entre outras coisas.

Na vida mais tranqüila de um programador `Javascript`, fila pode ser usado para:

+ tratamento de erros;
+ evitar requisições simultâneas;
+ prevenir utilização do mesmo Objeto simultaneamente;
+ método de realização de tarefa automática.

Provavelmente existem muitos outros motivos para o uso de filas.

## Um código básico de fila

Um **sistema simples de fila** consiste em duas simples funções, com um `array`.

``` javascript
var itens_fila = [];

/**
 * Adiciona um item à fila.
 * @param Function    Função que será adicionada à fila
 * @return Int    Posição (índice) em que entrou na fila
 */
function addItem(func) {
  return itens_fila.push(func);
}

/**
 * Executa o primeiro item da fila.
 * @return Int    Função que está sendo executada
 */
function nextPlease() {
  if(itens_fila.length > 0) {
    itens_fila[0].call(window);
    return itens_fila.shift();
  }

  return null;
}
```

### Usando o código

Supondo que você precise carregar três diferentes scripts com dados de fornecedores, clientes e caloretiros (falta de criatividade), mas tem que esperar um script terminar para que o outro seja carregado e escrito.

``` javascript
function loadScript() {
  // adiciona um script à página que possue um
  // callback para a função 'loaded()'
  ...
}

function loaded(json) {
  // trabalha com os dados recebidos e após
  // finalizar, executa o próximo item da fila.

  ...

  nextPlease();
}

addItem(function() {
  loadScript("dadosFornecedor.js");
});

addItem(function() {
  loadScript("dadosCliente.js");
});

addItem(function() {
  loadScript("dadosCaloteiros.js");
});

// Inicia o procedimento da fila
nextPlease();
```

## Muito mais sobre fila, pilha e lista

Fila pode ser muito mais complexo do que parece. Algumas variações podem surgir e teremos pilha e lista. 

Se você está interessado em se aprofundar no assunto, uma [pesquisada no Google](http://www.google.com.br/search?q=fila%20em%20programa%E7%E3o "pesquisa: fila em programação") te leva a sites/artigos/trabalhos interessantes.

