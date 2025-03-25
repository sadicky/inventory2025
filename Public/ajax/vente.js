function refreshPage() {
  location.reload();
}
$(function () {

  // load_tab_user_jour();
  // load_frm_sale();


  $(document).on('click', '#effacer', function () {
    $('#cust_id').val('');
    $('#ben_id').val('');
  });


  $(document).on('keyup', '#med_crt_t', function () {
    cust_id = $("#cust_id option:selected").text();
    cust = $("#cust_id").val();

    if (cust == '') {
      alert('Veuillez sélectionner un client.');
      return; // Si le champ cust est vide, on arrête l'envoi
    }

    tarId = $('#tar_id').val();
    rech = $(this).val();

    load_current_tarif(tarId, rech, cust);
  });

  $(document).on('change', '#tar_id', function () {
    tarif = $("#tar_id option:selected").text();
    tarId = $(this).val();
    rech = $('#med_crt_t').val();
    load_current_tarif(tarId, rech, '');
    load_prod_prio(tarId);
  });


  $(document).on('submit', '#frm_add_sale_customer', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_sale_customer.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_frm_sale();
      }
    });
  });

  $(document).on('keyup', '#ch_rec', function () {
    ch_paid = parseFloat($('#ch_paid').val());
    ch_receipt = parseFloat($(this).val());

    ch_back = ch_paid - ch_receipt;

    $('#ch_back').val(parseFloat(ch_back).toString());
  });


  $(document).on('click', '.select_prod_sale', function () {

    prod_id = $(this).attr('id');
    tar_id = $('#tar_id').val();

    $('#prod_id').val(prod_id);
    $('#prod_name').val($(this).data('id'));
    $('#tar_id_v').val(tar_id);
    $('#cust_ass').val(tar_id);

    select_price(prod_id, tar_id);
    // load_equiv_prod(prod_id, tar_id);
  })

  $(document).on('click', '.valider_vente', function () {
    op_id = $(this).attr('id');
    if (confirm("Etes-vous sur de vouloir valider cette vente ?")) {
      $.ajax({
        url: "Public/script/update_valider_vente.php",
        method: 'POST',
        data: {
          op_id: op_id
        },
        success: function (data) {
          setInterval(refreshPage, 1000);
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('click', '.rmv_bon', function () {
    op_id = $(this).attr('id');
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/rmv_bon.php",
        method: 'POST',
        data: {
          op_id: op_id
        },
        success: function (data) {
          load_frm_new_sale($('#id').val());
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('submit', '#form_add_red', function (event) {
    event.preventDefault();
    op_id = $('#op_id_red').val();
    red = $('#val_red').val();
    $.ajax({
      url: "Public/script/insert_red.php",
      method: 'POST',
      data: {
        op_id: op_id,
        red: red
      },
      success: function (data) {
        alert(data);
        // load_frm_sale();
      }
    });
  });

  $(document).on('click', '#no_app', function () {
    load_tab_hist_fact_no_app();
  });

  $(document).on('click', '#pos-cash', function () {
    load_frm_sale();
  });

  $(document).on('click', '.market', function () {
    id = $(this).attr('id');
    load_market(id);
  });


  $(document).on('click', '#non_valide_fact', function () {
    load_facture_encours();
  });

  $(document).on('click', '#pos-dette', function () {
    load_frm_dette();
  });

  $(document).on('click', '#pos-proformat', function () {
    load_frm_proformat();
  });
  $(document).on('click', '#valorisations', function () {
    // load_tab_val('');
    load_frm_val('');
  });

  $(document).on('click', '#valorisations_vente', function () {
    load_tab_val_vente('', '', '');
  });

  $(document).on('click', '#valorisations_dette', function () {
    load_tab_val_dette('', '', '');
  });

  $(document).on('click', '#empty_op', function () {

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/empty_op.php",
        method: "POST",
        success: function (data) {
          alert(data);
          load_tab_hist_fact_no_app();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('submit', '#frm_note', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/insert_note.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        load_frm_new_sale($('#id').val());
      }
    });
  });


  $(document).on('click', '.add_sale_markets', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/insert_pay_facture.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        load_market();
      }
    });
  });

  $(document).on('click', '.repaid_trans', function () {
    op_id = $(this).attr('id');
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/insert_pay_fact_crt.php",
        method: 'POST',
        data: {
          op_id: op_id
        },
        success: function (data) {
          load_tab_hist_sale(from_d, to_d, $('#pos_id').val(), $('#id').val());
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.refresh_trans', function () {
    op_id = $(this).data('id');
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();
    if (confirm("Etes-vous sur de vouloir actualiser le montant ?")) {
      $.ajax({
        url: "Public/script/refresh_trans_op.php",
        method: "POST",
        data: {
          op_id: op_id
        },
        success: function (data) {
          alert(data);
          load_tab_rpt_sale(tiers_id, from_d, to_d);
        },
        error: function () {
          alert('La requête n\'a pas abouti');
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.del_trans_crt', function () {
    trans_id = $(this).attr("id");
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_trans_crt.php",
        method: "POST",
        data: {
          trans_id: trans_id
        },
        success: function (data) {
          alert(data);
          load_tab_rpt_sale(tiers_id, from_d, to_d);
        },
        error: function () {
          alert('La requête n\'a pas abouti');
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '#change_jour', function () {
    jourId = $(this).data('id');
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {

      $.ajax({
        url: "Public/script/change_jour_state.php",
        method: 'POST',
        data: {
          jourId,
          jourId
        },
        success: function (data) {
          //alert(data);
          location.reload(true);
        }
      });
    } else {
      return false;
    }
    //alert(jourId);
  });

  $(document).on('blur', '.edit_det_op', function () {

    val = $(this).html();
    val = val.replace('<br>', '');
    val = val.trim();
    det_id = $(this).attr('id');
    field = $(this).data('id');
    $.ajax({
      url: "Public/script/edit_det_op.php",
      method: "POST",
      data: {
        val: val,
        det_id: det_id,
        field: field
      },
      success: function (data) {
        //alert(data);
      }
    });


  });

  $(document).on('click', '#rpt_sale', function () {
    load_tab_rpt_sale('', '', '');
  });

  $(document).on('click', '#rpt_dette', function () {
    load_tab_rpt_dette('');
  });
  $(document).on('click', '#rpt_prof', function () {
    load_tab_rpt_prof('', '', '');
  });
  $(document).on('submit', '#form_srch_rpt_sale', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();
    load_tab_rpt_sale(tiers_id, from_d, to_d);
  });

  $(document).on('submit', '#form_srch_rpt_dette', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();
    load_tab_rpt_dette(tiers_id, from_d, to_d);
  });

  $(document).on('submit', '#form_srch_valorisation', function (event) {
    event.preventDefault();
    pos_id = $('#pos_id').val();
    cat_id = $('#cat_id').val();
    load_tab_val(pos_id, cat_id);
  });

  $(document).on('submit', '#form_srch_rpt_prof', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();
    load_tab_rpt_prof(tiers_id, from_d, to_d);
  });

  $(document).on('submit', '#form_srch_rpt_val', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    tiers_id = $('#id').val();
    load_tab_val_vente(tiers_id, from_d, to_d);
  });

  $(document).on('click', '#disp_facture', function () {

    $.ajax({
      url: "Public/script/tab_facture.php",
      method: "POST",
      success: function (data) {
        $('#show_fact').html(data);
        $('.tab').dataTable();
      }
    })
  })

  $(document).on('click', '#bon_to_fact', function () {
    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      bon_to_fact($(this).data('id'));
    } else {
      return false;
    }
  });

  $(document).on('keyup', '#cust_num', function () {
    var code = $(this).val();
    $.ajax({
      url: 'Public/script/check_cust_num.php',
      method: "POST",
      data: {
        code: code
      },
      success: function (data) {
        //alert(data);
        if (data != '0') {
          $('#check_message').html('<span class="text-danger">Le NIF est déjà enregistré</span>');
          $('#Enregistrer').attr("disabled", true);
        } else {
          $('#check_message').html('');
          $('#Enregistrer').attr("disabled", false);
        }
      }
    })
  });
  $(document).on('click', '.del_det_hist', function () {
    var det_id = $(this).attr("id");

    var user = $('#user_rap').val();
    var from_d = $('#datepicker').val();
    var to_d = $('#datepicker2').val();
    var pos = $('#pos_rap').val();

    $.ajax({
      url: "Public/script/delete_vente.php",
      method: "POST",
      data: {
        det_id: det_id
      },
      success: function (data) {
        //alert(data);
        load_hit_vente_tab(user, from_d, to_d, pos);
      },
      error: function () {
        alert('La requête n\'a pas abouti');
      }
    })

  });

  $(document).on('click', '.del_op_sale_hist', function () {
    var op_id = $(this).attr("id");
    var user = $('#user_rap').val();
    var from_d = $('#datepicker').val();
    var to_d = $('#datepicker2').val();
    var pos = $('#pos_rap').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete.php",
        method: "POST",
        data: {
          op_id: op_id
        },
        success: function (data) {
          load_hit_vente_tab(user, from_d, to_d, pos);
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('submit', '#frm_new_prod_tar', function (event) {

    cat_id = $('#cat_id').val();
    event.preventDefault();
    $.ajax({
      url: "Public/script/insert_product.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {

        alert(data);
        load_tarif_v(cat_id, '');
      }
    });
    $('#frm_new_prod_tar')[0].reset();
  });

  $(document).on('click', '.row_op_vente', function () {
    var op_id = $(this).data("id");

    $.ajax({
      url: "Public/script/fetch_op_vente.php",
      method: "POST",
      data: {
        op_id: op_id
      },
      success: function (data) {
        //alert(data);
        load_frm_new_sale($('#id').val());
      }
    })

  });


  $(document).on('click', '.delete_prod', function () {
    var prod_id = $(this).attr("id");
    cat_id = $('#cat_id').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_prod.php",
        method: "POST",
        data: {
          prod_id: prod_id
        },
        success: function (data) {
          load_tarif_v(cat_id, '');
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('change', '.cat-srch', function () {
    cat_id = $(this).val();
    load_tarif_v(cat_id, '');
  });

  $(document).on('click', '#tarif_v', function () {
    load_tarif_v('', '');
  });

  $(document).on('click', '.tarif_v', function () {
    load_tarif_v($(this).data('id'), $(this).attr('id'));
  });

  $(document).on('click', '#hist_pay', function () {
    load_frm_hist_pay();
  });

  $(document).on('click', '#hist_vente', function () {
    load_srch_hist_vente_tab();
  });

  $(document).on('submit', '#frm_search_hist_vente', function (event) {

    event.preventDefault();
    var user = $('#user_rap').val();
    var from_d = $('#datepicker').val();
    var to_d = $('#datepicker2').val();
    var pos = $('#pos_rap').val();

    load_hit_vente_tab(user, from_d, to_d, pos);


  });



  $(document).on('click', '#op_vente_jour', function () {
    date_from = '';
    date_to = '';
    jour = '';
    load_tab_prod_sale_jour(date_from, date_to, jour);
  });

  $(document).on('submit', '#jr-search', function (event) {
    event.preventDefault();
    date_from = $('#date_from').val();
    date_to = $('#date_to').val();
    jour = '';
    load_tab_prod_sale_jour(date_from, date_to, jour);
  });

  $(document).on('click', '.crt-jr', function () {
    date_from = $('#date_from').val();
    date_to = $('#date_to').val();
    jour = $(this).data('id');
    load_tab_prod_sale_jour(date_from, date_to, jour);
  });

  $(document).on('click', '#print_main', function () {
    var printable = 'main_report';
    printData(printable);
  });

  $(document).on('click', '#print_facture', function () {
    var printable = 'facture';
    printData(printable);
  });

  $(document).on('click', '.print_this', function () {
    //alert('iii');
    var printable = 'facture' + $(this).data('id');
    printData(printable);
  });

  // $(document).on('click', '.print_fac', function () {
  //   // alert('iii');
  //   var printable = 'facture' + $(this).data('id');
  //   // alert(printable);
  //   printData(printable);
  // });
  $(document).on('click', '.print_rec', function () {
    //alert('iii');
    var printable = 'rec' + $(this).data('id');
    printData(printable);
  });

  $(document).on('click', '#print_bon_liv', function () {
    var printable = 'bon_liv';
    printData(printable);
  });

  $(document).on('click', '#print_bon_proformat', function () {
    var printable = 'bon_proformat';
    printData(printable);
  });



  $(document).on('click', '.end_sale', function () {
    ajust_num($(this).attr('id'));
    load_frm_sale();
  });

  $(document).on('click', '.end_sale_market', function () {
    // ajust_op($(this).attr('id'));
    load_market();
  });

  $(document).on('click', '.enreg_facture', function () {
    ajust_op($(this).attr('id'));
    // load_market();
  });

  $(document).on('click', '.add_sale_market', function () {
    ajust_op($(this).attr('id'));
    load_market();
  });

  $(document).on('click', '.edit_cust', function () {
    id = $(this).data('id');
    load_frm_customer(id);
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

  $(document).on('click', '.close', function () {
    $('#myModal').css("display", "none");;
  });



  $(document).on('click', '#bl', function () {
    load_frm_new_bon();
  });

  $(document).on('click', '#send_sale', function () {

    op_id = $('#crt_op_id').val();
    load_addInvoice(op_id);
    pay_fact(op_id);
    load_frm_new_sale();
  });

  $(document).on('click', '#check_num', function () {

    nif = $('#cust_num').val();
    load_checkTIN(nif);
  });

  $(document).on('click', '#cancel_sale', function () {
    if (confirm("Etes-vous sur de vouloir annuler la facture ?")) {
      op_id = $('#crt_op_id').val();
      //load_cancelInvoice(op_id);
      cancel_trans_op(op_id);
      load_frm_new_sale($('#id').val());
    } else {
      return false;
    }
  });

  $(document).on('click', '#print_rp', function () {
    var printable = 'rapport';
    printData(printable);
  });

  $(document).on('click', '#close_day', function () {
    load_form_close_day();
  });
  $(document).on('submit', '#frm_close_day', function (event) {

    event.preventDefault();
    operation = $('#operation').val();
    if (confirm("Etes-vous sur de vouloir ouvrir le journal ?")) {
      $.ajax({
        url: "Public/script/insert_close_day.php",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        success: function (data) {
          location.href = 'logout.php?logout=true';
        }
      })

    } else {
      return false;
    }
  });

  $(document).on('click', '.new_aut_fv', function () {
    $('#myModalAutFV').css("display", "block");
  });

  $(document).on('click', '.close', function () {
    $('#myModalAutFV').css("display", "none");
  });

  $(document).on('click', '.row_cust_pay', function () {
    sup_id = $(this).data('id');
    op_id = $(this).attr('id');
    load_frm_cust_paie(sup_id, op_id);
    up();
  });

  $(document).on('change', '#tar_id_v', function () {
    prod_id = $('#prod_id').val();
    tar_id = $(this).val();
    pos_id = $('#pos_id_v').val();
    //load_lot(prod_id,pos_id,tar_id);
    select_price(prod_id, tar_id);
  })

  $(document).on('click', '.choose_lot_v', function () {
    prod_id = $(this).attr('id');
    tar_id = $('#tar_id_v').val();
    pos_id = $('#pos_id_v').val();
    load_lot(prod_id, pos_id, tar_id);
  })

  $(document).on('change', '#pos_id_v', function () {
    prod_id = $('#prod_id').val();
    tar_id = $('#tar_id_v').val();
    pos_id = $(this).val();
    load_lot(prod_id, pos_id, tar_id);
  })

  $(document).on('click', '.choose_prod_v', function () {

    $('#prod_id').val($(this).attr('id'));
    $('#prod_equiv').val($(this).attr('id'));
    tar_id = $('#tar_id_v').val();

    $('#content_lib_prod_v').val($(this).data('id'));
    $('#content_list_prod_v').hide();
    prod_id = $(this).attr('id');
    $('#price').focus();
    select_price(prod_id);
  })

  $(document).on('keyup', '#content_lib_prod_v', function () {
    autocomplete_prod_v();
  });

  $(document).on('click', '.editDate', function () {
    $('#myModalDate').css("display", "block");
    op_id = $(this).attr('id');
    select_op(op_id);
  });

  $(document).on('click', '.editNum', function () {
    $('#myModalNum').css("display", "block");
    op_id = $(this).attr('id');
    $('#op_edit_num').val(op_id);
  });

  $(document).on('click', '.new_aut_f', function () {
    $('#myModalAutF').css("display", "block");
  });

  $(document).on('click', '.close', function () {
    $('#myModalAutF').css("display", "none");
    $('#myModalDate').css("display", "none");
    $('#myModalNum').css("display", "none");
  });

  $(document).on('submit', '#frm_edit_date_op', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/edit_date_op.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
      }
    });

    load_frm_new_sale();
  });

  $(document).on('keyup', '#content_lib_cust', function () {
    autocomplete_cust($(this).val());
    $('#cust_id').val('');
  });

  $(document).on('keyup', '#autocomplete_agent', function () {
    autocomplete_agent($(this).val());
    search_agent('Public/script/list_agents.php');
    $('#autocomplete_agent').focus();
  });

  $(document).on('keyup', '#content_srch_cust', function () {
    autocomplete_cust($(this).val());
  });

  $(document).on('submit', '#form_sale', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/add_sale.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {

        // alert(data);
        $('#operation').val("Add");
        load_frm_sale();
      }
    });

    $('#frm_sale')[0].reset();
  });

  $(document).on('submit', '#formulaire_market', function (event) {
    event.preventDefault();

    cust = $("#cust_id").val();

    if (cust == '') {
      console.log('Veuillez sélectionner un client.');
      return; // Si le champ cust est vide, on arrête l'envoi
    }

    $.ajax({
      url: "Public/script/add_vente.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        $('#operation').val("Add");
        load_market();
      }
    });

    $('#formulaire_market')[0].reset();
  });

  $(document).on('submit', '#frm_add_bon', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_bon.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_frm_new_sale($('#id').val());
      }
    });
  });

  $(document).on('submit', '#frm_join_bon', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/join_bon.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_frm_new_sale($('#id').val());
      }
    });
  });

  $(document).on('submit', '#frm_new_bon', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/insert_bon.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {

        //if(data!='') {alert(data);}
        $('#operation').val("Add");
        load_frm_new_bon();
      }
    });

    $('#frm_new_bon')[0].reset();
  });

  $(document).on('submit', '#frm_edit_customer', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/edit_customer.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_frm_new_sale();
      }
    });

    //$('#myModal').css("display","none");


  });

  $(document).on('submit', '#frm_edit_num_vente', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/edit_num.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_frm_new_sale();
      }
    });

    //$('#myModal').css("display","none");


  });




  $(document).on('click', '.del_op_sale', function () {
    var op_id = $(this).attr("id");
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete.php",
        method: "POST",
        data: {
          op_id: op_id
        },
        success: function (data) {
          alert(data);
          new_operation_v($('#id').val());
          //load_frm_new_sale($('#id').val());
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.del_op_bl', function () {
    var op_id = $(this).attr("id");
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete.php",
        method: "POST",
        data: {
          op_id: op_id
        },
        success: function (data) {
          alert(data);
          load_frm_new_bon();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.del_det_sale', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_sale.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          //alert(data);
          load_frm_sale();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.del_det_market', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_sale.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          //alert(data);
          load_market();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.del_det_bon', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_bon.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          //alert(data);
          load_frm_new_bon();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '.delete_op', function () {
    var val_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_op.php",
        method: "POST",
        data: {
          val_id: val_id
        },
        success: function (data) {
          setInterval(refreshPage, 1000);
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '#hist_sale', function () {
    load_tab_hist_sale('', '', '', '');
  });

  $(document).on('click', '#hist_repa', function () {
    load_tab_hist_repa('', '', '', '');
  });

  $(document).on('click', '#hist_dette', function () {
    load_tab_hist_dette('', '', '', '');
  });

  $(document).on('click', '#hist_bl', function () {
    load_tab_hist_bl('', '', '');
  });

  $(document).on('submit', '#sale-search', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    id = $('#id').val();
    load_tab_hist_sale(from_d, to_d, $('#pos_id').val(), id);
  });
  $(document).on('submit', '#repa-search', function (event) {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_repa(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('click', '.conv_prof', function () {
    op_id = $(this).data('id');
    type = $(this).attr('id');
    // alert('op_id =' + op_id + ' type =' + type);
    convert_prof(op_id, type);
  });


  $(document).on('submit', '#dette-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    id = $('#id').val();
    load_tab_hist_dette(from_d, to_d, $('#pos_id').val(), id);
  });

  $(document).on('submit', '#bl-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_bl(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('submit', '#bl-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_bl(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('click', '.row_edit_sale_hist', function (event) {
    sale_id = $(this).data('id');
    $.ajax({
      url: "Public/script/create_session.php",
      method: 'POST',
      data: {
        sale_id: sale_id
      },
      success: function (data) {
        load_frm_sale();
      }
    });
  });

  $(document).on('click', '.row_edit_bl_hist', function (event) {
    sale_id = $(this).data('id');
    $.ajax({
      url: "Public/script/create_session.php",
      method: 'POST',
      data: {
        bon_id: sale_id
      },
      success: function (data) {
        load_frm_new_bon();
      }
    });
  });

  $(document).on('click', '.new_sale', function () {
    new_operation_v($(this).data('id'));
  });

  $(document).on('click', '.new_sale_market', function () {
    new_operation();
  });

  $(document).on('click', '.new_bon', function () {
    new_operation_b();
  });




  $(document).on('click', '.cust_det_pay', function () {
    cust_id = $(this).data('id');
    op_id = '';
    load_frm_cust_paie(cust_id, op_id);
  });

  $(document).on('click', '.row_cust_pay', function () {
    cust_id = $(this).data('id');
    op_id = $(this).attr('id');
    load_frm_cust_paie(cust_id, op_id);
  });





  $(document).on('click', '#bl', function () {
    load_frm_new_bon();
  });

  $(document).on('click', '#new_sale', function () {
    load_frm_new_sale($(this).data('id'));
  });

  $(document).on('click', '#new_credit', function () {
    load_frm_new_sale($(this).data('id'));
  });



  /*fin */
})

function load_frm_new_sale(id) {
  $.ajax({
    url: "Public/script/frm_new_sale.php",
    method: 'GET',
    data: {
      id: id
    },
    success: function (data) {
      $('#page-content').html(data);
      search_cust_v('Public/script/list_cust.php');
      search_art_v('Public/script/list_prod.php');
      search_agent("Public/script/list_agents.php");
      $('#autocomplete').focus();
      $('#autocomplete_art').focus();
      $('#autocomplete_agent').focus();
    }
  })
}


function search_art_v(url) {
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
      //load_frm_supplier(ui.item.value);
      select_price(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete_art").val(ui.item.label);
      $("#prod_id").val(ui.item.value);
      return false;
    },
  });
}

function load_frm_new_bon() {
  $.ajax({
    url: "forms/frm_new_bon.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('#page-content').html(data);
      $('.tab').dataTable({
        'Ordering': false,
      });
      search_cust_v('Public/script/list_cust.php');
      search_art_v('Public/script/list_prod.php');
      search_agent('Public/script/list_agents.php');
      $('#autocomplete_art').focus();
      $('#autocomplete_agent').focus();
    }
  })
}

