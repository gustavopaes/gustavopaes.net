---
author: Gustavo Paes
title:  Duas dicas para o Google Analytics no WordPress
description: Duas dicas para o Google Analytics no Wordpress: adicione o código assíncrono para deixar seu site mais rápido e remova da contabilização as suas visitas, evitando dados viciados.
date: 2011-03-31 12:00pm
categories: blog, geral
---

Vou dar duas dicas para usar melhor o Google Analytics no WordPress.

## Carregamento assíncrono do Google Analytics

Carregamento assíncrono quer dizer que o script será carregado sem que a página seja travada enquanto isso acontece. Hoje a internet é bem rápida, se comparada com o passado, então fica difícil de entender isso.

Mas nada mais é do que o navegador irá continuar carregando e renderizando a página mesmo que o script ainda não tenha sido carregado, seja porque ele é grande ou porque o servidor está lerdo para responder.

Isso tem um ganho significativo na velocidade de navegação para o usuário e ainda evita de seu site ficar travado quando um servidor externo fique fora do ar &#8212; no caso seria o do Google.

O Google disponibiliza um <a href="http://code.google.com/intl/pt-BR/apis/analytics/docs/tracking/asyncTracking.html" target="_blank">código para o carregamento assíncrono</a>. Então, basta copiar o código e colocar em qualquer lugar do template. O Google recomenda antes da tag `</head>`. Eu recomendo que você insira isso no arquivo `footer.php`, antes do `</body>`.

``` html
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(["_setAccount", "**UA-XXXXX-X**"]);
_gaq.push(["_trackPageview"]);
(function() {
  var ga = document.createElement("script");
  ga.type = "text/javascript";
  ga.async = true;
  ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(ga, s);
})();
</script>
```

Obs.: Não esqueça de trocar o código **UA-XXXXX-X** pelo código da sua conta.

Essa dica eu garimpei no <a href="http://javascript.singuska.com/2010/01/16/analytics-assincrono-e-o-plugin-google-analyticator/" target="_blank">singuska</a>.

## Não viciando métricas com suas visitas

Depois que eu terminava de escrever um texto e publicar, no dia seguinte ele estava entre um dos mais vistos do blog, em pageviews. Isso porque, antes de publicar eu via vários _previews_ para ver como estava ficando e fazer revisões.

Assim os dados ficavam viciados e, embora um post tivesse 300 PVs em uma semana, 200 tinham sido meus. Para solucionar isso adicionei uma verificação para ver se o usuário que está acessando a página sou eu mesmo. Se for, não executa o código do Google Analytics.

``` php
<?php if(!is_user_logged_in() || wp_get_current_user()->{"data"}->{"user_login"} != "**usuário**") : ?>
<script type="text/javascript">
  // código do Google Analytics
</script>
<?php endif; ?>
```

Obs.: Não esqueça de trocar **usuário** por seu usuário administrativo no blog.

É claro que, se eu acessar o blog sem estar logado a contabilização será feita. Mas isso é de menos. O problema são os previews da administração, que acabou se resolvendo.

