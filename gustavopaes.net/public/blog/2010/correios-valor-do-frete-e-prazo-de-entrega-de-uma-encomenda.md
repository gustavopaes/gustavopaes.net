---
author: Gustavo Paes
title: Correios: Valor do frete e prazo de entrega de uma encomenda
description: Classe PHP que, utilizando o webservice dos Correios, retorna o valor e prazo de entrega de uma determinada encomenda. Funciona com serviços PAC, Sedex e e-Sedex, com contratou ou sem contrato.
date: 2010-06-30 12:00pm
categories: blog, programação, php
---

**Update:** A classe foi atualizada em 02/11/2010. A principal mudança foi no método `send()` e na URL do _Webservice_ dos Correios, que havia mudado já há algum tempo.

Classe PHP que, utilizando o webservice dos Correios, retorna o valor e prazo de entrega de uma determinada encomenda. Funciona com serviços PAC, Sedex e e-Sedex, com contratou ou sem contrato.

[Baixar código](https://gist.github.com/gustavopaes/6262135).

## Exemplos

Usar a classe é bem simples. Basta passar as informações exigidas pelos **Correios** &#8212; cep de origem e destino, peso e tamanho da encomenda &#8212; para o tipo de entrega &#8212; Sedex, PAC, e-Sedex &#8212; e os serviços que serão utilizados &#8212; aviso de recebimento, valor declarado, entrega mão própria.

É possível obter o valor do frete e o prazo de entrega. Além do mais, é possível descobrir se a entrega poderá ser realizada em um Sábado.

A classe está muito bem comentada. Basta dar uma estudada no códigos (e nos comentários) para se achar.

``` php
$frete = new Correios();
$frete->set("servico", 40010);
$frete->set("origem", "01321000");
$frete->set("destino", "18609098");
$frete->set("valordeclarado", 9.580);
$frete->set("avisorecebimento", true);
$frete->set("peso", 0.5);

if(!$frete->get()) {
  die($frete->read("erro"));
}

echo "R$: " . $frete->read("valor");
```

A classe pode ser portada para um módulo do Magento, por exemplo, ou para auxiliar em algum plugin do [PagSeguro](https://pagseguro.uol.com.br/).