function load_frm_cust_paie(cust_id, op_id) {
  $.ajax({
    url: "forms/frm_cust_paie.php",
    method: 'POST',
    data: {
      cust_id: cust_id,
      op_id: op_id
    },
    beforeSend: function () {
      $('.cust_paie').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('.cust_paie').html(data);
      $('.tab').dataTable();
    }
  })
}

function autocomplete_cust(keyword) {
  keyword = keyword;
  $.ajax({
    url: 'Public/script/list_cust.php',
    type: 'POST',
    data: {
      keyword: keyword
    },
    success: function (data) {
      $('#content_list_cust').show();
      $('#content_list_cust').html(data);
    }
  });
}

function autocomplete_agent(keyword) {
  keyword = keyword;
  $.ajax({
    url: 'Public/script/list_agents.php',
    type: 'POST',
    data: {
      search: keyword
    },
    success: function (data) {
      $('#content_list_agent').show();
      $('#content_list_agent').html(data);
    }
  });
}



function select_ben(ben_id) {
  $.ajax({
    url: "Public/script/fetch_one_ben.php",
    method: "POST",
    data: {
      ben_id: ben_id
    },
    dataType: "json",
    success: function (data) {
      //alert(data);
      $('#ben_name').val(data.nom);
      $('#ben_typ').val(data.typ);
      $('#ben_id').val(ben_id);
    }

  })
}

