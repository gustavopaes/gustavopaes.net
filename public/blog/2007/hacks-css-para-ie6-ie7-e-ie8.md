---
layout: post
author: Gustavo Paes
title:  Hacks CSS para IE6, IE7 e IE8
description: Use o IE Developer Toolbar para debugar markup e CSS no Internet Explorer. Ele é o Firebug para o Internet Explorer.
date: 2007-11-03 12:00pm
categories: blog, front-end, css
---
Hacks CSS são _regras_ que só servem para determinado navegador. No caso, esse determinado navegador _geralmente_ é o Internet Explorer, mas podemos encontrar alguns hacks para o Safari também.

Usamos hacks para resolver _bugs_ de renderização desses navegadores. O IE6 possui um hack específico e o IE7 possui outro. Há situações que o IE6 renderiza igual ao Firefox ou IE8 e não precisa de hack, mas o IE7 precisa de um ajuste no _padding_, por exemplo.
Em geral, se você faz um _belo_ HTML, vai precisar de hacks apenas para o IE6, mas nesses meus últimos anos de trabalho tenho percebido que o IE7 é pior que o IE6.

## Hacks para IE6
O hack para o IE6 é muito conhecido, devido a idade do navegador. Basta colocar um _underscore_ antes da regra CSS para que apenas o IE6 renderize a regra.

    body {
      background-color: blue;
      _background-color: red; /* Apenas o IE6 terá fundo vermelho */
    }    

 Perceba que a regra deve vir após a principal. Se você inverter as ordens a segunda regra irá sobrepor a primeira e o hack de nada servirá.

## Hack para IE7
Quando a Microsoft desenvolveu o IE7 removeram o hack de CSS usado no IE6, mas deixaram um outro. Basta usar o asterisco no lugar do _underscore_.

    body {
      background-color: blue;
      *background-color: red; /* Tanto o IE6 como o IE7 terão fundo vermelho */
    }    

## Hack para IE8O
IE8 não "reconhece" nenhum hack das versões anteriores, possuindo um apenas para ele. Basta colocar um **\9** no valor da regra.

    body {
      background-color: blue;
      background-color: red\9;
    }

## Evitando conflitos de hacks
Você pode perceber que o IE6 reconhece o hack do IE7. Ainda bem que o IE7 não reconhece o hack do IE6. Dessa forma, para usar um hack só para o IE7, por exemplo, basta usar o hack do IE6 novamente para redefinir uma regra.
Como no exemplo acima, quero que o IE7 e IE8 tenham um background diferente:

    body {
      background-color: blue;
      *background-color: red; /* Tanto o IE6 como o IE7 terão fundo vermelho */
      _background-color: blue; /* Agora reescrevemos para o IE6 ter fundo azul */
      background-color: green\9; /* E por fim IE8 */
    }

Bizarro né?! Mas infelizmente é isso que se deve fazer.

## Boas práticas ao usar hacks
Hack não é bonito. Mas infelizmente as vezes precisamos desse artifício para que o site fique bom em vários navegadores.
Portanto, se o _estupro é inevitável_, curta ele. Se você vai usar hacks CSS, use-o de uma forma que fique fácil identificar onde foi usado e o motivo. O que geralmente faço é colocar os Hacks CSS em regras separadas da demais e colocar comentários explicando o motivo do hack.

    .bloco {
      background-color: blue;
      padding: 10px;
      margin: 5px;
      width: 150px;
    }
    
    .bloco h1 {
      font-size: 13px;
      color: red;
      padding: 5px;
    }
    
    /**  hacks para IE6 e IE7 */
    .bloco {
      /* O IE6 soma a largura com o padding, portanto faço novamente o calculo */
      _width: 130px;
    }

    .bloco {
      /* IE7 estava quebrando devido ao anti-alias da fonte. */
      *padding:5px;
    }