---
author: Gustavo Paes
title: Magento: adicionar botão "recomendar" do Facebook
description: Adicione um botão de recomendar, do Facebook, em sua loja do Magento para alavancar suas vendas sem gastar nada.
date: 2010-10-24 12:00pm
categories: blog, programação, front-end, magento ecommerce
---

**Atenção:** Esse post está desatualizado. Para adicionar o botão de curtir / recomendar em seu site, blog ou e-commerce leia a versão atualizada:
http://gustavopaes.net/blog/2011/adicionar-botao-de-recomendar-do-facebook.html

O botão de "recomendar" do Facebook permite que os seus usuários _recomendem_ um página do seu site. Em _e-commerces_ isso é vital para aumentar a exposição de sua loja e de seus produtos de forma simples e gratuita. Afinal de contas, o boca-a-boca é o melhor _marketing_.

Entretanto, a configuração do botão do Facebook deve ser feita corretamente para que a recomendação apareça de uma forma clara e bonita no site do Facebook. Se não, de que adianta o usuário clicar em um botão de recomendar uma camiseta se no Facebook aparece uma foto de uma caneta com laser?

## Um pouco de teoria

O Facebook <a href="http://developers.facebook.com/docs/reference/javascript/" target="_blank" title="JavaScript SDK">possui uma API</a> que permite o programador escrever códigos em Javascript para postar textos, imagens, recomendações, entre outras ações, sem que o usuário saia da página em que ele está.

Usei esse código para adicionar um "Recomendar" no site <a href="http://heramodas.com.br/" title="Hera Modas Vestidos">Hera Modas</a>, como você pode <a href="http://www.heramodas.com.br/vestido-faixa-de-cetim.html" title="Vestido longo Faixa de Cetim">ver nessa página de um produto em específico</a>.

Ao clicar em "Recomendar", uma pop-up se abre para solicitar login e senha do usuário no Facebook e pedir acesso às informações básicas do usuário. Assim que o usuário fizer o login e liberar a aplicação, a pop-up se fecha e uma janela na própria página do site se abre com informações da página.

