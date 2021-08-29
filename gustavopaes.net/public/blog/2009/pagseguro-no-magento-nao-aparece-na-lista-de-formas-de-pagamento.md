---
layout: post
author: Gustavo Paes
title:  PagSeguro no Magento não aparece na lista de formas de pagamento
description: Veja a dica de como exibir o PagSeguro como forma de pagamento no Magento 1.3, usando o módulo da Visie.
date: 2009-10-01 12:00pm
categories: blog, magento, pagseguro
filename: pagseguro-nao-aparece-na-forma-de-pagamento-do-magento
---

Esses dias precisei configurar o módulo do PagSeguro na loja de e-commerce Magento. A instalação é simples &#8212; embora esteja meio confusa no próprio [site da Visie](http://visie.com.br/), que desenvolveu o módulo.

O problema é que, após configurado corretamente, o PagSeguro não era exibido na lista de formas de pagamento, quando estava fechando um pedido.

Procurando bastante o problema na internet, achei uma solução simples, no [fórum do próprio Magento](http://www.magentocommerce.com/boards/). Vou colocar os passos aqui para a instalação e correção desse problema.

**Obs.:** Atente-se pelas versões:
Magento: 1.3.2.4
Módulo do PagSeguro: 3

1. Baixe o módulo do PagSeguro ([download direto](http://visie.com.br/pagseguro/magento-v3.zip), [baixar no site da Visie](http://visie.com.br/pagseguro/magento.php));
2. Dentro do zip tem um diretório PagSeguro e um arquivo PagSeguro.xml.
O diretório você deve enviar para: _[diretório do magento]/app/code/community/_.
O arquivo xml você deve enviar para _[diretório do magento]/app/etc/modules/_
3. Vamos fazer a correção para que o PagSeguro seja exibido na lista de pagamentos.
Abra o arquivo: **[diretório do magento]/app/code/community/PagSeguro/etc/config.xml** e procure o código:

    
    <payment>
      <pagseguro_standard>
        <model>PagSeguro_Model_Standard</model>
        <title>PagSeguro Standard</title>
        <allowspecific>1</allowspecific>
      </pagseguro_standard>
    </payment>
    

Troque o 1 por 0:

    
    <payment>
      <pagseguro_standard>
        <model>PagSeguro_Model_Standard</model>
        <title>PagSeguro Standard</title>
        <allowspecific>0</allowspecific>
      </pagseguro_standard>
    </payment>
    

4. Ative o módulo do PagSeguro em sua administração (Sistema > Configuração > Métodos de Pagamento) e tudo resolvido.

![](//gustavopaes.net/images/posts/2010/11/tumblr_kqu30iliUK1qzmums.jpg "PagSeguro no Magento eCommerce")

