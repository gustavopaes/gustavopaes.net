---
layout: post
author: Gustavo Paes
title:  Salvar arquivos em UTF-8 no Vim
description: Veja como salvar arquivos em UTF-8 no ótimo editor Vim. O mesmo comando pode ser usado para converter o charset do arquivo para ISO-8859-1 (latin).
date: 2011-05-13 12:00pm
categories: blog, geral
---

Uma dica rápida. Quando você abre um arquivo em UTF-8 em um ambiente que está todo configurado para ISO (latin), você precisa tomar cuidado ao salvá-lo. Isso porque os caracteres vão ficar todos quebrados em produção.

No Vim, para salvar um arquivo usando a codificação UTF-8, use o seguinte comando:

``` bash
:w ++enc=utf-8
```

O mesmo pode ser usado para salvar em ISO, caso você esteja em um ambiente configurado para trabalhar com UTF-8.

**Fonte:** <a href="http://pt.w3support.net/index.php?db=so&#038;id=778069" target="_blank">http://pt.w3support.net/index.php?db=so&#038;id=778069</a>

