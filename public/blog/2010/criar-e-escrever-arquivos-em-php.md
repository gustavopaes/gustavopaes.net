---
layout: post
author: Gustavo Paes
title: Criar e escrever arquivos em PHP
description: Conceitos e exemplos básicos das funções file_get_contents e file_put_contents, utilizadas para ler e escrever, respectivamente, arquivos no PHP.
date: 2010-10-21 12:00pm
categories: blog, programação, php
---

Como em qualquer outra área, você pode fazer as coisas do jeito fácil ou do jeito complicado. As vezes o jeito complicado é o único que você conhece e, portanto, ele é o jeito fácil para você.

Confesso que até ontem o jeito fácil para eu escrever um arquivo era usando o trio `fopen()`, `fwrite()` e `fclose()`.

## Complicado: usando três funções para ler e escrever

Como disse acima, antes de conhecer a função _mágica_, ou eu usava uma <a href="http://gustavopaes.net/blog/2010/file-helper-manipule-de-forma-mais-facil-arquivos.html">classe para trabalhar com arquivos</a> ou usava as três funções básicas de leitura e escrita de arquivos. Portanto, um código padrão de leitura e escrita seria o seguinte:

    <?php
    // Abre o arquivo para leitura e escrita
    $f = fopen("arquivo.txt", "rw+");

    // Lê o conteúdo do arquivo
    $content = "";
    if(filesize("arquivo.txt") > 0)
      $content = fread($f, filesize("arquivo.txt"));

    // Escreve no arquivo
    fwrite($f, "Olá mundo\n");

    // Libera o arquivo
    fclose($f);

    echo $content;
    ?>

## O jeito simples

### Usando `file_get_contents()`

O PHP possui a função `file_get_contents()` que faz exatamente o que o código acima faz &#8212; na parte da leitura. O uso é extremamente simples:

    <?php
    $content = file_get_contents("arquivo.txt");
    echo $content;

    // Ou simplesmente...
    echo file_get_contents("arquivo.txt");
    ?>

Além de arquivos locais, ele permite que você passe uma URL para capturar o conteúdo da página. Para isso, basta informar qual URL deve ser visualizada:

    <?php
    ini_set("allow_url_fopen", TRUE);
    echo file_get_contents("http://www.uol.com.br/");
    ?>

### Usando `file_put_contents()`

Para escrever é a mesma coisa. Só que usamos a função `file_put_contents()` que, além de criar o arquivo caso ele não exista, permite que se concatene um conteúdo.

    <?php
    // Criando um novo arquivo
    file_put_contents("novo.txt", "Primeira linha do arquivo\n");
    
    // Exibe o conteúdo
    echo file_get_contents("novo.txt");

    // Retorno: Primeira linha do arquivo
	
	// Se tentarmos criar uma nova linha
	file_put_contents("novo.txt", "Segunda linha...\n");

	// Vamos perceber que o conteúdo anterior foi perdido
	echo "\n";
	echo file_get_contents("novo.txt");

	// Retorno: Segunda linha...

	// Para concatenar o conteúdo, devemos passar um terceiro parâmetro
	file_put_contents("novo.txt", "Agora sim a segunda linha...", FILE_APPEND);

	echo "\n";
	echo file_get_contents("novo.txt");

	// Retorno:
	// Segunda linha...
	// Agora sim a segunda linha...
	?>

## Conclusão

Não tem muito o que concluir. Usando essas duas funções as chances de erro diminuem bastante. Portanto, sugiro a leitura:
http://br.php.net/file_put_contents
http://br.php.net/file_get_contents
