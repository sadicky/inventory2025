$(document).ready(function () {
  $(document).on('click', '#change', function () {
    load_frm_new_chg();
  });

  $(document).on('click', '.new_chg', function () {
    new_operation_app();
    load_frm_new_chg();
  });

  $(document).on('click', '#validations', function () {
    load_validations();
  });

  $(document).on('click', '#reparations', function () {
    load_tab_reparation($(this).data("id"));
  });

  $(document).on('click', '#ajoutcaissee', function () {
    load_form_reparation($(this).data("id"));
  });
  $(document).on('click', '#repannuler', function () {
    load_tab_reparation_annuler($(this).data("id"));
  });
  $(document).on('click', '#repeffectue', function () {
    load_tab_reparation_effectuer($(this).data("id"));
  });
  $(document).on('click', '#repayer', function () {
    load_tab_reparation_payer($(this).data("id"));
  });
  $(document).on('click', '#validations_vente', function () {
    load_validations_vente();
  });


  $(document).on('click', '#hist_sort', function () {
    load_tab_hist_sort('', '', '');
  });

  $(document).on('click', '#change_pos', function () {
    load_frm_change_pos($(this).data("id"));
  });

  $(document).on('submit', '#frm_srch_rap_situ_gen', function (event) {
    event.preventDefault();
    pos_id = $('#pos_id').val();
    cat_id = $('#cat_id').val();
    load_rap_situ_gen(pos_id, cat_id);
  });
  $(document).on('submit', '#frm_srch_rap_endom', function (event) {
    event.preventDefault();
    pos_id = $('#pos_id').val();
    cat_id = $('#cat_id').val();
    sup_id = $('#sup_id').val();
    load_rap_situ_gen_endom(sup_id, pos_id, cat_id);
  });

  $(document).on('click', '.fiche_det', function () {
    prod_id = $(this).data('id');
    pos_id = $('#pos_id').val();
    load_tab_det_fiche_art(prod_id, pos_id);
    //up();
  });
  $(document).on('click', '#rpt_stock', function () {
    load_tab_rpt_stock();
  });

  $(document).on('click', '#rpt_endom', function () {
    load_tab_rpt_endom();
  });


  $(document).on('click', '.rpt_under', function () {
    load_tab_rpt_under($(this).data('id'));
  });

  $(document).on('click', '.rupture', function () {
    load_tab_rpt_stock_rupt();
  });

  $(document).on('click', '.rpt_exp', function () {
    load_tab_rpt_exp($(this).data('id'));
  });


  $(document).on('click', '#rap_fiche_stk', function () {
    load_srch_rap_fiche_stk();
  });

  $(document).on('click', '#rap_situ_stk_lot', function () {
    load_srch_rap_situ_lot();
  });

  $(document).on('click', '#rap_situ_stk_gen', function () {
    load_srch_rap_situ_gen();
  });

  $(document).on('click', '#syn_per', function () {
    load_srch_rap_syn_tab();
  });
  $(document).on('click', '#print_rp', function () {
    var printable = 'rapport';
    printData(printable);
  });
  $(document).on('submit', '#frm_rap_inv', function () {
    event.preventDefault();
    id_per = $('#id_per').val();
    pos_id = $('#pos_id').val();
    load_tab_rap_inv(id_per, pos_id);
  });

  $(document).on('click', '#rap_inv', function () {
    load_tab_rap_inv('', '');
  });
  $(document).on('click', '#hist_achat', function () {
    load_tab_hist_achat('', '', '');
  });

  $(document).on('click', '.valider_stock', function () {
    op_id = $(this).attr('id');
    if (confirm("Etes-vous sur de vouloir valider cette operation ?")) {
      $.ajax({
        url: "Public/script/update_valider_stock.php",
        method: 'POST',
        data: {
          op_id: op_id
        },
        success: function (data) {
          setInterval(refreshPage, 100);
        }
      });
    } else {
      return false;
    }
  });
  $(document).on('submit', '#frm_search_rap_syn', function (event) {

    event.preventDefault();
    from_d = $('#date_from').val();
    to_d = $('#date_to').val();
    pos_id = $('#pos_id').val();
    id_per = $('#id_per').val();
    load_rap_syn_per(from_d, to_d, pos_id, id_per);
  });


  $(document).on('click', '.fetch_inv_op', function () {
    det_id = $(this).attr('id');
    $.ajax({
      url: "Public/script/fetch_det.php",
      method: "GET",
      data: {
        det_id: det_id
      },
      dataType: "json",
      success: function (data) {
        $('#m_exp').val(data.m_exp);
        $('#y_exp').val(data.y_exp);
        $('#m_fab').val(data.m_fab);
        $('#y_fab').val(data.y_fab);
        $('#lot').val(data.lot);
        $('#price').val(data.price);
        $('#qt').val(data.qt);
        $('#qty').val(data.qty);
        $('#prod_id').val(data.prod_id);
        $('#autocomplete_art').val(data.prod_name);
        $('#prod_name').val(data.prod_name);
        $('#content_lib_prod_v').val(data.prod_name);
        $('#autocomplete_lot').val(data.lot);
        $('#operation_inv').val('Edit');
        $('#operation').val('Edit');
        $('#det_id').val(det_id);

        // $('#m_exp').attr("disabled", true);
        // $('#y_exp').attr("disabled", true);
        // $('#m_fab').attr("disabled", true); 
        // $('#y_fab').attr("disabled", true);
        // $('#date_exp').attr("disabled", true);
        $('#autocomplete_lot').attr("disabled", true);
        $('#lot').attr("disabled", true);
        $('#qt').focus();
        //alert(data.date_exp);

        /*if($('#type_ent').val()=='Production')
        {
          $('#bl_d').html('<label class="control-label">Qt(Dechet)</label><input type="number" name="qt_d" id="qt_d" class="form-control" step="any">');
        }
        else
        {
         $('#bl_d').html('<input type="hidden" avlue="0" name="qt_d" id="qt_d" class="form-control" step="any">');
        }*/
      }
    })

  })

  $(document).on('click', '#rpt_hist', function () {
    load_tab_rpt_hist();
  });

  $(document).on('submit', '#frm_srch_rap_fiche_stk', function (event) {
    event.preventDefault();

    from_d = $('#date_from').val();
    to_d = $('#date_to').val();
    pos_id = $('#pos_id').val();
    id_per = $('#id_per').val();
    prod_id = $('#prod_id').val();

    load_rap_fiche_stk(from_d, to_d, prod_id, pos_id, id_per);
  });

  $(document).on('submit', '#form_new_chg', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_change.php",
      method: 'POST',
      data: $("#form_new_chg").serialize(),
      success: function (data) {
        $('#message').html(data).slideDown();
        $('#operation').val("Add");
        load_frm_new_chg();
      }
    });

    $('#frm_new_chg')[0].reset();
  });

  $(document).on('click', '#periode', function () {
    load_form_periode('');
  });

  $(document).on('click', '.del_det_chg', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_chg.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          //alert(data);
          load_frm_new_chg();
        }
      })
    } else {
      return false;
    }
  });
  $(document).on('click', '.nv_periode', function () {
    id = $(this).data('id');
    load_form_periode(id);
  });

  $(document).on('submit', '#appro-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_achat(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('submit', "#formulaire_reparation", function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/add_reparation.php",
      method: "POST",
      data: $("#formulaire_reparation").serialize(),
      success: function (data) {
        load_tab_reparation('');
      }
    });
  });
  $(document).on('click', '.row_edit_appro_hist', function (event) {
    appro_id = $(this).data('id');
    $.ajax({
      url: "Public/script/create_session.php",
      method: 'POST',
      data: {
        appro_id: appro_id
      },
      success: function (data) {
        load_frm_new_appro();
      }
    });
  });
  $(document).on('click', '.new_appro', function () {
    new_operation_app();
    //load_frm_new_appro();
  });

  $(document).on("change", "#pos_id", function () {
    // alert("Please enter")
    var pos_id = $(this).val();
    var prod_id = $("#prod_id").val();
    if (pos_id) {
      $.ajax({
        type: 'POST',
        url: 'Public/script/qte.php',
        data: {
          prod_id: prod_id,
          pos_id: pos_id
        },
        success: function (d) {
          $('#resultat').html(d).slideDown();
        }

      });
    }
  });

  $("#resultat").hide();
  $(document).on('submit', '#sort-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_sort(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('click', '#hist_change', function () {
    load_tab_hist_change('', '', '');
  });

  $(document).on('submit', '#chg-search', function () {
    event.preventDefault();
    from_d = $('#from_d').val();
    to_d = $('#to_d').val();
    load_tab_hist_change(from_d, to_d, $('#pos_id').val());
  });

  $(document).on('click', '.row_edit_chg_hist', function (event) {
    chg_id = $(this).data('id');

    $.ajax({
      url: "Public/script/create_session.php",
      method: 'POST',
      data: {
        chg_id: chg_id
      },
      success: function (data) {
        load_frm_new_chg();
      }
    });
  });

  $(document).on('click', '.row_edit_sort_hist', function (event) {
    sort_id = $(this).data('id');
    $.ajax({
      url: "Public/script/create_session.php",
      method: 'POST',
      data: {
        sort_id: sort_id
      },
      success: function (data) {
        load_frm_new_sort();
      }
    });
  });

  $(document).on('submit', '#frm_change_pos', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/change_pos.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        //alert(data);
        location.reload(true);
      }
    });
  });

  $(document).on('click', '.del_op_chg', function () {
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
          new_operation_app();
          load_frm_new_chg();
        }
      })
    } else {
      return false;
    }
  });
  $(document).on('submit', '#form_det_inv', function (event) {
    id_per = $('#id_per').val();
    pos_id = $('#pos_id').val();

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_det_inv.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        // alert(data);
        load_tab_inventaire(id_per, pos_id);
      }
    });

    $('#form_det_inv')[0].reset();
  });

  $(document).on('submit', '#form_inventaire', function (event) {
    id_per = $('#id_per').val();
    pos_id = $('#pos_id').val();

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_inventaire.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        load_tab_inventaire(id_per, pos_id);
        $('#operation_inv').val('Add');
      }
    });

    //$('#frm_inventaire')[0].reset();
  });


  $(document).on('submit', '#form_join_bon', function (event) {
    // alert('Please enter');
    event.preventDefault();
    $.ajax({
      url: "Public/script/join_bon.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        alert(data);
        load_frm_new_chg();
      }
    });
  });

  $(document).on('click', '.del_det_sort', function () {
    var det_id = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_sort.php",
        method: "POST",
        data: {
          det_id: det_id
        },
        success: function (data) {
          load_frm_new_sort();
        }
      })
    } else {
      return false;
    }
  });

  $(document).on('click', '#out_stock', function () {
    load_frm_new_sort();
    // alert('clicked');
  });

  $(document).on('click', '.new_sort', function () {
    new_operation_app();
    load_frm_new_sort();
  });

  $(document).on("click", ".annulerrep", function (event) {
    event.preventDefault();
    // afterDel();
    var id = $(this).data("id");
    if (confirm("Voulez-vous annuler cette réparation? ")) {
      $.ajax({
        url: "Public/script/annulrep.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          load_tab_reparation('');
        }
      });
    } else {
      return false;
    }
  });

  $(document).on("click", ".activers", function (event) {
    event.preventDefault();
    // afterDel();
    var id = $(this).data("id");
    if (confirm("Confirmer la fin de la réparation? ")) {
      $.ajax({
        url: "Public/script/activrep1.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          load_tab_reparation('');
        }
      });
    } else {
      return false;
    }
  });
  $(document).on("click", ".activer_payer", function (event) {
    event.preventDefault();
    // afterDel();
    var id = $(this).data("id");
    if (confirm("Confirmer la fin de la réparation? ")) {
      $.ajax({
        url: "Public/script/activrep.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          load_tab_reparation('');
        }
      });
    } else {
      return false;
    }
  });

  $(document).on('submit', '#frm_new_sort', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/addsortie.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        $('#message').html(data).slideDown();
        //alert(data);
        $('#operation').val("Add");
        load_frm_new_sort();
      },
      error: function () {
        $('#message').html(data).slideDown();
      }
    });

    $('#frm_new_sort')[0].reset();
  });

});

