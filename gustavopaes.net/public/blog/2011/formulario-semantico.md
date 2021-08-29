---
layout: post
author: Gustavo Paes
title:  Formulário semântico
description: Criar formulários pode gerar confusão em relação à semântica. Não deveria, é a coisa mais simples de se fazer. Basta usar as tags fieldset e label e seu formulário fica semântico.
date: 2011-01-11 12:00pm
categories: blog, html, front-end
---

Odeio criar formulário. É algo que não me agrada. Cada navegador renderiza de um jeitos os campos de texto, _radios_, _checkbox_ hora aparece mais pra cima, hora mais pra baixo e os _selects_ que são impossíveis de se customizar.

Mas o assunto desse post não é esse. Embora criar formulários seja chato, não quer dizer que seja difícil. Formulários semânticos então, são mais fáceis até.

Já vi formulários montados dentro de tabelas &#8212; faz tempo que não vejo, dentro de listas (`ul`, `li`) e dentro de uma lista de definições (`dl`, `dd` e `dt`). Nenhuma das formas estão corretas.

Você pode pensar que um formulário é uma lista de campos. Ok, mas a lista deve ser usada quando você já tem os dados e não quando vai recebê-los. O mesmo vai para a lista de definições. Não faz sentido você dizer que **Nome** é um `input`. O robozinho do Google vai ficar confuso.

Antes de criarmos o formulário semântico, vamos aprender sobre as _tags_ existentes para criar formulários. Fora as _tags_ que criam botões, `selects`, `radios` e outros tipos de entrada existem duas tags fundamentais: `fieldset` e `label`.

## Relacionando dados com `fieldset`

O `fieldset` pode ser usado uma, duas ou mais vezes dentro de um formulário. Em geral é usado uma vez só, mas se seu formulário for complexo você pode achar melhor dividir as informações. Para isso, use mais de um `fieldset` acompanhado da tag `legend`.

A tag `legend` é apenas visual e coloca um título no início do `fieldset`.

## Definindo o `label`

A tag `label` deve envolver um campo e um título equivalentes. Por exemplo, o texto _Nome completo_ e o `input` para o nome devem ficar dentro de um `label`.

O mais importante do `label` é o atributo `for`. Ele indica qual campo do formulário deve ganhar o foco quando o texto for clicado.

Veja aqui um <a href="//gustavopaes.net/images/posts/2011/01/formulario.html" target="_blank">formulário semântico</a> usando as duas tags acima e uma customização básica em CSS.

