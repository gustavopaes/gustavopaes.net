---
layout: post
author: Gustavo Paes
title: Como funciona o Token bancário
description: Você sabe como funciona o token dos bancos? Veja como o número é gerado e como banco descobre que você digitou corretamente.
date: 2010-12-02 12:00pm
categories: blog, windows
---

_Atualizado em: 08/04/2011 ([roubo de informações dos tokens da RSA Security](#roubo-rsa))_

Muita gente usa e não sabe o funcionamento do famoso Token dos bancos. No Itaú-Unibanco ele é chamado de _iToken_ e se parece com um chaveiro com um visor exibindo números de seis dígitos (imagem ao lado).

No Bradesco você pode usar o próprio iPhone para obter esses números. As formas são muitas, mas o uso é sempre o mesmo.

Você vai fazer uma operação bancária e lhe é solicitado o número que aparece no token. Você digita os números e, como uma mágica, a operação é liberada.

![Exemplo de token bancário da RSA](//gustavopaes.net/images/posts/2010/12/SecureID_token_new_opt.jpg "SecureID Token")

Mas você sabe como o banco sabe que o número digitado é o correto, mesmo ele mudando a cada 30-60 segundos?

## Como é gerado o número

Antes de entender como o banco descobre se o número está correto, precisamos entender como o token gera um número diferente a cada 30 segundos.

Cada token vem com um código interno e um relógio. Usando uma fórmula ele usa o código interno e a hora (completa) atual para gerar o número. É provável que a cada mudança de número o token use um código interno diferente. Senão bastaria alguns números para você ser capaz de descobrir o próximo ou chegar à formula.

## O banco sabe quem é você

O banco sabe qual o(s) código(s) interno do seu token e usa a mesma fórmula para gerar o número.

Aí é simples, quando ele recebe o número digitado por você, ele usa o código e fórmula do seu token e compara o resultado com o número informado.

## Momento crítico

A sincronização é o momento mais crítico. Acredito que um número tenha vida útil de um a um minuto e meio. Supondo que você digitou um número que já tenha sido criado a 29 segundos (o número é trocado a cada 30 segundos), seria impossível o banco validar o código em menos de um segundo.

Dessa forma, acredito eu, há um _offset_ para garantir que atrasos sejam contornados.

## Vantagens

O token tem duas principais vantagens em relação a outros modelos de senhas, como o cartão de números ou letras. A primeira vantagem é a possibilidade de usar até a pilha acabar, o que os fabricantes dizem durar 5 anos.

A segunda vantagem é que apenas quem tem a fórmula do token e o código dele poderá chegar no próximo número. Segundo a fabricante RSA, o código é criptografado no padrão <dfn title="Advanced Encryption Standard, padrão avançado de criptografia">AES</dfn>. Ou seja, os riscos diminuem muito em relação aqueles cartões com 60 números estáticos.

## Riscos

[Pelo que encontrei na internet](http://g1.globo.com/Noticias/Tecnologia/0,,MUL1189074-6174,00-PACOTAO+DE+SEGURANCA+TRUQUE+PARA+SITES+FALSOS+E+VIRUS+EM+SITE+DE+TORPEDOS.html), o maior risco é você digitar o código atual em um site de banco falso e o criminoso usar o número no naquele mesmo momento. Parece difícil isso acontecer, mas já rolou com o CitiBank.

Pegar vários números do token também pode facilitar a vida dos criminosos. Mas, como hoje ainda possuem métodos mais fáceis de roubar senha dos clientes, o token é uma boa solução.

Os criminosos usam o token como isca para que usuários desinformados instalem um cavalo-de-tróia no computador. O site Geek descreve [um tipo de e-mail _phishing_](http://www.geek.com.br/posts/9225-novo-golpe-na-internet-usa-token-do-banco-itau) enviado em 2009. Provavelmente ocorre ainda hoje, já que muita gente pode acreditar na história de "dessincronização" entre o token e o banco.

>Geek: O texto da mensagem fraudulenta informa que houve um "problema de dessincronização" do token com a base de dados do banco e pede para que o cliente faça o download de uma "atualização" que é, na verdade, um cavalo-de-tróia (também chamado de Trojan).

Por isso **nunca acredite em e-mails enviados pelo seu banco** e seu token **nunca estará "dessincronizado"** com o banco. Caso receba um e-mail desse tipo, entre em contato com o banco ou faça um teste do seu token em um computador que você tenha certeza de que esteja livre de vírus. Ou simplesmente ignore o e-mail e marque-o como spam.

<a name="roubo-rsa"></a>Além dos usuários, a própria empresa que oferece o serviço de token, como a RSA Security, por exemplo, correm riscos com os hackers. Recentemente a RSA teve informações sobre os tokens que oferece roubadas. O Itaú é um dos clientes da empresa. De acordo com a RSA, as informações roubadas não ajudarão muito os hackers, mas mostra que nada é 100% seguro.

Agora que você sabe como funciona o token bancário e tem toda a segurança para realizar transções online, que tal parar pra pensar se [o post](/blog/2011/fundos-de-investimento-um-pouco-sobre-rentabilidade.html) e tire suas conclusões.

**Fontes**
http://en.wikipedia.org/wiki/SecurID
http://brazil.rsa.com/node.aspx?id=1157
http://www.geek.com.br/posts/9225-novo-golpe-na-internet-usa-token-do-banco-itau
http://www.baboo.com.br/conteudo/modelos/Hackers-roubam-dados-sobre-SecurID_a41296_z396.aspx

