function refreshPage() {
  location.reload();
}

$(document).ready(function () {

  $(document).on('click', '#fournisseurs', function () {
    load_fournisseurs();
  });

  $(document).on('click', '#getavances', function () {
    load_av_salaire('');
  });

  $(document).on('click', '.detail_supplier', function () {
    load_suppliers($(this).data('id'));
  })


  $(document).on('click', '#newsupplier', function () {
    load_new_supplier();
  });

  $(document).on('submit', "#form_supplier", function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/addfournisseur.php",
      method: "POST",
      type: "post",
      data: $("#form_supplier").serialize(),
      success: function (data) {
        $('#message').html(data).slideDown();
        $("#form_supplier")[0].reset();
        // setInterval(refreshPage, 1000);
      }
    });
  });

  $(document).on('click', '#sup_achat', function () {
    load_tab_tiers_achat($('#supplier_id').val(), '', '');
  });

  $("#search_supplier").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: 'Public/script/list_supplier.php',
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
      $("#search_supplier").val(ui.item.label);
      return false;
    }
    // focus: function(event, ui){
    //     $( "#search_supplier" ).val( ui.item.value );
    //     return false;
    // },
  }).autocomplete('instance')._renderItem = function (ul, item) {
    return $("<li>").append("<div class='list-group-item list-group-item-action'>" + item.label + "</div>").appendTo(ul);
  };


  $(document).on("click", ".delete-tiers", function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    if (confirm("Voulez-vous supprimer? ")) {
      $.ajax({
        url: "Public/script/deletetiers.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          $('#message').html(data).slideDown();
          setInterval(refreshPage, 1000);
        }
      });
    } else {
      return false;
    }
  });


  $('.view_data').click(function () {
    var Id = $(this).attr("id");
    $.ajax({
      url: "Public/script/viewtiersbeforedit.php",
      method: "post",
      data: {
        Id: Id
      },
      success: function (data) {
        $('#art_detail').html(data);
        $('#artModal').modal("show");
      }
    });
  });
  //
  $(document).on('click', '.submitarticle', function () {
    $.ajax({
      url: "Public/script/edittiers.php",
      type: "post",
      data: $("#formeditart").serialize(),
      success: function (data) {
        $("#artModal").modal('hide');
        $("#messages").html(data).slideDown();
        setInterval(refreshPage, 1000);
      }

    });
    return false;
  });


  //recharger cette fonction toute les secondes
  // setInterval(1000);

});


function load_tab_tiers_achat(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/hist_achat_supplier.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d
    },
    beforeSend: function () {
      $('#sup_history').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#sup_history').html(data);
      $('.tab').DataTable({
        "bInfo": false,
        "paging": true,
        "bLengthChange": false,
        "ordering": false,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
      });
    }

  })
}

function load_suppliers($id) {
  $.ajax({
    url: "Public/partials/supplier.php",
    method: 'GET',
    data: {
      id: id
    },
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
    }
  })
}

function load_fournisseurs() {
  $.ajax({
    url: "Public/partials/supplier.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
    }
  })
}

function load_av_salaire($id) {
  $.ajax({
    url: "Public/partials/avance.php",
    method: 'GET',
    data: {
      id: id
    },
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      // search_sup_op("Public/script/list_supplier.php");
      // search_art("Public/script/list_products.php");
    }
  })
}

function load_new_supplier() {
  $.ajax({
    url: "Public/partials/new_supplier.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      search_sup_op("Public/script/list_supplier.php");
      // search_art("Public/script/list_products.php");
    }
  })
}