function load_frm_new_sort() {
  $.ajax({
    url: "Public/partials/form_new_sortie.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('#page-content').html(data);
      $(".hide_cont_det").toggle();

      $('.afficher').hide();
      search_art("Public/script/list_products.php");
    }
  })
}

function new_operation_app() {
  $.ajax({
    url: "Public/script/end_session.php",
    success: function (data) {}
  })
}


function load_tab_rpt_hist() {
  $.ajax({
    url: "Public/script/tab_rpt_hist.php",
    method: 'POST',
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_form_periode(id) {
  $.ajax({

    url: "Public/partials/form_periode.php",
    method: "GET",
    data: {
      id: id
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

function load_form_reparation(id) {
  $.ajax({

    url: "Public/partials/form_reparation.php",
    method: "GET",
    data: {
      id: id
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

function load_frm_new_chg() {
  $.ajax({
    url: "Public/partials/form_new_change.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      search_art("Public/script/list_products.php");
    }
  })
}

function load_validations() {
  $.ajax({
    url: "Public/partials/validations.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();

    }
  })
}

function load_validations_vente() {
  $.ajax({
    url: "Public/partials/validations_vente.php",
    method: 'GET',
    data: {},
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();

    }
  })
}


function load_tab_rpt_stock() {
  $.ajax({
    url: "Public/script/tab_rpt_stock.php",
    method: 'POST',
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_tab_rpt_endom() {
  $.ajax({
    url: "Public/partials/tab_rpt_endom.php",
    method: 'POST',
    // success: function (data) {
    //   $('#page-content').html(data);
    //   $('.afficher').hide();
    // }
    beforeSend: function () {
      $("#page-content").html('loading...');
      $('.afficher').hide();
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_srch_rap_situ_gen() {
  $.ajax({
    type: 'GET',
    url: 'Public/partials/frm_srch_rap_situ_gen.php',
    beforeSend: function () {
      $("#second-content").html('loading...');
    },
    success: function (data) {
      $('#second-content').html(data);
    }
  });
}


function load_tab_det_fiche_art(prod_id, pos_id) {
  $.ajax({
    url: "Public/script/tab_det_fiche_stk.php",
    method: 'GET',
    data: {
      prod_id: prod_id,
      pos_id: pos_id
    },
    beforeSend: function () {
      $('.fiche_art').html('<p><b>Page en chargement .......</b></p>');
    },
    success: function (data) {
      $('.fiche_art').html(data);
      $('.tab').dataTable();
      $('.tabx').dataTable();
    }
  })
}

function load_tab_rpt_exp(d_max) {
  $.ajax({
    url: "Public/script/tab_rpt_exp.php",
    method: 'POST',
    data: {
      d_max: d_max
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#tab').dataTable({});
    }
  })
}

function load_tab_rpt_under(level) {
  $.ajax({
    url: "Public/script/tab_rpt_under.php",
    method: 'POST',
    data: {
      level: level
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#tab').dataTable({});
    }
  })
}

function load_tab_rpt_stock_rupt() {
  $.ajax({
    url: "Public/script/tab_rpt_stock_rupture.php",
    method: 'POST',
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#tab').dataTable({
        "bInfo": false,
        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
      });
    }
  })
}

function load_srch_rap_fiche_stk() {
  $.ajax({
    type: 'GET',
    url: 'Public/partials/frm_srch_rap_fiche_stk.php',
    beforeSend: function () {
      $("#second-content").html('<b>loading...</b>');
    },
    success: function (data) {
      $('#second-content').html(data);
      search_art('Public/script/list_products.php');
    }
  });
}


function load_tab_hist_change(from_d, to_d, pos_id) {
  $.ajax({
    url: "Public/script/tab_hist_change.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id
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

function load_rap_situ_gen(pos_id, cat_id) {
  $.ajax({
    url: "Public/script/tab_situ_stock_gen.php",
    method: "GET",
    data: {
      pos_id: pos_id,
      cat_id: cat_id
    },
    beforeSend: function () {
      $("#tab_situ").html('Chargement du stock en cours ...');
    },
    success: function (data) {
      $('#tab_situ').html(data);
      $('.tab').DataTable();
    }
  })
}

function load_rap_situ_gen_endom(sup_id, pos_id, cat_id) {
  $.ajax({
    url: "Public/script/tab_situ_stock_gen_endom.php",
    method: "GET",
    data: {
      pos_id: pos_id,
      cat_id: cat_id,
      sup_id: sup_id
    },
    beforeSend: function () {
      $("#tab_situ").html('Chargement du stock en cours ...');
    },
    success: function (data) {
      $('#tab_situ').html(data);
      $('.tab').DataTable();
    }
  })
}

function load_tab_hist_sort(from_d, to_d, pos_id) {
  $.ajax({
    url: "Public/script/tab_hist_sort.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id
    },
    success: function (data) {
      $('#second-content').html(data);
      $('.tab').dataTable();
    }
  })
}

function load_frm_change_pos(id) {
  $.ajax({
    url: "Public/partials/frm_change_pos.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('loading .....');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_tab_reparation_annuler(id) {
  $.ajax({
    url: "Public/partials/reparations_annuler.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('loading .....');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function load_tab_reparation_effectuer(id) {
  $.ajax({
    url: "Public/partials/reparations_effectuer.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('loading .....');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function load_tab_reparation_payer(id) {
  $.ajax({
    url: "Public/partials/reparations_payer.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('loading .....');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function load_tab_reparation(id) {
  $.ajax({
    url: "Public/partials/reparations.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('loading .....');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function up() {
  $('html, body').animate({
    scrollTop: '0px'
  }, 2000);
  return false;
}

function load_rap_syn_per(from_d, to_d, pos_id, id_per) {
  $.ajax({
    url: "Public/script/tab_rap_syn_stk.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id,
      id_per: id_per
    },
    beforeSend: function () {
      $("#tab_rap_syn").html('Chargement...');
    },
    success: function (data) {
      $('#tab_rap_syn').html(data);
      $('#data-table').DataTable();
    }
  })
}

function load_tab_rap_inv(id_per, pos_id) {
  $.ajax({
    url: "Public/script/tab_rap_inventaire.php",
    method: 'POST',
    data: {
      id_per: id_per,
      pos_id: pos_id
    },
    success: function (data) {
      $('#second-content').html(data);
      $('#data-table').dataTable({
        "bInfo": false,
        "bLengthChange": false,
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print']
      });
    }
  })
}

function load_tab_hist_achat(from_d, to_d, pos_id) {
  $.ajax({
    url: "Public/script/tab_hist_achat.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      pos_id: pos_id
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

function load_srch_rap_syn_tab() {
  $.ajax({
    type: 'GET',
    url: 'Public/partials/frm_srch_rap_syn.php',
    beforeSend: function () {
      $("#second-content").html('<b>Loading...</b>');
    },
    success: function (data) {
      $('#second-content').html(data);
    }
  });
}

function load_rap_fiche_stk(from_d, to_d, prod_id, pos_id, id_per) {
  $.ajax({
    url: "Public/script/tab_rap_fiche_stk.php",
    method: 'GET',
    data: {
      from_d: from_d,
      to_d: to_d,
      prod_id: prod_id,
      pos_id: pos_id,
      id_per: id_per
    },
    beforeSend: function () {
      $("#tab_rap_fiche_stk").html('Chargement...');
    },
    success: function (data) {
      $('#tab_rap_fiche_stk').html(data);
      $('#data-table').DataTable({
        //"bInfo": false,
        //"paging":false,
        "bLengthChange": false,
        "ordering": false,
        //bFilter:false,
        pagingType: "simple"
      });


    }
  })
}