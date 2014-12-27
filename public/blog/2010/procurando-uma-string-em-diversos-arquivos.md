---
author: Gustavo Paes
title: Procurando uma string em diversos arquivos
description: Realize uma busca em diversos arquivos utilizando os comandos find e xargs.
date: 2010-01-27 12:00pm
categories: blog, programação
---

Tenho utilizado bastante SSH para desenvolvimento de um projeto e várias vezes tenho a necessidade de procurar por alguma função ou string qualquer em diversos arquivos.

[Meu editor no Windows](http://www.activestate.com/komodo-edit "Komodo Editor") faz isso, mas não quando os arquivos estão em FTP. Portanto tenho que fazer a busca via SSH, o que não é das piores coisas. Diria que é até melhor e mais rápido.

Utilizo um "juntado" de `find` com `grep`:

``` bash
find ./ -name "*.php" -print0 | xargs -0 grep "string de pesquisa"
```

Isso vai procurar a **string de pesquisa** em todos os arquivos com extensão `php` do projeto (no caso, `./` quer dizer para procurar em todos os diretórios a partir de onde você digitou o comando). Simples e rápido. Se quiser guardar o resultado em algum arquivo, utilize `>>`:

``` bash
find ./ -name "*.php" -print0 | xargs -0 grep "string de pesquisa" >> resultado.txt
```