![](//gustavopaes.net/images/posts/2010/10/bloco-de-recomendacao.gif "Bloco de recomendação do Facebook")

É dessa forma que o produto será "anunciado" no Facebook. Perceba que todas as informações foram capturadas automaticamente pelo Facebook: _thumb_ do vestido, título e descrição do produto.

## Mão na massa: adicionando o código do Facebook

### Criando uma aplicação

Antes de sair adicionando o código do Facebook é preciso que você crie uma aplicação no Facebook. Isso permite que o usuário saiba para quem está liberando acesso e que tipo de informações a aplicação vai usar.

Em primeiro lugar, acesse a [página de desenvolvimento](http://www.facebook.com/developers/). Na coluna da direita, clique no botão "+ Criar um novo aplicativo".

Dê um nome para ele &#8212; de preferência o nome do site, e siga adiante. Na página seguinte &#8212; após digitar o _captcha_ &#8212; surgira uma página de configuração do aplicativo. Preencha com informações reais do seu site. O importante é preencher, na aba "Web Site" a URL e domínio do site.

Feito isso, grave em algum lugar o ID do aplicativo. Ele fica disponível em todas as abas de configuração ou na sua [página de desenvolvimento](http://www.facebook.com/developers/). Usaremos esse código mais a frente.

![](//gustavopaes.net/images/posts/2010/10/app-id.gif "PP ID do Facebook")

### O código base para tudo funcionar

O código abaixo é o que faz toda a ação comentada anteriormente: exibir pop-up de login, verifica permissão ao aplicativo, exibe bloco com os dados do produto e publica no mural do usuário.

Você deve alterar nele apenas o valor do atributo `appId`, na linha 5, pelo código da sua aplicação.

Adicione o código abaixo no seguinte arquivo de seu template:
**template/page/html/footer.phtml**

``` php
<?php if (Mage::registry("current_product")) : ?>
  <div id="fb-root"></div>
  <script type="text/javascript">
  window.fbAsyncInit = function() {
    FB.init({
      appId  : "SUA APP ID",
      status : true, // check login status
      cookie : true, // enable cookies to allow the server to access the session
      xfbml  : true  // parse XFBML
    });
  };
  
  function recomendar() {
    FB.login(function(resp){
      if(resp.session) {
        FB.ui({
          method: "stream.share",
          u: "<?php echo $this->helper("core/url")->getCurrentUrl(); ?>"
        });
      }
    }, {"perms" : "publish_stream"});
  }

  (function() {
    var e = document.createElement("script");
    e.src = document.location.protocol + "//connect.facebook.net/pt_BR/all.js";
    e.async = true;
    document.getElementById("fb-root").appendChild(e);
  }());
  </script>
<?php endif; ?>
```

A função `recomendar()` simplesmente usa a API do Facebook para efetuar o login (através do `FB.login()`) e a publicação no mural (através do `FB.ui()`).

A documentação de ambos os métodos pode ser encontrada na [área de desenvolvedores do Facebook para o JavaScript SDK](http://developers.facebook.com/docs/reference/javascript/).

**Atenção:** o primeiro `if`, em PHP, faz com que esse código só seja exibido nas páginas dos produtos. Ou seja, na home e outras páginas como busca ou páginas estáticas não terão esse código. Se você pretende adicionar um botão de recomendar em todas as páginas, retire, portanto, esse `if`.

### O botão para recomendar

O botão nada mais é que uma imagem que deve executar a função `recomendar()` do código acima. Ou seja, o código é bem simples.

Adicione o código abaixo no seguinte arquivo de seu template:
**template/catalog/product/view.phtml**
    
``` html
<img src="/path/para/imagem/recomendar-facebook.gif"
  alt="Recomende este produto no Facebook!"
  title="Recomende este produto no Facebook!"
  onclick="recomendar();" />
```

**Atenção:** você pode adicionar esse botão em outro template também, caso queira que ele seja exibido no cabeçalho ou no rodapé da página. Nesse caso é adicionado apenas no template do produto pois a finalidade é que o usuário recomenda apenas o produto e nenhuma outra página do site.

Feito isso, o recomendar já deve estar funcionando. Atualize o cache do template na administração e faça um teste.

### Adicionando _Open Graph Meta Tags_

O _Open Graph Meta Tags_ são tags especiais que o Facebook lê quando alguém recomenda o seu site. São nessas tags que o Facebook pega o título, descrição e thumb que deve usar para publicação.

Portanto, são de extrema importância que elas, nas páginas dos produtos, indiquem as corretas informações sobre ele para evitar o problema descrito no início do post: usuário recomendar uma camiseta e, no mural dele, aparecer uma caneta.

Esse [código achei no blog The Magento Book](http://the-magento-book.cairocubicles.com/2010/10/facebook-like-button-on-the-product-page/). Adicione ele no cabeçalho do seu template:
**template/page/html/head.phtml**

``` php
<?php if (Mage::registry("current_product")) : ?>
  <!--start Facebook Open Graph Protocol-->
  <meta property="og:site_name" content="Your Site Name" />
  <meta property="og:title" content="<?php echo $this->getTitle() ?>" />
  <meta property="og:type" content="product" />
  <meta property="og:url" content="<?php echo Mage::helper("core/url")->getCurrentUrl()  ?>"/>
  <meta property="og:image" content="<?php echo Mage::helper("catalog/image")->init(Mage::registry("current_product"), "small_image")->resize(100,100);?>"/>
  <meta property="og:description" content="<?php echo $this->getDescription() ?>"/>
  <!--end Facebook Open Graph Protocol-->
<?php endif; ?>
```

Com isso feito, tudo deve estar funcionando como deveria.