function select_op(op_id) {
  $.ajax({
    url: "Public/script/fetch_one_op.php",
    method: "POST",
    data: {
      op_id: op_id
    },
    dataType: "json",
    success: function (data) {

      $('#date_op').val(data.date_op);
      $('#op_type').val(data.op_type);
      $('#op_edit_date').val(op_id);
    }

  })
}

function autocomplete_prod_v() {
  keyword = $('#content_lib_prod_v').val();
  $.ajax({
    url: 'Public/script/list_prod_v.php',
    type: 'POST',
    data: {
      keyword: keyword
    },
    success: function (data) {
      $('#content_list_prod_v').show();
      $('#content_list_prod_v').html(data);
    }
  });
}

function select_price(prod_id, tar_id) {
  $.ajax({
    url: "Public/script/fetch_last_vente.php",
    method: "POST",
    data: {
      prod_id: prod_id,
      tar_id: tar_id
    },
    dataType: "json",
    success: function (data) {
      $('#price').val(data.price);
      $('#percent').val('0');
      /*$('#prod_prix').val(data.prod_pua);
      $('#benef').val(data.benef);*/
      $('#qt').focus();
      //alert(data);
    }
  })
}

function load_form_close_day() {
  $.ajax({
    type: 'GET',
    url: 'forms/frm_close_day.php',
    success: function (data) {
      $('#page-content').html(data);
    }
  });
}

