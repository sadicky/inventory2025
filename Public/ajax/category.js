function refreshPage() {
  location.reload();
}

$(document).ready(function () {
  $(document).on('click', '#getcategories', function () {
    load_category();
  });
  $(document).on('click', '#allstocks', function () {
    load_prod_tab();
  });
  $(document).on('submit', '#form_category', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/addcategory.php",
      method: "POST",
      data: $("#form_category").serialize(),
      success: function (data) {
        load_category();
      }
    });
  });

  $(document).on('click', '.cat_products', function () {
    cat_id = $(this).data('id');
    alpha = $('#alpha').val();
    load_prod_tab(cat_id, alpha);

  });


  //recharger cette fonction toute les secondes
  // setInterval(1000);

});

function load_prod_tab(cat_id, alpha) {
  $.ajax({

    url: "Public/partials/tab_products.php",
    method: 'GET',
    data: {
      cat_id: cat_id,
      alpha: alpha
    },
    beforeSend: function () {
      $("#page-content").html('Chargement...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();

    }
  })
}

function load_category() {
  $.ajax({
    url: "Public/partials/categories.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      // search_sup_op("Public/script/list_supplier.php");
      // search_art("Public/script/list_products.php");
      // search_lot("Public/script/list_lot.php");
    }
  })
}