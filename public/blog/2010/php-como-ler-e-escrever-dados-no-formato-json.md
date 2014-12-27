---
author: Gustavo Paes
title: PHP: Como ler e escrever dados no formato JSON
description: Aprenda a trabalhar com as funções json_encode() e json_decode() para ler e escrever dados no formato JSON.
date: 2010-04-02 12:00pm
categories: blog, programação, php
---

[JSON](http://json.org/) é um formato padrão para intercâmbio de dados, muito utilizado em API, como a do Vimeo, Youtube, Twitter e outros grandes serviços.

Para mim, a grande vantagem do JSON para o XML é a sua sintaxe mais limpa e a facilidade de trabalhar com esse formato em diversas outras linguagens, seja _client_, como o Javascript, seja _server_, como o PHP.

Ao invés de usar um JSON de exemplo qualquer, vamos usar a API do Vimeo, que é simples e retorna os dados em JSON e XML, para que o exemplo fique mais próximo do real.

## API do Vimeo

[Vimeo](http://vimeo.com/) é um YouTube de alto nível. Um dos canais que mais gosto de acompanhar por lá é o de HD, com [vídeos de alta definição](http://vimeo.com/hd) e muito boa qualidade &#8212; técnica.

O site possui quatro APIs. Vamos utilizar o modelo _oEmbed_, que não necessita de cadastro de aplicação e permite obter os principais dados de um determinado vídeo &#8212; título, descrição, autor, código _embed_ entre outros.

Ela pode retornar dados em XML ou em JSON. Usaremos, obviamente, o tipo JSON. Você pode acessar a seguinte URL para ver o retorno:
http://vimeo.com/api/oembed.json?url=http://vimeo.com/13211055

Você verá um código JSON sem indentação, mas que terá a seguinte estrutura:

``` json
{
    "type": "video",
    "version": "1.0",
    "provider_name": "Vimeo",
    "provider_url": "http:\/\/vimeo.com\/",
    "title": "Forest aerials 5D 1080p KAHRS",
    "author_name": "Henning Sandstr\u00f6m",
    "author_url": "http:\/\/vimeo.com\/slarvern",
    "is_plus": "1",
    "html": "<object ...><\/object>",
    "width": "1920",
    "height": "1080",
    "duration": "395",
    "description": "music: Chronik - www.myspace.com\/chronikath\n",
    "thumbnail_url": "http:\/\/ats.vimeo.com\/754\/529\/75452946_640.jpg",
    "thumbnail_width": 640,
    "thumbnail_height": 360,
    "video_id": "13211055"
}
```

## Lendo JSON no PHP

O PHP possui uma função [`json_decode`](http://php.net/json_decode) para decodificar esse formato e deixar as informações disponíveis através de um objeto.

A função recebe apenas um parâmetro, que é o JSON, e retorna o objeto com as informações. Primeiramente devemos então obter o JSON da API do Vimeo:

``` php
<?php
// O Curl irá fazer uma requisição para a API do Vimeo
// e irá receber o JSON com as informações do vídeo.
$curl = curl_init("http://vimeo.com/api/oembed.json?url=http://vimeo.com/13211055");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);

// Faremos o PHP interpretar e reconhecer o JSON que
// recebemos da API do Vimeo.
$encoded = json_decode($json);

// As informações pode ser recuperadas da seguinte forma.
// Resultado do echo: Forest aerials 5D 1080p KAHRS / 395 segundos
echo $encoded->{'title'} . " / " . $encoded->{'duration'} . " segundos";
?>
```

## Escrevendo JSON no PHP

O PHP permite também transformar dados _formatados_ em `Array` para JSON. Para isso podemos usar a função [`json_encode`](http://php.net/json_encode). Também muito simples de usar: basta passar o `Array` para ela que o retorno será uma `string` com o JSON.

``` php
<?php
// Criamos um Array com algumas informações básicas
// de uma pessoa.
$person_info = array(
    "nome" => "Gustavo Paes",
    "idade" => 22,
    "profissao" => "Webmaster",
    "cidade" => utf8_encode("São Paulo"),
    "interesses" => array(utf8_encode("informática"), utf8_encode("programação"), "esportes")
);

// Agora transformamos esse Array em uma String
// formatada em JSON
$json = json_encode($person_info);

echo $json;
?>
```

O resultado será um JSON, que se formatado terá a seguinte estrutura:

``` json
{
    "nome": "Gustavo Paes",
    "idade": 22,
    "profissao": "Webmaster",
    "cidade": "S\u00e3o Paulo",
    "interesses": [
        "inform\u00e1tica",
        "programa\u00e7\u00e3o",
        "esportes"
    ]
}
```

Há um inconveniente nessa função: os dados precisam estar em UTF-8. Portanto, é recomendável usar sempre o [`utf8_encode`](http://php.net/utf8_encode) para evitar que algumas informações sejam perdidas.