function printData(printable) {
  var divToPrint = document.getElementById(printable);
  newWin = window.open("");
  newWin.document.write(divToPrint.outerHTML);
  newWin.print();
  newWin.close();
}

$(document).on("click", ".print_fac", function (event) {
  event.preventDefault();
  var op_id = $(this).data('id');
  $.ajax({
    url: 'Public/script/tab_crt_facture_.php',
    type: 'post',
    data: {
      op_id: op_id
    },
    dataType: 'text',
    success: function (response) {
      var mywindow = window.open('', 'Facture', 'height=28,7', 'width=20');
      mywindow.document.write('<html><head><title>Facture</title>');
      mywindow.document.write('</head><body>');
      mywindow.document.write(response);
      mywindow.document.write('</body></html>');

      mywindow.document.close(); // necessary for IE >= 10
      mywindow.focus(); // necessary for IE >= 10
      mywindow.resizeTo(screen.width, screen.height);
      setTimeout(function () {
        mywindow.print();
        mywindow.close();
      }, 1250);

      //mywindow.print();
      //mywindow.close();

    } // /success function
  }); // /ajax function to fetch the printable order
});

function load_tab_prod_sale_jour(date_from, date_to, jour) {
  $.ajax({
    method: 'GET',
    url: 'Public/script/tab_prod_sale_jour.php',
    data: {
      date_from: date_from,
      date_to: date_to,
      jour: jour
    },
    beforeSend: function () {
      $("#page-content").html('loading...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('#tab').DataTable({
        "bInfo": false,
        "ordering": true,
        "paging": true,
        "bLengthChange": true,
        "bFilter": true
      });
    }
  });
}

