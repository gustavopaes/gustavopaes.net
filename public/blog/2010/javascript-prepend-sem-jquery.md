---
author: Gustavo Paes
title: Javascript: prepend sem jQuery
description: Descubra como criar o mesmo resultado do método prepend() sem o jQuery.
date: 2010-06-24 12:00pm
categories: blog, front-end, javascript
---

O jQuery tem um método chamado `prepend` que adiciona um novo elemento antes de outro qualquer. O uso é bem fácil:

``` javascript
$("button").prepend("<h1>novo html</h1>");
```

Como criar o mesmo resultado do `prepend` sem o Javascript? O javascript tem um método `insertBefore` que faz o trabalho.

``` javascript
parentElement.insertBefore(newElement, referenceElement);
```

Vamos a um exemplo mais completo. Supondo que ao clicar num botão, um outro botão deve surgir antes do clicado.

``` javascript
function prepend() {
  // botão clicado
  var obj_button = document.getElementById("button_click");
  
  // cria novo botão
  var new_button = document.createElement("button");
  new_button.innerHTML = "Obrigado por me criar";
  
  // Usamos o .parentNode para obter o objeto do "pai" do botão "velho".
  // É uma necessidade do insertBefore.
  obj_button.parentNode.insertBefore(new_button, obj_button);
}
```

No HTML teremos apenas o botão `button_click`:

``` html
<button id="button_click" value="criar" onclick="prepend()">Oi</button>
```

**Fonte:**
[Node.insertBefore](https://developer.mozilla.org/En/DOM/Node.insertBefore)
[API jQuery](http://api.jquery.com/)