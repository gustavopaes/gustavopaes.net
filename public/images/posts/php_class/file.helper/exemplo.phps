<?php
header("Content-Type: text/html; charset=UTF-8");

require "../files.helper.class.php";

// Define o path e o arquivo que serão trabalhados
$FileHelper->path(".")->file("teste.txt");

// Exibe o conteúdo atual
echo "<pre>{$FileHelper->read()}</pre>";

// Escreve um novo conteudo
$FileHelper->content("Hello!\n");

// Exibe o conteúdo atual
echo "<pre>{$FileHelper->read()}</pre>";

// Concatena com mais alguma coisa
$FileHelper->append("\nAnd more!")->save();

// Exibe o conteúdo atual
echo "<pre>{$FileHelper->read()}</pre>";

// Remove o arquivo
$FileHelper->delete();

// verifica se houve algum erro
if( ! empty($FileHelper->error) )
{
	exit( $FileHelper->error );
}


