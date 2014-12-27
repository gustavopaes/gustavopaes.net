---
layout: post
author: Gustavo Paes
title:  Como converter discos em FAT para NTFS
description: Converta pendrives ou discos particionados em FAT 16 ou FAT 32 para NTFS sem perder seus dados
date: 2010-01-11 12:00pm
categories: blog, windows
---


Pode ser uma boa idéia ter pendrives em FAT32, especialmente para quem possui rádios com entrada USB para ouvir músicas em MP3. Esses aparelhos, assim como televisores _mais antigos_, só conseguem ler pendrives em FAT.

Entretanto, pendrive com grande capacidade pode ser inútil se particionado em FAT. Isso porque **partições em FAT 32 não suportam arquivos maiores que 4GB**.

Se você tem um pendrive ou disco em FAT (16 ou 32), digite a seguinte linha de código no DOS:

    
    convert [letra do driver]: /fs:ntfs
    

O [site da Microsoft](http://www.microsoft.com/brasil/windowsxp/pro/usando/artigos/fat_ntfs.mspx) diz para fazer backup. Eu arrisco sem backup mesmo, nunca tive problemas.

Acredito que o inverso (NTFS para FAT) não seja possível, só formatando.