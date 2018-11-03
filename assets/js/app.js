require("bootstrap");
require("../css/app.css");
require("../css/global.scss");
const $ = require("jquery");

$(document).ready(() => {
  $('[data-toggle="popover"]').popover();

  //Categoria y subcategoria, añadiéndose dinámicamente

  let $categoria = $("#producto_categoria");
  let $token = $("#producto_token");
  // When sport gets selected ...
  $categoria.change(function() {
    // ... retrieve the corresponding form.
    var $form = $("#formProducto");
    // Simulate form data, but only include the selected sport value.
    var data = {};
    data[$token.attr("name")] = $token.val();
    data[$categoria.attr("name")] = $categoria.val();
    // Submit data via AJAX to the form's action path.

    $.ajax({
      url: $form.attr("action"),
      type: $form.attr("method"),
      data: data,
      success: function(html) {
        // Replace current position field ...
        $("#producto_SubCategoria").replaceWith(
          // ... with the returned one from the AJAX response.
          $(html).find("#producto_SubCategoria")
        );
        // Position field now displays the appropriate positions.
      }
    });
  });
});
