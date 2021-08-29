---
author: Gustavo Paes
title: Fazendo (e restaurando) backup do MySQL via SSH e MySQLDump
description: Aprenda a usar o mysqldump para realizar backup de banco de dados grandes o suficiente para causar erro de timeout.
date: 2010-11-15 12:00pm
categories: blog, mysql
---

Serviços de hospedagem que tem SSH disponível para o cliente são uma benção. Alguns hosts não liberam esse acesso e você só vai perceber o erro que fez ao assinar o plano quando precisar do acesso SSH.

Um dos casos para que você precise do SSH é realizar backup de um banco de dados grande, por exemplo. Hoje fui fazer o backup de uma loja virtual hospedada no UOL Host através da própria administração do [Magento](http://www.magentocommerce.com/). Já havia feito isso várias vezes, mas o banco cresceu de uma forma que o backup demora mais de 60 segundos. O resultado **foi erro PHP indicando _timeout_**.

## Backup com `mysqldump`

A solução foi fazer backup usando o `mysqldump`, direto no servidor, sem problema de timeout, permissão e afins.

O comando é bem simples:

``` sql
mysqldump --opt -h [servidor do banco] -u [usuario] -p [database] > backup.sql
```


Os parâmetros são:

+ **-h servidor do banco** indica o endereço do banco de dados. No caso do UOL Host pode ser algo como _dbmy0001.whservidor.com_, mas pode ser simplesmente _localhost_ em outros;
+ **-u usuario** usuário de acesso;
+ **-p** indica que você irá digitar a senha após o comando;

Trocando as variáveis por valores reais, você terá um comando parecido com isso:

``` sql
mysqldump --opt -h dbmy0021.whservidor.com -u gpaes -p lojaeCommerce > 2010-11-15.database.sql
```


## Restaurando um backup

O processo de restaurar é tão simples quanto o de criar. Ao invés de usarmos o `mysqldump`, usaremos o próprio `mysql` e invertendo o sinal de _caminho_. Agora será do arquivo _.sql_ para o banco de dados.

``` sql
mysql  -h [servidor.mysql.com] -u [usuario] -p [database_name] < [arquivo-para-restaurar.sql]
```


Troque tudo o que estiver entre colchetes pelos dados de seu servidor e pronto. Backup restaurado sem dor de cabeça.

## Automatizando o processo

Se eu não uso um determinado comando todo dia, acabo não lembrando mais dele. Para evitar ter que procurar o comando novamente, criei um arquivo `.sh` -- semelhante ao .BAT do Windows -- que faz isso para mim.

Já logado no SSH, digite:

``` bash
cat > backup-mysql.sh
mysqldump -h [servidor] -u [usuario] -p [database] > backup-mysql.sql

Pressione [ctrl + z]

chmod +x backup-mysql.sh
```

Pronto. Da próxima vez que for fazer o backup basta logar no SSH e digitar: `./backup-mysql.sh` e digitar a senha do usuário do banco de dados.

Veja mais sobre o [`mysqldump`](http://www.google.com.br/search?q=backup+with+mysqldump).