function load_tab_hist_pay(from_d, to_d) {
  $.ajax({
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d
    },
    url: 'Public/script/tab_hist_pay.php',
    beforeSend: function () {
      $("#tab_hist_pay").html('loading...');
    },
    success: function (data) {
      $('#tab_hist_pay').html(data);
      $('.tab').DataTable({
        "bInfo": false,
        "paging": false,
        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', {
          extend: 'pdf',
          footer: true
        }, {
          extend: 'print',
          footer: true
        }],
        drawCallback: function () {
          var api = this.api();
          $('#t1').html(api.column(2, {
            page: 'current'
          }).data().sum()).number(true, 0);
        }
      });
      $('.tc').number(true, 0);
    }
  });
}

function load_frm_hist_pay() {
  $.ajax({
    method: 'GET',
    url: 'forms/frm_srch_hist_pay.php',
    beforeSend: function () {
      $("#page-content").html('loading...');
    },
    success: function (data) {
      $('#page-content').html(data);
    }
  });
}

function load_tarif_v(cat_id, id) {
  $.ajax({
    url: "Public/script/tab_tarif_vente.php",
    method: 'GET',
    data: {
      cat_id: cat_id,
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('Chargement...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.tab').DataTable({
        "bInfo": false,
        "paging": false,
        "bLengthChange": false
      });
    }
  })
}

