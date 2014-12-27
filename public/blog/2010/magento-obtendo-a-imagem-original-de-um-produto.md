---
layout: post
author: Gustavo Paes
title: Magento: obtendo a imagem original de um produto
description: Exiba para os seus usuários as imagens originais dos produtos e evite imagens borradas pela compressão do Magento.
date: 2010-11-20 12:00pm
categories: blog, programação, front-end, magento ecommerce
---

O Magento é um ótimo sistema de e-commerce mas, assim como o WordPress, exige bastante recurso do servidor. Para minimizar isso e deixar a navegação mais rápida para o usuário ele possui um sistema de cache nativo.

Todas as páginas são cacheadas, inclusive as imagens dos produtos. Isso é bom de um lado, já que a imagem original, por vezes é muito grande. Mas em certos casos, ao reduzir a imagem original, acaba-se perdendo a qualidade.

E dependendo do que se vende, uma imagem sem grande qualidade pode fazer o usuário desistir de uma compra.

Por tanto, se você quer exibir a imagem original* do produto, sem reduções, no template do produto use o seguinte código:

    <?php
    echo Mage::getBaseUrl("media") . "catalog/product" . $_product->getImage();
    ?>

Lembrando que o template do produto fica em:
**app/design/frontend/default/[seu template]/template/catalog/product/view.phtml**

Há templates onde as imagens do produto ficam no arquivo de _medias_. Nesse caso, o código é o mesmo, mas o arquivo é:
**app/design/frontend/default/[seu template]/template/catalog/product/view/media.phtml**

\* Entenda-se por _imagem original_ aquela que você enviou na administração do Magento sem compressão.

