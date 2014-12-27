---
author: Gustavo Paes
title:  Configurando funcionalidades dos botões laterais do mouse no Ubuntu
description: Veja como definir, no Linux, novas ações para os botões extras de seu mouse.
date: 2012-09-16 12:00pm
categories: blog, windows
---

Uma das coisas boas do Windows é que você instala o driver de um hardware e ele que se vira para fazer as configurações necessárias para as funcionalidades do mesmo. Possuo o mouse <a href="http://www.microsoft.com/hardware/en-us/d/comfort-optical-mouse-3000" title="Microsoft Comfort Optical Mouse 3000">Microsoft Comfort Optical 3000</a>, e como você pode ver na imagem do site, ele possui um quinto botão na lateral esquerda.

No Windows, através do software de configuração do mouse, defini que esse botão teria a mesma funcionalidade do click da "rodinha", que é meio difícil de apertar nesse modelo. Mas como fazer isso no Linux Ubuntu?

[Descobri que cada ação do mouse possui um número de 1 a 11](http://wiki.birth-online.de/know-how/software/linux/remapping-mousebuttons "Remapping mouse buttons"). Abaixo a tabela com as funções de cada uma delas.

1.	Left click
2.	Middle click
3.	Right click
4.	Wheel up
5.	Wheel down
6.	Wheel left
7.	Wheel right
8.	Thumb1
9.	Thumb2
10.	ExtBt7
11.	ExtBt8

Meu alvo é fazer com que o click do 5º botão faça a mesma coisa que o evento 2 (Middle Click). Primeiro vou descobrir quais eventos estão registrados no meu mouse. Para isso, preciso descobrir em qual ID está o meu mouse.

	gpaes@cebola:~$ xinput list | grep "id="
	 1 ↳ Virtual core pointer                    	id=2	[master pointer  (3)]
	 2    ↳ Virtual core XTEST pointer              	id=4	[slave  pointer  (2)]
	 3    ↳ Microsoft Microsoft Optical Mouse with Tilt Wheel	id=12	[slave  pointer  (2)]
	 4    ↳ SynPS/2 Synaptics TouchPad              	id=14	[slave  pointer  (2)]
	 5 ↳ Virtual core keyboard                   	id=3	[master keyboard (2)]
	 6     ↳ Virtual core XTEST keyboard             	id=5	[slave  keyboard (3)]
	 7     ↳ Power Button                            	id=6	[slave  keyboard (3)]
	 8     ↳ Video Bus                               	id=7	[slave  keyboard (3)]
	 9     ↳ Video Bus                               	id=8	[slave  keyboard (3)]
	10    ↳ Power Button                            	id=9	[slave  keyboard (3)]
	11 ↳ Sleep Button                            	id=10	[slave  keyboard (3)]
	12    ↳ Laptop_Integrated_Webcam_2HDM           	id=11	[slave  keyboard (3)]
	13    ↳ AT Translated Set 2 keyboard            	id=13	[slave  keyboard (3)]
	14    ↳ Dell WMI hotkeys                        	id=15	[slave  keyboard (3)]

Pelo retorno acima, procure pelo nome do seu mouse. No meu caso, já dito, é um MS. O ID dele é o 12 (na linha 3 do resultado acima). Agora vamos ver o mapeamento dos botões dele:

``` bash
gpaes@cebola:~$ xinput get-button-map 121 2 3 4 5 6 7 8 9 10 11 12 13 
```

Obviamente troque o 12 pelo ID do seu mouse. A sequência de 1 a 13 são as ações que o Linux vai executar quando a ação 1 for solicitada, a ação 2 for solicitada e assim vai, até a 13. Para uma melhor compreenção:

    <número ação para evento 1> <número ação para evento 2> ... <número ação para evento n>

Meu mouse tem 5 botões. Pela tabela de ações, meu mouse pode executar somente até o código 8, que seria o Thumb1 (não me pergunte por que esse nome). Dessa forma, basta colocar na posição oito da sequência o código da ação que eu desejo, no meu caso a mesma do Middle Button (código 2).

``` bash
gpaes@cebola:~$ xinput set-button-map 12 1 2 3 4 5 6 7 2
```

**Atenção:** Troque o primeiro número 12 pelo mesmo ID do seu mouse, descoberto acima.

Perceba que eu não coloquei os códigos de 9 a 13, já que eles são inúteis para o meu mouse. Só de digitar esse comando você já terá o resultado. Faça um teste. Você pode trocar as ações do Left Button com o Right Button se você for canhoto, por exemplo, ou desabilitar ações, colocando 0 no lugar.

Se algo der errado, re-defina a sequência original. Esse código funciona apenas durante a sessão, então é preciso forçar ele sempre a ser executado. Coloque ele no arquivo _~/.xstartup_ (se não existir, crie um).

Espero ter ajudado.

**Fontes:**
http://manpages.ubuntu.com/manpages/lucid/man5/xorg.conf.5.html
http://wiki.birth-online.de/know-how/software/linux/remapping-mousebuttons
https://wiki.ubuntu.com/X/Config/Input