function load_frm_art(id) {
  $.ajax({
    url: "forms/frm_product2.php",
    method: 'GET',
    data: {
      id: id
    },
    beforeSend: function () {
      $('#page-content').html("en Chargement ....");
    },
    success: function (data) {
      $('#page-content').html(data);
      $('#cat_id').selectpicker();
      $('#operation').data("Add");
    }
  })
}

function load_srch_hist_vente_tab() {
  $.ajax({
    type: 'GET',
    url: 'forms/frm_srch_hist_vente.php',
    beforeSend: function () {
      $("#page-content").html('loading...');
    },
    success: function (data) {
      $('#page-content').html(data);

      jQuery('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });

      jQuery('#datepicker2').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });
    },
    error: function () {
      alert('La requête n\'a pas abouti');
    }
  });
}



function load_hit_vente_tab(user, from_d, to_d, pos) {

  $.ajax({
    url: "Public/script/tab_hist_vente.php",
    method: 'GET',
    data: {
      user: user,
      from_d: from_d,
      to_d: to_d,
      pos: pos
    },
    beforeSend: function () {
      $("#tab_hist_vente").html('Chargement...');
    },
    success: function (data) {

      $('#tab_hist_vente').html(data);
      $('#example23').DataTable({
        "bInfo": false,

        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'pdf', 'excel']
      });

    }
  })
}


