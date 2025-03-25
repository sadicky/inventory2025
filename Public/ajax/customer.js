$(document).ready(function () {

  $(document).on('click', '#all_cust', function () {
    load_customers();
  });

  $(document).on('click', '#all_cust_cred', function () {
    load_customer_credit();
  });

  $(document).on('click', '#newcustomer', function () {
    load_form_customer('');
    // alert('iuhd');
  });

  $(document).on('click', '#cust_sale', function () {
    load_tab_tiers_sale($('#tiers_id').val(), '', '');
  });
  $(document).on('click', '#paiements', function () {
    op_id = $(this).data('id');
    load_tab_payer(op_id);
    //up();
  });

  $(document).on('click', '#show_trans', function () {
    load_tab_tiers_trans($('#tiers_id').val(), '', '');
  });


  $(document).on('click', '#edit_customer', function () {
    load_form_customer($(this).data('id'));
  });

  $(document).on('submit', '#form_client', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/add_customer.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (data) {
        $('#operation').val("Add");
        // setInterval(refreshPage, 1000);
        alert(data);
        load_form_customer(data.id);
      }
    });
  });

  $(document).on('submit', '#form_pay_tiers', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/add_tiers_pay.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        // setInterval(refreshPage, 1000);
        load_form_customer(data.id);
        // alert(data.id);
      }
    });
  });

  $(document).on('submit', '#form_srch_sale_tiers', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#tiers_id').val();
    type = $('#type').val();
    load_tab_tiers_sale(tiers_id, type, from_d, to_d);
  });

  $(document).on('submit', '#form_more_customer', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/insert_more_customer.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        alert(data);
        load_frm_customer($('#cust_id').val());
      }
    });
  });


  $(document).on('submit', '#form_account', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_account.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        alert(data);
        load_frm_customer($('#cust_id').val());
      }
    });
  });

  $(document).on('click', '.edit_cust', function () {
    id = $(this).data('id');
    load_frm_customer(id);
  });
  $(document).on('click', '#tiers_pay', function () {
    load_frm_tiers_pay($('#tiers_id').val(), '');
  });
  $(document).on('click', '.editCust', function () {
    $('#myModal').css("display", "block");

    op_id = $(this).attr('id');
    pers_id = $(this).data('id');
    //$('#cust_id').val(pers_id);

    //alert(op_id);
    $('#op_id_edit').val(op_id);
    //select_cust(pers_id);
  });

  function select_cust(pers_id) {
    $.ajax({
      url: "Public/script/fetch_one_customer.php",
      method: "POST",
      data: {
        pers_id: pers_id
      },
      dataType: "json",
      success: function (data) {
        //alert(data);
        $('#content_lib_cust').val(data.nom);

        $('#nom').val(data.nom);
        $('#tel').val(data.tel);
        $('#email').val(data.email);
        $('#adresse').val(data.adresse);
        $('#cust_code').val(data.cust_code);
        $('#cust_cat').val(data.cust_cat);
        $('#cust_type').val(data.cust_type);
        $('#cust_exp').val(data.cust_exp);
        $('#cust_percent').val(data.cust_percent);
        $('#cust_num').val(data.cust_num);
        $('#cust_tva').val(data.cust_tva);

        $('#personne_id').val(pers_id);
        $('#cust_id').val(pers_id);
      }

    })
  }
  $(document).on('click', '.trash_sale', function (event) {

    table = $('#tab_details').val();
    id = $('#tab_details').data('id');
    val_id = $(this).attr('id');
    prod_id = $('#prod_id').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_op.php",
        method: 'POST',
        data: {
          table: table,
          val_id: val_id,
          id: id
        },
        success: function (data) {
          alert(data);
          if (table == "personne") {
            load_tab_customer()
          }
        }
      });
    } else {
      return false;
    }
  });


  $(document).on('click', '.choose_cust2', function () {
    load_form_customer($(this).attr('id'));
  })

  $(document).on('click', '.close', function () {
    $('#myModal').css("display", "none");;
  });

  $(document).on('submit', '#frm_edit_customer2', function (event) {

    event.preventDefault();
    $.ajax({
      url: "backend/edit_customer.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data); 
        load_frm_new_bon();
      }
    });
  });

});



//FUNCTIONWS
function load_customer_credit() {
  $.ajax({
    url: "Public/script/customer_cred.php",
    method: 'GET',
    beforeSend: function () {
      $("#page-content").html('chargement ...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_form_customer(id) {
  $.ajax({
    url: "Public/partials/customer_new.php",
    method: 'GET',
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('chargement ...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      // $('.number-separator').number( true, 0 );
      search_customer("Public/script/list_cust.php")
      // search_cash(url);
    }
  })
}

function load_tab_payer(op_id) {
  $.ajax({
    url: "Public/partials/form_payer.php",
    method: 'GET',
    data: {
      op_id: op_id
    },
    success: function (data) {
      $('.payer').html(data);
    }
  })
}

function load_customers() {
  $.ajax({
    url: "Public/partials/customers.php",
    method: 'GET',
    data: {},
    beforeSend: function () {
      $("#page-content").html('chargement ...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function search_customer(url) {
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
      load_form_customer(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#tiers_id").val(ui.item.value);
      return false;
    },
  });
}

function search_customer_v(url) {
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
      // load_form_customer(ui.item.value);
      $("#autocomplete").val(ui.item.label);
      $("#cust_id").val(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#cust_id").val(ui.item.value);
      return false;
    },
  });
}


function load_tab_tiers_sale(id, type, from_d, to_d) {
  $.ajax({
    url: "Public/script/tab_hist_sale_tiers.php",
    method: "GET",
    data: {
      id: id,
      type: type,
      from_d: from_d,
      to_d: to_d
    },
    beforeSend: function () {
      $('#cust_history').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#cust_history').html(data);
      $('.afficher').hide();
      $('.tab').dataTable();
    }

  })
}

function load_tab_tiers_trans(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_tiers_transactions.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d
    },
    beforeSend: function () {
      $('#disp_trans').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#disp_trans').html(data);
    }

  })
}

function load_frm_tiers_pay(pos_id, trans_id) {
  $.ajax({

    url: "Public/partials/frm_tiers_pay.php",
    method: "GET",
    data: {
      pos_id: pos_id,
      trans_id: trans_id
    },
    success: function (data) {
      $('#disp_pay').html(data);
      $('.tab').DataTable();
    }
  })
}