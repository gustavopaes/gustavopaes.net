---
author: Gustavo Paes
title: Magento eCommerce: melhorando a qualidade da imagem do produto
description: A qualidade da imagem pode significa a compra ou não de um produto. Veja como aumentar a qualidade do JPEG no Magento eCommerce.
date: 2010-06-06 12:00pm
categories: blog, programação, front-end, magento ecommerce
---

A qualidade da imagem pode significa a compra ou não de um produto. O Magento, por padrão, faz a compressão do arquivo mantendo 70% da qualidade, o que pode deixar algumas imagens _serrilhadas_.

Dependendo do seu negócio, isso não é muito bom, pois pode influenciar na opnião do cliente sobre o produto.

A mudança é bem simples. A dica é [do blog narno.com](http://narno.com/blog/augmenter-la-qualite-des-photos-sur-magento).

1. Abra em seu editor de textos o arquivo `/lib/Varien/Image/Adapter/Gd2.php`;
2. Vá para a **linha 80** e troque pelo código abaixo:


``` php
if ($this->_fileType === IMAGETYPE_JPEG) {
  call_user_func($this->_getCallback("output"), $this->_imageHandler, $fileName, **90**);
} else {
  call_user_func($this->_getCallback("output"), $this->_imageHandler, $fileName);
}
```


O **número 90** no código indica que a imagem será comprimida mantendo-se 90% de sua qualidade. Caso queria mais qualidade, aumente o número, para um limite de 100%. Mas lembre-se, mais qualidade significa uma imagem mais pesada.

O Magento também aceita imagens do tipo PNG, mas ele não faz a compressão para esse tipo de imagem, deixando elas no tamanho original, as vezes muito grande para o usuário (~ 200kb).

Você pode melhorar isso permitindo que o Magento comprima esses arquivos da mesma forma que uma imagem JPEG, reduzindo o arquivo final mas mantendo a qualidade. Para fazer isso, altere a mesma **linha 80**, adicionando um `else if` ao código:

``` php
if($this->_fileType === IMAGETYPE_JPEG) {
  call_user_func($this->_getCallback("output"), $this->_imageHandler, $fileName, 90);
} else if($this->_fileType === IMAGETYPE_PNG) {
  call_user_func($this->_getCallback("output"), $this->_imageHandler, $fileName, 5);
} else {
  call_user_func($this->_getCallback("output"), $this->_imageHandler, $fileName);
}
```

No caso do PNG, a numeração muda. Vai de 0 (zero, sem compressão, valor _default_) a 9 (máxima compressão). Basta ir fazendo os testes para descobrir qual o melhor custo (tamanho da imagem) / benefício (qualidade da imagem).

## Atualizando as imagens cadastradas anteriormente

O Magento possui sistema de cache para imagens, para agilizar o processamento e o carregamento das páginas. Isso impossibilita que as imagens que foram cadastradas antes da modificação tenham a qualidade alterada para as novas configurações.

Para atualizar todas as imagens, basta limpar o cache. Para isso, acesse a administração, item _System (Sistema)_ > _Cache Management (Gerenciador de cache)_ > _Images cache (Cache de imagens)_.

