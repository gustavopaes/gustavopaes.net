---
author: Gustavo Paes
title:  Como atualizar seu Magento 1.4 para a 1.5 pelo SSH
description: Veja como atualizar o Magento 1.4.2.0 para a versão mais recente, a 1.5.1.0, via SSH.
date: 2011-05-28 12:00pm
categories: blog, magento
---
Não sei por que raios o _Magento Connect_ de uma loja virtual que administro não estava apresentando os _updates_ do Magento. A **versão da instalação era a 1.4.2.0** e nem os paths de segurança para essa versão o _Connect_ não mostrava.

**Dificuldade de execução: média!**
**Cuidado, tenha sempre backup de TODOS os dados.**

Consegui resolver o problema seguindo os passos abaixo. Vamos considerar que o path de instalação da minha loja estava em _shop/_. Lembre-se, portanto, de trocar o path para o seu:

0.a. Fazer backup da sua instalação atual:

    cp -rf shop/ shop.x.x.x/

0.b. Desabilitar o cache do Magento;

## Primeiro passo

<a href="http://dx3webs.com/front/2011/01/correct-out-dated-pear-version-while-installing-magento-1-4-2-1-7-1-1-9-1/" target="_blank">Atualizar a versão do PEAR</a> da minha instalação, que estava na 1.7 e era preciso da 1.9 ou superior. Para isso digite os seguintes comandos:

``` bash
cd shop/
chmod +x pear
./pear mage-setup
./pear channel-update pear.php.net
./pear upgrade --force PEAR
```

Se o último comando apresentar um erro, execute ele novamente &#8212; parece estranho, mas funciona.

## Segundo passo

Atualizar os pacotes da versão atual do Magento.

``` bash
./pear install magento-core/Mage_All_Latest-stable
```

## Terceiro passo

Fazer download da última versão do Magento (atualmente a 1.5.1.0):

``` bash
cd shop/
wget http://www.magentocommerce.com/downloads/assets/1.5.1.0/magento-1.5.1.0.tar.gztar -zxvf magento-1.5.1.0.tar.gz
cd magento
cp -rf * ../
cd ..
rm -rf magento/ magento-1.5.1.0.tar.gz
chmod -R o+w media var
chmod o+w app/etc
```

Pronto.

### E se algo der errado?

Se ocorrer algum problema, basta voltar à versão antiga. Para isso:

```
cd shop/cp -rf shop.x.x.x/* ./
```

**Fontes:**
http://dx3webs.com/front/2011/01/correct-out-dated-pear-version-while-installing-magento-1-4-2-1-7-1-1-9-1/</a><br /><a href="http://www.magentocommerce.com/boards/viewthread/219720/#t301761">http://www.magentocommerce.com/boards/viewthread/219720/#t301761
http://www.magentocommerce.com/wiki/groups/227/installing_magento_via_shell_ssh