function search_cust(url) {
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
      //$('#autocomplete').val(ui.item.label); // display the selected text
      //$('#selectuser_id').val(ui.item.value); // save selected id to input
      load_frm_customer(ui.item.value);
      load_customer_details(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#tiers_id").val(ui.item.value);
      return false;
    },
  });
}

function load_customer_details(keyword) {
  $.ajax({
    url: "Public/script/list_cust.php",
    method: "POST",
    data: {
      keyword: keyword
    },
    dataType: "json",
    success: function (data) {
      $('#details').html(data);
      // $('#price').val(data.price);

      // $('#qt').focus();
    }
  })
}

function search_cust_v(url) {
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
      $('#cust_id').val(ui.item.value); // save selected id to input
      select_cust(ui.item.value);
      load_customer_details(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#tiers_id").val(ui.item.value);
      return false;
    },
  });
}

function load_tab_hist_sale(from_d, to_d, pos_id, id) {
  $.ajax({
    url: "Public/script/tab_hist_sale.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id,
      id: id
    },
    beforeSend: function () {
      $("#second-content").html('Chargement...');
    },
    success: function (data) {
      $('#second-content').html(data);
      $('.afficher').hide();
      $('.tab').dataTable();
    }
  })
}

function load_tab_hist_repa(from_d, to_d, pos_id, id) {
  $.ajax({
    url: "Public/script/tab_hist_repa.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id,
      id: id
    },
    beforeSend: function () {
      $("#second-content").html('Chargement...');
    },
    success: function (data) {
      $('#second-content').html(data);
      $('.afficher').hide();
      $('.tab').dataTable();
    }
  })
}

function load_tab_hist_dette(from_d, to_d, pos_id, id) {
  $.ajax({
    url: "Public/script/tab_hist_dette.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id,
      id: id
    },
    beforeSend: function () {
      $("#second-content").html('Chargement...');
    },
    success: function (data) {
      $('#second-content').html(data);
      $('.afficher').hide();
      $('.tab').dataTable();
    }
  })
}

function load_tab_hist_bl(from_d, to_d, pos_id) {
  $.ajax({
    url: "Public/script/tab_hist_bl.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id
    },
    beforeSend: function () {
      $("#second-content").html('Chargement...');
    },
    success: function (data) {
      $('#second-content').html(data);
      $('.tab').dataTable({
        "bInfo": false,
        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
      });
    }
  })
}

function pay_fact(op_id, pay_type) {
  if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
    $.ajax({
      url: "Public/script/insert_pay_fact.php",
      method: 'POST',
      data: {
        op_id: op_id,
        status: pay_type
      },
      success: function (data) {
        // alert(data);
        load_frm_sale();
      }
    })
  } else {
    return false;
  }
}


function pay_facture(op_id, status) {
  if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
    $.ajax({
      url: "Public/script/insert_pay_facture.php",
      method: 'POST',
      data: {
        op_id: op_id,
        status: status
      },
      success: function (data) {
        // alert(data);
        load_market();
      }
    })
  } else {
    return false;
  }
}

function new_operation_v(id) {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {
      load_frm_sale();
    }
  })
}

function new_operation(id) {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {
      load_market(id);
    }
  })
}

function new_operation_b() {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {
      load_frm_new_bon();
    }
  })
}

function bon_to_fact(op_id) {
  $.ajax({
    url: "Public/script/bon_to_fact.php",
    method: 'POST',
    data: {
      op_id: op_id
    },
    success: function (data) {
      alert(data);
      load_frm_new_sale('');
    }
  })
}

function load_tab_rpt_sale(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_rpt_sale.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d,
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}

function convert_prof(op_id, type) {
  $.ajax({
    url: "Public/script/conv_prof.php",
    method: "GET",
    data: {
      op_id: op_id,
      type: type
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}

function load_tab_rpt_dette(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_val_dette.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d,
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}

function load_tab_val(pos_id, cat_id) {
  $.ajax({
    url: "Public/script/tab_val.php",
    method: "GET",
    data: {
      pos_id: pos_id,
      cat_id: cat_id
    },
    beforeSend: function () {
      $('#tab_situ_val').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      // $('#page-content').html(data);
      $('#tab_situ_val').html(data);
      $('.tab').DataTable();
      // $('.afficher').hide();
    }

  })
}

function load_tab_val_vente(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_val_sale.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d,
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}


function load_tab_val_dette(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_val_dette.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d,
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}

function load_tab_rpt_prof(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/tab_rpt_prof.php",
    method: "GET",
    data: {
      id: id,
      from_d: from_d,
      to_d: to_d,
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }

  })
}

function load_tab_hist_fact_no_app() {
  $.ajax({

    url: "forms/tab_hist_fact_no_app.php",
    method: "GET",
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.tab').DataTable({
        "bInfo": false,
        "paging": true,
        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
      });
    }

  })
}

