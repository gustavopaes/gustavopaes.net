---
layout: post
author: Gustavo Paes
title: Fazendo requisição HTTP em Perl
description: Faça requisições HTTP em Perl, usando os módulos HTTP::Request e LWP::UserAgent. Como exemplo, código que altera o status do Twitter usando sua API.
date: 2010-03-29 12:00pm
categories: blog, programação, perl
---

Fui estudar a <dfn title="Application Programming Interface">API</dfn> do Twitter e, para enviar um novo _status_, é preciso fazer uma requisição HTTP enviando via _POST_ o login, a senha e o novo _status_ da conta.

Para fazer isso em Perl usei dois módulos: `HTTP::Request` e `LWP::UserAgent`.

##`HTTP::Request`

Esse módulo prepara toda a requisição, define os cabeçalhos, a <dfn title="Uniform Resource Identifier">URI</dfn> e os parâmetros que deverão ser enviados juntos.

No nosso caso, precisamos informar que o _request_ a ser feito precisa enviar os dados em POST, e que o retorno será um <a title="JavaScript Object Notation" rel="external" href="http://www.json.org/">JSON</a>.

	require HTTP::Request;

	# Login e senha no Twitter
	my($username, $password) = ("login twitter", "senha twitter");

	# Mensagem do status
	my($message) = "Um teste usando a API do Twitter + Perl";

	# Inicia o módulo Request
	my($req) = HTTP::Request->new();

	# Define o envio como POST
	$req->method("POST");

	# Define a URI de envio
	$req->uri("http://api.twitter.com/1/statuses/update.json?status=$message");

	# Pede para aceitar código Javascript como retorno.
	$req->headers('Accept' => 'text/javascript');

	# Envia os dados para a autenticação HTTP, necessária para
	# enviar um novo status no Twitter.
	$req->authorization_basic($username, $password);

Está tudo preparado para fazer a requisição ao servidor do Twitter e enviar o novo _status_. Mas quem vai fazer isso é o módulo `LWP::UserAgent`.

##`LWP::UserAgent`

Esse módulo irá fazer a requisição na URI informada no módulo acima e, depois disso, armazenará o retorno dessa requisição. Dessa forma é possível obter o _status_ e trabalhar em cima dele.

	require LWP::UserAgent;
	$ua = LWP::UserAgent->new;

	# Nesse ponto o request será feito, passando toda a configuração do
	# header definido no módulo Request.
	$response = $ua->request($req);

	print "Status da requisicao: $response->{_rc}\n";
	print "Retorno da requisicao: $response->{_content}\n\n";

No caso do Twitter, se o _status_ for atualizado corretamente, o stauts de retorno da requisição deverá ser 200. Qualquer coisa diferente disso é um erro, seja por falta de informações ou login e senha incorretos.

Para identificar a mensagem de erro, basta analizar o conteúdo do JSON que foi retornado. A mensagem de erro vem no _node_ `error`.

## Conclusão

Segue o código completo que tenho para adicionar _status_ no Twitter.

	#!/usr/bin/perl -w
	use strict;
	use JSON qw/from_json/;
	use Encode qw/encode/;

	require HTTP::Request;
	require LWP::UserAgent;

	if($#ARGV == -1) {
	    print "api.pl username:password \"Minha mensagem entre aspas\"\n";
	    exit();
	}

	# Pega os parâmetros passados
	my($auth, $message) = @ARGV;

	# Separa Login e password
	my($username, $password) = split(":", $auth);

	# Encoda a mensagem para UTF-8, eventando
	# erro de acentuação
	$message = encode("UTF-8", $message);

	# Variáveis que serão usadas mais a frente
	my($req, $ua, $response, $json);
	my($content, $status); # conteúdo retornado pela API do Twitter

	# Cria um request
	$req = HTTP::Request->new();
	$ua = LWP::UserAgent->new;

	# Define o método e url do request
	$req->method("POST");
	$req->uri("http://api.twitter.com/1/statuses/update.json?status=$message");

	# Define headers
	$req->headers('Content-Type' => 'text/javascript');
	$req->headers('Accept' => 'text/javascript');

	# Faz o login
	$req->authorization_basic($username, $password);

	# Faz o request
	$response = $ua->request($req);

	# Pega o retorno
	$content = from_json($response->{_content});

	# Status do retorno
	$status = $response->{_rc};

	# Se houve erro
	if($response->{_rc} != 200) {
	    print "Status.......: $status\n";
	    print "Error message: $content->{error}";
	    print "\n";
	    exit();
	}

	# Mostra ID do status criado
	print "Status...: $response->{_rc}\n";
	print "Status ID: $content->{id}\n";
	exit();

