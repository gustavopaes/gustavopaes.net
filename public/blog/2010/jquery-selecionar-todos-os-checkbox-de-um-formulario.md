---
author: Gustavo Paes
title: jQuery: Selecionar todos os checkbox de um formulário
description: Dê ao usuário a opção de selecionar todos os checkbox de um grupo de uma só vez. O script foi feito usando jQuery e pode ser usado diversas vezes em uma mesma página.
date: 2010-12-07 12:00pm
categories: blog, front-end, javascript
---

Vi muitos _scripts_ por ai usando o jQuery para selecionar todos os _checkbox_ quando o usuário clicasse em alguma opção _"selecionar todos"_. O problema dos códigos era que eles selecionavam **todos** os checkbox da página. Não faz sentido.

Além do mais, os códigos não eram reutilizáveis, exigindo, por exemplo um `id` fixo. O código que fiz abaixo serve para qualquer formulário &#8212; obviamente tem que seguir um padrão HTML para isso &#8212; e seleciona apenas os checkbox que estão no mesmo nível da opção _"selecionar todos"_.

``` javascript
(function() {
  jQuery(function() {
    // Procura pelos <input type="checkbox" name="_discart"> para adicionar
    // o evento de click
    jQuery("form input[type="checkbox"][name="_discart"]").each(function(i, o) {
      // adiciona um evento
      jQuery(this).click(function() {
        // Define o atributo "checked" dos campos em relação ao checkbox "chave"
        jQuery(this).parent().find("input[type="checkbox"]").attr("checked", this.checked ? "checked" : "");
      });

      // Adiciona nos demais checkbox um evento para quando um deles
      // for selecionado, verificar se o checkbox "chave" deve ser
      // selecionado ou não.
      jQuery(this).parent().find("input[type="checkbox"][name!="_discart"]").click(function() {
        var total_checkbox     = jQuery(this).parent().find("input[type="checkbox"][name!="_discart"]").length;
        var total_selecionados = jQuery(this).parent().find("input[type="checkbox"][name!="_discart"]:checked").length
        jQuery(this).parent().find("input[type="checkbox"][name="_discart"]").attr("checked", total_checkbox == total_selecionados ? "checked" : "");
      });
    }); // END each
  })
})();
```

## Adaptando o formulário para funcionar

Para o script funcionar ele precisa de duas coisas básicas:

1. Os checkbox que pertencem a um mesmo grupo devem estar dentro de um `div` ou elemento qualquer;
2. O checkbox _"selecionar todos"_ precisa ter o atributo `name="_discart"`.

``` html
<form name="formulario1">
  <div>
    <label for="form1:name">Nome: </label>
    <input type="text" name="form1:name" id="form1:name" />
  </div>
  <div>
    <label>Opções</label>
    <input type="checkbox" name="opcoes[]" value="opção 1" /> Opção 1
    <input type="checkbox" name="opcoes[]" value="opção 2" /> Opção 2
    <input type="checkbox" name="opcoes[]" value="opção 3" /> Opção 3
    <input type="checkbox" name="opcoes[]" value="opção 4" /> Opção 4
    <input type="checkbox" name="_discart" value="" /> Todas as opções
  </div>
</form>
```

Seguindo essa padronização, o script deve funcionar sem problemas.

