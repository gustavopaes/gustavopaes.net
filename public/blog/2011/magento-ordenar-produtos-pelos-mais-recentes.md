---
author: Gustavo Paes
title:  Magento: ordenar produtos pelos mais recentes
description: Veja como ordenar seus produtos, no Magento, por ordem de criação ou pela data de atualização.
date: 2011-01-29 12:00pm
categories: blog, magento, programação
---

O Magento as vezes é muito chato. Por exemplo, precisava deixar os produtos dentro das categorias ordenado do mais recente para o mais antigo.

Mas ele só permite ordenar pelo melhor preço, mais caro, mais barato e nome. Isso pode resolver para outros produtos, mas em geral, estampas de camisetas devem aparecer as mais recentes no início.

E a única forma que achei para fazer isso é alterando diretamente no código o _sort_ da listagem. Se você quer fazer o mesmo, siga os passos:

**Versão do Magento:** 1.4.2.0

1. Faça uma cópia do arquivo **app/code/core/Mage/Catalog/Block/Product/List.php** em **app/code/local/Mage/Catalog/Block/Product/List.php**;

2. Abra para edição o novo arquivo (a cópia do original) e vá para a linha 86, e deixa parecido com isso:

``` php
$this->_productCollection = $layer->getProductCollection()->addAttributeToSort("updated_at", "DESC");
```

Pronto, a ordenação dos produtos ficará pela data de atualização. Para ordenar pela data de criação, basta trocar o `updated_at` por `created_at`.

É isso, boa sorte.

