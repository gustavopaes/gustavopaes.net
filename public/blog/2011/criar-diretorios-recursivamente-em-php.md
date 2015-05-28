---
author: Gustavo Paes
title:  Criar diretórios recursivamente em PHP
description: O PHP não possui uma função que cria diretórios recursivamente. A solução é percorrer todos os diretórios do path desejado e criando aqueles que não existem.
date: 2011-01-16 12:00pm
categories: blog, programação, php
---

**Atualização:** O PHP incluiu -- faz um bom tempo -- um atributo na função `mkdir` que faz a criação de diretórios de forma recursiva nativamente, poupando um bom trabalho do programador.

``` php
bool mkdir ( string $pathname [, int $mode = 0777 [, bool $recursive = false [, resource $context ]]] )
```

Dessa forma, passando `true` no terceiro parâmetro do da função, os diretórios serão criados de forma recursiva:

``` php
$dir = "/home/conta/public_html/projeto/app/diretorio";

mkdir($dir, 0755, true);
```

Mais informçãoes sobre o `mkdir`, acesse: http://php.net/mkdir

----

O PHP &#8212; e outras linguagens &#8212; não traz nenhuma função (ao menos não conheço) que crie diretórios recursivamente. Ou seja, não é possível você passar ao comando `mkdir` o caminho `/path/para/um/diretorio/qualquer` sem que o caminho `/path/para/um/diretorio` já não tenha sido criado.

Para isso, você precisa percorrer diretório por diretório e ir criando aqueles que não existem até chegar ao diretório final. Um trabalho chato mas que feito uma vez basta importar para os demais projetos.

Segue o código que acabei de usar:

``` php
$dir = "/home/conta/public_html/projeto/app/diretorio";
if(!is_dir($dir)) {
  // array com todos os diretórios
  $paths = split("/", $dir);
  // durante o while vai concatenando todos os diretórios
  $partial_path = "/".$paths[0];

  // qual o indice do diretório atual
  $actual_path  = 0;

  while( $actual_path < count($paths) ) {
    if(!is_dir($partial_path)) mkdir($partial_path);

    $partial_path .=  $paths[++$actual_path] . "/";
  }
}
```

Só uma ressalva: é importante definir o path completo, como no próprio exemplo. Isso porque eu concateno ao primeiro diretório uma barra.

