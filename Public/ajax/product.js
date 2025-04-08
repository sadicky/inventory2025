function refreshPage() {
  location.reload();
}

$(document).ready(function () {


  $(document).on('click', '.trash_art', function (event) {

    prod_id = $(this).attr('id');
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_prod.php",
        method: 'POST',
        data: {
          prod_id: prod_id
        },
        success: function (data) {
          alert(data);
          load_products();
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('click', '#getproducts', function () {
    load_products();
  });

  $(document).on("submit", "#formulaire_product", function (event) {
    // alert('save');
    event.preventDefault();
    $.ajax({
      url: "Public/script/addproduct.php",
      method: "POST",
      data: $("#formulaire_product").serialize(),
      success: function (data) {
        $('#message').html(data).slideDown();
        load_products();
      }
    });
  });

  $(document).on("submit", "#update_product", function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/update_product.php",
      method: "POST",
      data: $("#update_product").serialize(),
      success: function (data) {
        $('#message').html(data).slideDown();
        load_products();
      }
    });
  });

  //prices
  $("#formulaire_product_price").submit(function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/addprice.php",
      method: "POST",
      type: "post",
      data: $("#formulaire_product_price").serialize(),
      success: function (data) {
        $('#message').html(data).slideDown();
        $("#formulaire_product_price")[0].reset();
        setInterval(refreshPage, 1000);
      }
    });
  });

  $('.modifier_product').click(function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    $.ajax({
      url: "Public/script/view_product.php",
      method: "post",
      data: {
        id: id
      },
      success: function (data) {
        $('#edit-product').modal("show");
        $('#details').html(data);
      }
    });
  });

  $(document).on('keyup', '#produit', function () {
    var product = $(this).val();
    $.ajax({
      url: 'Public/script/getProductName.php',
      method: "POST",
      data: {
        product: product
      },
      success: function (d) {
        if (d == 1) {
          $('#available_msg').html('<span class="badge badge-danger">Ce produit existe déjà</span>');
          $('.enreg').attr("disabled", true);
        } else {
          $('#available_msg').html('<span class="badge badge-success">Ce nom est disponible. Vous pouvez l\'ajouter</span>');
          $('.enreg').attr("disabled", false);
        }
      }
    })
  });

  $(document).on('keyup', '#searchProd', function () {
    keyVal = $(this).val();
    $.ajax({
      method: 'GET',
      data: {
        keyVal: keyVal
      },
      url: 'Public/script/get_search_product.php',
      beforeSend: function () {
        $('.res_srch').html("en Chargement ....");
      },
      success: function (data) {
        $('.res_srch').html(data);
      }
    });
  });

  $(document).on('click', '.new_tarif_art', function () {
    price_id = $(this).data('id');
    product_id = $(this).attr('id');
    console.log(price_id);
    console.log(product_id);
    load_frm_tarif_art(product_id, price_id);
  });

  function load_frm_tarif_art(product_id, id) {
    $.ajax({
      url: "Vues/Admin/tarif.php",
      method: 'GET',
      data: {
        product_id: product_id,
        id: id
      },
      beforeSend: function () {
        $('#page-content').html("Chargement ....");
      },
      success: function (data) {
        $('#operation').data("Add");
      }
    })
  }

  //recharger cette fonction toute les secondes
  // setInterval(1000);
  $(".search_products").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: 'Public/script/list_products.php',
        type: 'post',
        dataType: "json",
        data: {
          search: request.term
        },
        success: function (data) {
          response(data);
        }
      });
    },
    select: function (event, ui) {
      $(".search_products").val(ui.item.label);
      $("#prod_id").val(ui.item.value);
      return false;
    },
    select: function (event, ui) {
      $('.search_products').val(ui.item.label); // display the selected text
      $('#prod_id').val(ui.item.value); // save selected id to input
      return false;
    },
  }).autocomplete('instance')._renderItem = function (ul, item) {
    return $("<li>").append("<div class='list-group-item list-group-item-action'>" + item.label + "</div>").appendTo(ul);
  };
});

function load_products() {
  $.ajax({
    url: "Public/partials/products.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      search_art("Public/script/list_products.php");
    }
  })
}