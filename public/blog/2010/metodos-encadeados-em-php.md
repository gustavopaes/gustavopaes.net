---
author: Gustavo Paes
title: Métodos encadeados em PHP
description: Criar métodos encadeados permite que você chame um método após o outro, sem precisar utilizar a variável de instância.
date: 2010-04-02 12:00pm
categories: blog, programação, php
---

O termo **métodos encadeados** é usado quando você chama um método após o outro sem a necessidade da variável de instância do objeto. Veja o exemplo abaixo, do _framework_ [CodeIgniter](http://codeigniter.com/):

``` php
$this->db->select("title")->from("mytable")->where("id", $id)->limit(10, 20);
```

## Criando um método encadeado

Criar um método que permite a chamada de outro método é muito simples. O retorno dele deve ser a referência à instância, ou seja, `$this;`. A classe abaixo demonstra dois métodos que permitem ser encadeados.

``` php
<php
class Calculadora {
    private $valor = 0;

    public function Calculadora($init = 0) {
        $this->valor = $init;
    }

    public function soma($valor = 0) {
        $this->valor += $valor;
        return $this;
    }

    public function subtrai($valor = 0) {
        $this->valor -= $valor;
        return $this;
    }

    public function getValor() {
        return $this->valor;
    }
}

// Exemplo de uso
$calculadora = new Calculadora(10);
$calculadora->soma(5)->subtrai(3)->soma(10);

echo $calculadora->getValor(); // 22
?>
```

## Algumas considerações

Nem todos os métodos devem permitir ser encadeados, até porque alguns devem retornar de fato algum valor ou estado, como no exemplo acima onde `getValor` retora o valor atual da calculadora.

É importante que os métodos que executam rotinas retornem `true` ou `false` ou que seja possível obter o status da última execução através de algum outro método. Sem isso pode ficar difícil saber o que foi executado e realizado com sucesso ou onde ocorreu o erro &#8212; em qual dos métodos.

