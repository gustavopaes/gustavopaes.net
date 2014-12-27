---
layout: post
author: Gustavo Paes
title:  Adicionar botão de "Recomendar" do Facebook
description: Adicione um botão de recomendar, do Facebook, em sua loja do Magento para alavancar suas vendas sem gastar nada. Veja também como fazer isso no Wordpress.
date: 2011-05-29 12:00pm
categories: blog, geral
---

O botão de &ldquo;recomendar&rdquo; do Facebook permite que os seus usuários recomendem um página do seu site. Em e-commerces isso é vital para aumentar a exposição de sua loja e de seus produtos de forma simples e gratuita. Afinal de contas, o boca-a-boca é o melhor marketing.

Entretanto, a configuração do botão do Facebook deve ser feita corretamente para que a recomendação apareça de uma forma clara e bonita no site do Facebook. Se não, de que adianta o usuário clicar em um botão de recomendar uma camiseta se no Facebook aparece uma foto de uma caneta com laser?

## Um pouco de teoria

Quando o usuário clica no botão de recomendar a página, o Facebook irá adicionar uma entrada no mural do usuário exibindo uma imagem (caso ele encontre), o título da página e uma descrição.

Todas **essas informações são obtidas na URL que o usuário curtiu / recomendou**. O Facebook usa as informações que estão presentes nas tags `title, descriptions e image_src`.

Portanto, certifique-se que todas as páginas de seu site / blog / e-commerce tenha as seguintes tags:

    <!--start Facebook Open Graph Protocol-->
    <meta property="og:site_name" content="Nome do seu site" />
    <meta property="og:title" content="Título da página." />
    <meta property="og:url" content="http://seusite.com/url-da-pagina/"/>
    <meta property="og:image" content="http://seusite.com/url-da-pagina/imagem-da-pagina.gif"/>
    <meta property="og:description" content="Uma sinopse do que o usuário irá encontrar acessando a URL."/>
    <!--end Facebook Open Graph Protocol-->

## O código do Facebook

O código para adicionar o botão de curtir / recomendar do Facebook é muito simples. Basta alterar as informações do seu site no código abaixo:

    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/pt_BR/all.js#xfbml=1"></script>
    <fb:like href="http://www.seusite.com/url-da-pagina/" send="true" layout="button_count" width="450" show_faces="false" font="arial"></fb:like>

### No Magento

No Magento, você deve inserir esse código no seguinte arquivo:
**./app/design/frontend/default/[seu template]/template/catalog/product/view.phtml**

Para obter a URL automaticamente, coloque no parâmetro `href=""` o seguinte código:

    [...] href="<?php echo $this->helper("core/url")->getCurrentUrl(); ?>" [...]

Com o botão na página, abra agora o header do seu template para adicionar o código do _Open Graph Meta Tags_:
**./app/design/frontend/default/[seu template]/template/page/html/head.phtml**

O código deve ficar assim, já obtendo automaticamente as informações do produto:

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

### No WordPress

Já no WordPress, você deve inserir no seguinte arquivo: **./wp-content/themes/[seu template]/single.php**

Já no parâmetro `href=""`, use o seguinte:

    [...] href="http://url-seu-blog.com/?p=<?php the_ID(); ?>" [...]

