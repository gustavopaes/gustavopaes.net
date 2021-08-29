---
layout: post
author: Gustavo Paes
title:  Obter a estrutura completa de um banco de dados em PHP
description: Veja como obter, com o PHP, todas as tabelas e colunas de um banco de dados.
date: 2011-01-16 12:00pm
categories: blog, programação, php, mysql
---

Às vezes pode ser interessante obter a estrutura completa &#8212; todas as tabelas e suas respectivas colunas e tipos de dados &#8212; de um _database_. Com essas informações é possível, por exemplo, automatizar a criação de formulários ou classes.

É muito fácil fazer isso no MySQL (e, provavelmente, igualmente fácil em postgreSQL). No MySQL você tem que rodar duas `query`. A primeira é usando o <a href="http://dev.mysql.com/doc/refman/5.0/en/show-tables.html" target="_blank">`SHOW`</a>, onde você irá obter todas as tabelas do _database_. E, em seguida, para cada tabela encontrada, você deve executar o <a href="http://dev.mysql.com/doc/refman/5.0/en/describe.html" target="_blank">`DESCRIBE`</a>.

``` php
$conn = mysql_connect("local do banco", "usuario", "senha");
mysql_select_db("database");

// Obtém todas as tabelas do database
$query_tables  = mysql_query("SHOW TABLES");

while($table = mysql_fetch_array($query_tables)) {
  // O nome da tabela
  $table_name = $table[0];

  // Obtém toda a estrutura de dados da tabela
  $query_columns = mysql_query("DESCRIBE {$table_name}");

  while($column = mysql_fetch_array($query_columns)) {
    var_dump($column);
  }
}
```

Dentro do segundo `while` você terá em suas mãos todas as colunas da tabela e suas respectivas estruturas de dados. Um exemplo é o array abaixo:

``` json
array(12) {
  [0]=>  string(4) "nome"
  ["Field"]=>  string(4) "nome"
  [1]=>  string(11) "varchar(50)"
  ["Type"]=>  string(11) "varchar(50)"
  [2]=>  string(3) "YES"
  ["Null"]=>  string(3) "YES"
  [3]=>  string(0) ""
  ["Key"]=>  string(0) ""
  [4]=>  NULL
  ["Default"]=>  NULL
  [5]=>  string(0) ""
  ["Extra"]=>  string(0) ""
}
```

Mais informações no site do MySQL:

http://dev.mysql.com/doc/refman/5.0/en/describe.html
http://dev.mysql.com/doc/refman/5.0/en/show.html
http://dev.mysql.com/doc/refman/5.0/en/show-tables.html
http://dev.mysql.com/doc/refman/5.0/en/extended-show.html

