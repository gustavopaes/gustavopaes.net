---
author: Gustavo Paes
title:  Adicionar botão +1 do Google de forma assíncrona
description: Veja como adicionar o botão do Google +1 e alavancar o seu site nos resultados do Google.
date: 2011-06-18 12:00pm
categories: blog, javascript, front-end
---

O <a href="http://www.google.com/webmasters/+1/button/" target="_blank">botão +1</a> (plus one) do Google permite que os visitantes indiquem a página. Essa indicação será usada para dar mais relevância ao resultado de busca. Quanto mais uma página tiver indicações, mais no topo ela fica. Portanto é uma boa ideia ter um botão desse.

Entretanto, adicionar simplesmente o script no `head` da página pode deixá-la mais lenta. Para resolver isso, é possível carregar o script de forma assíncrona, permitindo que elementos mais importantes da página sejam carregadas **juntas** com o script do google e não após.

No rodapé do seu site / blog, antes do `</body>`, adicione o seguinte código:

``` javascript
<script>
(function(d) {
  var g = d.createElement("script"),
    h = d.getElementsByTagName("head")[0];
  g.async = true;
  g.src = "https://apis.google.com/js/plusone.js";
  h.appendChild(g);
})(document);
</script>
```

No lugar onde você quer que o botão do +1 apareça, insira esse código:

``` html
<div class="g-plusone" data-size="medium" data-count="false"></div>
```

Recomendo usar esse `div` ao invés da tag `g:plusone` por ser válido no HTML5 e funcionar no IE8. O parâmetro `data-count` é o que define se exibirá o contador de pessoas que _google-recomentaram_ ou não.

## Suporte ao IE7

É bom saber que o Google <a href="http://googleenterprise.blogspot.com/2011/06/our-plans-to-support-modern-browsers.html" target="_blank">não dá mais suporte ao IE7</a>. Todos seus produtos podem parar de funcionar em algum momento nesse navegador.

Com o Google +1 é a mesma coisa. E nesse caso o script nem funciona no IE7. Portanto, não ache que é um bug caso você ainda use o IE7. Verifique se carrega nos demais navegadores.