function cancel_trans_op(op_id) {
  $.ajax({
    url: "Public/script/delete_trans_op.php",
    method: "POST",
    data: {
      op_id: op_id
    },
    success: function (data) {
      //alert(data);
    },
    error: function () {
      alert('La requête n\'a pas abouti');
    }
  })
}

function ajust_num(pay_type) {
  op_id = $('#crt_op_id').val();
  $.ajax({
    url: "Public/script/ajust_num.php",
    method: "POST",
    //data:{pay_type:pay_type}, 
    success: function (data) {
      //load_addInvoice(op_id);
      pay_fact(op_id, pay_type);
    },
    error: function () {
      alert('La requête n\'a pas abouti');
    }
  })
}


function ajust_op(status) {
  op_id = $('#crt_op_id').val();
  status = status;
  $.ajax({
    url: "Public/script/ajust_num.php",
    method: "POST",
    data: {
      status: status
    },
    success: function (data) {
      pay_facture(op_id, status);
    },
    error: function () {
      alert('La requête n\'a pas abouti');
    }
  })
}

function load_frm_sale() {
  $.ajax({
    url: "Public/partials/form_sale.php",
    method: 'GET',
    success: function (data) {
      $('#page-content-res').html(data);
      search_cust_v('Public/script/list_cust.php');
      search_agent('Public/script/list_agents.php');
      search_art_v('Public/script/list_prod.php');
      $('#autocomplete_agent').focus();
      $('.select2').select2();
      $('.tab').DataTable();
    }
  })
}

function load_market($id) {
  $.ajax({
    url: "Public/partials/market.php",
    method: 'GET',
    data: {
      id: id
    },
    success: function (data) {
      $('#page-content-resultat').html(data);
      search_art('Public/script/list_prod_vente.php');
      search_customer_v("Public/script/list_cust.php")
      $('.select2').select2();
      $('.tab').DataTable();
    }
  })
}

function load_facture_encours() {
  $.ajax({
    url: "Public/partials/facture_encours.php",
    method: 'GET',
    success: function (data) {
      $('#page-content-resultat').html(data);
      $('.tab').DataTable();
      $('.tabx').DataTable();
    }
  })
}

function load_frm_dette() {
  $.ajax({
    url: "Public/partials/form_dette.php",
    method: 'GET',
    success: function (data) {
      $('#page-content-res').html(data);
      search_cust_v('Public/script/list_cust.php');
      search_art_v('Public/script/list_prod.php');
      search_agent('Public/script/list_agents.php');
      $('#autocomplete_agent').focus();
      $('.select2').select2();
      $('.tab').DataTable();
    }
  })
}

function load_frm_proformat() {
  $.ajax({
    url: "Public/partials/form_proformat.php",
    method: 'GET',
    success: function (data) {
      $('#page-content-res').html(data);
      search_cust_v('Public/script/list_cust.php');
      search_art_v('Public/script/list_prod.php');
      search_agent('Public/script/list_agents.php');
      $('#autocomplete_agent').focus();
      $('.select2').select2();
      $('.tab').DataTable();
    }
  })
}


function load_frm_val() {
  $.ajax({
    url: "Public/partials/frm_srch_val.php",
    method: 'GET',
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function load_current_tarif(tarId, rech, cust) {
  $.ajax({
    url: "Public/script/current_price.php",
    method: "POST",
    data: {
      tarId: tarId,
      rech: rech,
      cust: cust
    },
    success: function (data) {
      $('#tab_current_tar').html(data);
    }
  });
}

function load_equiv_prod(prod_id, tar_id) {
  $.ajax({
    url: "Public/script/tab_eq.php",
    method: "POST",
    data: {
      tar_id: tar_id,
      prod_id: prod_id
    },
    success: function (data) {
      $('#det_eq').html(data);
    }
  });
}

function load_prod_prio(tar_id) {
  $.ajax({
    url: "Public/script/tab_prio.php",
    method: "POST",
    data: {
      tar_id: tar_id
    },
    success: function (data) {
      $('#det_eq').html(data);
    }
  });
}

function load_tab_user_jour() {
  $.ajax({
    url: "Public/partials/tab_user_jour.php",
    success: function (data) {
      $('#page-content-sale_end').html(data);
    }
  });
}

function select_bill(op_id) {
  $.ajax({
    url: "Public/script/create_session.php",
    method: 'POST',
    data: {
      sale_id: op_id
    },
    success: function (data) {
      load_frm_sale();
    }
  });
}