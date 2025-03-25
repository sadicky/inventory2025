function refreshPage() {
  location.reload();
}

$(document).ready(function () {

  $(document).on('click', '#tiers_dep', function () {
    load_frm_tiers_dep($('#supplier_id').val(), '');
  });

  /*Cash debut*/
  $(document).on('click', '.del_trans_2', function () {
    trans_id = $(this).attr("id");
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_trans.php",
        method: "POST",
        data: {
          trans_id: trans_id
        },
        success: function (data) {
          alert(data);
          load_tab_cash_trans_2($('#id').val(), from_d, to_d);
        },
        error: function () {
          alert('La requête n\'a pas abouti');
        }
      })

    } else {
      return false;
    }
  });

  $(document).on('submit', '#form_srch_cash', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    id = $('#id').val();
    load_tab_cash_trans_2(id, from_d, to_d);
  });

  $(document).on('click', '#rpt_cash', function () {
    load_tab_cash_trans_2('', '', '');
  });


  $(document).on('submit', '#form_open_day', function (event) {
    event.preventDefault();
    if (confirm("Etes-vous sur de vouloir ouvrir le journal ?")) {
      $.ajax({
        url: "Public/script/add_open_day.php",
        method: "POST",
        data: new FormData(this),
        // dataType:"json",
        contentType: false,
        processData: false,
        success: function (data) {
          location.reload(true);
        }
      })

    } else {
      return false;
    }
  });


});

function load_frm_tiers_dep(id, trans_id) {
  $.ajax({
    url: "Public/partials/form_tiers_dep.php",
    method: "GET",
    data: {
      id: id,
      trans_id: trans_id
    },
    success: function (data) {
      $('#disp_dep').html(data);
      // $('.number-separator').number(true, 0);
      //   search_field("Public/script/list_dep.php");
    }
  })
}


function load_tab_inventaire(id_per, pos_id) {
  $.ajax({

    url: "Public/partials/tab_inventaire.php",
    method: "POST",
    data: {
      id_per: id_per,
      pos_id: pos_id
    },
    beforeSend: function () {
      $('.details_inv').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      //alert(data);
      $('.details_inv').html(data);
      $('.afficher').hide();
      search_art("Public/script/list_products.php");
      search_lot("Public/script/list_lot.php");
    }

  })
}


function load_tab_cash_trans_2(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_cash_transactions_2.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }

  })
}




function search_field(url) {
  $("#autocomplete_field").autocomplete({
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
      $('#autocomplete_field').val(ui.item.label); // display the selected text
      $('#select_id').val(ui.item.value); // save selected id to input
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete_field").val(ui.item.label);
      $("#select_id").val(ui.item.value);
      return false;
    },
  });
}