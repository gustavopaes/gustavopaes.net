---
author: Gustavo Paes
title: File.Helper: Manipule de forma mais fácil arquivos
description: Com a classe File.Helper, a manipulação de arquivos fica mais fácil ao permitir métodos encadeados e realizar tratamento de erros.
date: 2010-06-30 12:00pm
categories: blog, programação, php
---

`fopen`, `fclose`, `fwrite`, `rw`, `r+`, `x`, `w+`&hellip; Esqueça tudo isso usando essa classe. Para criar um arquivo, um `save()` basta. Para alterar um arquivo, outro `save()` e está feito. Apagar? `delete()`, claro! E para adicionar um conteúdo? `append()`, só podia ser.

Criar, editar e remover um arquivo no PHP não é complicado. Mas fazer as validações e não esquecer de um `fclose` não é uma simples tarefa.

Essa classe tem o objetivo de ser mais simples e evitar códigos repetitivos.

[Ver código](https://gist.github.com/gustavopaes/6262259)

## Exemplos

### Criando um arquivo:

``` php
$FileHelper->path(".")->file("teste.txt")->content("Esse é o conteúdo do arquivo que será criado")->save();
```

### Adicionando algo ao fim do arquivo:

``` php
$FileHelper->append("Será a última linha do arquivo")->save();
```

### Removendo o arquivo

``` php
$FileHelper->delete();
```

### Criando uma dezena de arquivos no mesmo _path_:

``` php
$arquivos = array("test1.txt", "test2.txt", "test3.txt");
$FileHelper->path("/var/temp/");
foreach($arquivos as $arq) {
    // Irá criar "/var/temp/testX.txt"
    $FileHelper->file($arq)->save();
}
```

