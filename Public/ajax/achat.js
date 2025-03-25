function refreshPage() {
  location.reload();
}


function del_trans_op(op_id) {
  $.ajax({
    url: "Public/script/delete_trans_op.php",
    method: 'POST',
    data: {
      op_id: op_id
    },
    success: function (data) {}
  })
}

function new_operation_app() {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {
      load_frm_new_appro();
    }
  })
}

$(document).ready(function () {

  function updateProdId(productId) {
    $('#prod_id').val(productId); // Met à jour la valeur de prod_id
  }

  // Exemple d'appel après avoir sélectionné un produit
  $('#num_bon').on('change', function () {
    var selectedProductId = $(this).val(); // Récupère l'ID du produit sélectionné
    updateProdId(selectedProductId); // Met à jour le champ prod_id
  });

  $(document).on('submit', '#formulaire_achat', function (event) {
    event.preventDefault();

    var prodId = $('#prod_id').val();
    if (!prodId) {
      alert('Veuillez sélectionner un produit.');
      return; // Si le champ prod_id est vide, on arrête l'envoi
    }

    $.ajax({
      url: "Public/script/addachat.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        load_frm_new_appro();
        $('#operation').val("Add");
      }
    });
    $('#formulaire_achat')[0].reset();
  });

  $(document).on('change', '#num_bon', function (event) {
    op_id = $(this).val();
    $.ajax({
      url: "Public/script/filter_prod.php",
      method: 'POST',
      data: {
        op_id: op_id
      },
      success: function (data) {
        $('#prod_info').html(data);
      }
    });
  });

  $(document).on('click', '#getachat', function () {
    load_frm_new_appro();
    // alert('Please');
  });

  $(document).on('keyup', '#autocomplete', function () {
    autocomplete_sup();
  });

  $(document).on('click', '.del_op_appro', function () {
    var op_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete.php",
        method: "POST",
        data: {
          op_id: op_id
        },
        success: function (data) {
          alert(data);
          del_trans_op(op_id);
          new_operation_app();
          //load_frm_new_appro();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.end_appro', function () {
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      load_insert_trans_achat($(this).data('id'));
    } else {
      return false;
    }
  });

  $(document).on('click', '.valider_appro', function () {
    if (confirm("Etes-vous sur de vouloir valider cette operation ?")) {
      load_insert_trans_achat_v($(this).data('id'));
    } else {
      return false;
    }
  });

  $(document).on('click', '.new_approv', function () {
    new_operation_approv();
  });

  $(document).on('click', '.del_det_appro', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_appro.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          //alert(data);
          load_frm_new_appro();
        }
      })
    } else {
      return false;
    }
  });


  $(document).on('click', '.del_det_approv', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_approv.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          setInterval(refreshPage, 1000);
        }
      })
    } else {
      return false;
    }
  });
});

function new_operation_approv() {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {
      setInterval(refreshPage, 1000);
    }
  })
}

function load_frm_new_appro() {
  $.ajax({
    url: "Public/partials/form_new_appro.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      search_sup_op("Public/script/list_supplier.php");
      search_art("Public/script/list_products.php");
      search_lot("Public/script/list_lot.php");
    }
  })
}


function search_sup_op(url) {
  $("#autocomplete").autocomplete({
    source: function (request, response) {

      $.ajax({
        url: url,
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
      $('#autocomplete').val(ui.item.label); // display the selected text
      $('#sup_id').val(ui.item.value); // save selected id to input
      //load_frm_supplier(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#sup_id").val(ui.item.value);
      return false;
    },
  });
}

function search_art(url) {
  $("#autocomplete_art").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: url,
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
      $('#autocomplete_art').val(ui.item.label); // display the selected text
      $('#prod_id').val(ui.item.value); // save selected id to input
      load_prod_details(ui.item.value);
      load_prod_qty(ui.item.qty);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete_art").val(ui.item.label);
      $("#prod_id").val(ui.item.value);
      $("#qty").val(ui.item.qty);
      return false;
    },
  });
}

function load_lot(prodId, posId) {
  $.ajax({
    url: "Public/partials/form_list_lot.php",
    method: 'POST',
    data: {
      prodId: prodId,
      posId: posId
    },
    success: function (data) {
      $('#lot').html(data);
    }
  })
}

function load_insert_trans_achat(op_id) {
  $.ajax({

    url: "Public/script/add_trans_achat.php",
    method: "POST",
    data: {
      op_id: op_id
    },
    success: function (data) {
      // alert(data);
      load_frm_new_appro();
    }
  })
}

function load_insert_trans_achat_v(op_id) {
  $.ajax({

    url: "Public/script/add_trans_achat.php",
    method: "POST",
    data: {
      op_id: op_id
    },
    success: function (data) {
      alert(data);
      // load_frm_new_appro();
    }
  })
}

function load_prod_details(prod_id) {
  $.ajax({
    url: "Public/script/fetch_last_appro.php",
    method: "POST",
    data: {
      prod_id: prod_id
    },
    dataType: "json",
    success: function (data) {
      $('#qtedispo').html(data.quantity);
      $('#price').val(data.price);

      $('#qt').focus();
    }
  })
}

function load_prod_qty(qty) {
  $.ajax({
    method: "GET",
    data: {},
    dataType: "json",
    success: function (data) {
      $('#qty').val(qty);
      $('#qt').focus();
    }
  })
}