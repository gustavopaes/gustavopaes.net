---
layout: post
author: Gustavo Paes
title:  Simulando a variável flash do Rails no PHP
description: Veja como facilitar o envio de mensagens de uma página par outra usando o conceito da variável "flash", do Rails.
date: 2009-10-01 12:00pm
categories: blog, programação, rails
---

Quem programa em Ruby on Rails sabe do que estou falando. A variável flash permite armazenar mensagens durante apenas uma mudança de página. Excelente para avisos e alertas.

O PHP não tem uma variável desse tipo. Uma das soluções usadas é passar um código da mensagem o erro através da url e na página fazer um `switch` ou `if`. Mas essa solução é muito trabalhosa.

Uma outra solução, que se aproxima mais da do Rails é criar uma função que armazena a mensagem em uma sessão e, depois de exibir, limpa os valores. O código é esse:

    
    function flash($var, $value = null){
      if( ! isset($value) ) {
        $val = $_SESSION[$var];
        unset($_SESSION[$var]);
        return $val;
      }
      else
        $_SESSION[$var] = $value;
    }

    function notice(){
      if( isset($_SESSION["type"]) ) {
        echo "<div id=\"notice\" class=\"aviso " .flash("type") . "\">";
        echo "  <p>".flash("message")."</p>";
        echo "</div>";
      }
    }
    

A função notice é apenas para mostrar as mensagens. O uso seria mais ou menos assim:

    [...]
    // Houve sucesso na ação
    if( $acao == true ){
      flash("type", "success");
      flash("message", "A ação foi executada com sucesso");
    } else {
      flash("type", "error");
      flash("message", "Ocorreu um erro!");
    }

    header("location: index.php");
    [...]

No _index.php_ só é preciso chamar a função `notice()`. Estou usando essa solução em um projeto e está sendo bem mais fácil do que o envio de mensagens através da url.

**Importante:** é preciso que todas as páginas tenham o [session_start()](http://br2.php.net/session_start).

