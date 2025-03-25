function refreshPage() {
  location.reload();
}

$(document).ready(function () {

  $('td').on('click', '.fa-check, .fa-times', function () {
    let date = $(this).closest('td').data('date');
    let etat = $(this).hasClass('fa-check') ? 0 : 1;

    $.ajax({
      url: 'Public/script/updatepresence.php',
      method: 'POST',
      data: {
        date: date,
        etat: etat,
        staff_id: $(this).closest('tr').data('staff_id')
      },
      success: function (response) {
        location.reload(); // Recharger la page pour afficher la mise à jour
      }
    });
  });

  // getHome();

  $(document).on('load', '.load', function () {
    getHome();
  });


  $(document).on('click', '#users', function () {
    load_user_tab();
  });
  $(document).on('click', '#profiles', function () {
    load_user_profile();
  });

  $(document).on('click', '#presences', function () {
    load_presence_tab();
  });

  $(document).on('click', '#notes', function () {
    load_notes_tab();
  });


  $(document).on('click', '#filtrer', function () {
    month = $('#month').val();
    if (month == '') {
      alert('Selectionner un mois');
    } else {
      load_presence_filter(month);
    }

  });

  $(document).on('click', '#personnels', function () {
    load_personnel_tab();
  });

  $(document).on('click', '#salaires', function () {
    load_salaire_tab();
  });

  $(document).on('click', '#new_user', function () {
    load_user_form('');
  });

  $(document).on('click', '#new_pres', function () {
    load_pres_form('');
  });


  $(document).on('click', '#new_perso', function () {
    load_perso_form('');
  });

  $(document).on('click', '#new_note', function () {
    load_notes_form('');
  });

  $(document).on('click', '.new_note', function () {
    load_notes_form('');
  });

  $(document).on('click', '.note_id', function () {
    id = $(this).attr('id');
    load_note(id);
  });


  $(document).on('click', '#new_sal', function () {
    load_sal_form('');
  });

  $(document).on('click', '.update_ut', function () {
    personne_id = $(this).attr("id");
    load_user_form(personne_id);
  });


  $(document).on('click', '.update_perso', function () {
    personne_id = $(this).attr("id");
    load_perso_form(personne_id);
  });

  $(document).on('click', '.get_dettes', function () {
    personne_id = $(this).attr("id");
    load_dette_customer(personne_id);
  });

  $(document).on('click', '.get_coms', function () {
    id = $(this).attr("id");
    load_tab_commission('', '', id);
    // load_commission(personne_id);
  });


  $(document).on('click', '.update_sal', function () {
    personne_id = $(this).attr("id");
    load_sal_form(personne_id);
  });

  $(document).on('click', '.active_pers', function () {
    user_id = $(this).attr('id');
    etat = $(this).data('id');
    $.ajax({
      url: "Public/script/active_pers.php",
      method: "POST",
      data: {
        user_id: user_id,
        etat: etat
      },
      success: function (data) {
        alert(data + user_id);
        load_user_tab();
      }
    })
  });


  $(document).on('click', '.active_perso', function () {
    staff_id = $(this).attr('id');
    etat = $(this).data('id');
    $.ajax({
      url: "Public/script/active_perso.php",
      method: "POST",
      data: {
        staff_id: staff_id,
        etat: etat
      },
      success: function (data) {
        alert(data);
        load_personnel_tab();
      }
    })
  });
  $(document).on('keyup', '#pseudo', function () {
    var pseudo = $(this).val();
    $.ajax({
      url: 'Public/script/check_pseudo.php',
      method: "POST",
      data: {
        pseudo: pseudo
      },
      success: function (data) {
        if (pseudo == '') {
          $('#availability').html('<span class="text-danger">Veuillez remplir le pseudo</span>');
          $('#Enregistrer').attr("disabled", false);
        } else if (data != 0) {
          $('#availability').html('<span class="text-danger">Pseudo indisponible</span>');
          $('#Enregistrer').attr("disabled", true);
        } else {
          $('#availability').html('<span class="text-success">Pseudo disponible</span>');
          $('#Enregistrer').attr("disabled", false);
        }
      }
    })
  });
  $(document).on('click', '.submitb', function () {
    $.ajax({
      url: "Public/script/editprof.php",
      method: "post",
      data: $("#formprofile").serialize(),
      success: function (data) {
        $("#messages").html(data).slideDown();
      }

    });
    return false;
  });

  $(document).on('submit', '#formprof', function () {
    $.ajax({
      url: "Public/script/editprof_.php",
      method: "post",
      data: $("#formprof").serialize(),
      success: function (data) {
        $("#messages").html(data).slideDown();
      }

    });
    return false;
  });

  $(document).on('keyup', '#conf', function () {
    var conf = $(this).val();
    var mp = $('#mp').val();

    if (conf != mp) {
      $('#availability_conf').html('<span class="text-danger">Mot de passe non Conforme</span>');
      $('#Enregistrer').attr("disabled", true);
    } else {
      $('#availability_conf').html('<span class="text-success">Mot de passe Conformes</span>');
      $('#Enregistrer').attr("disabled", false);
    }

  });

  $(document).on('change', '#branche_id', function (event) {
    id = $(this).val();
    $.ajax({
      url: "Public/script/filter_staff.php",
      method: 'POST',
      data: {
        id: id
      },
      success: function (data) {
        $('#staff_info').html(data);
      }
    });
  });

  $('.presence-checkbox').on('change', function () {
    alert('Please select');
    const row = $(this).closest('tr');
    const justifyCheckbox = row.find('.justify-checkbox');

    if ($(this).is(':checked')) {
      justifyCheckbox.prop('disabled', true).prop('checked', false);
    } else {
      justifyCheckbox.prop('disabled', false);
    }
  });

  $(document).on('keyup', '#matri', function () {
    var mat = $(this).val();
    $.ajax({
      url: 'backend/check_matricule.php',
      method: "POST",
      data: {
        mat: mat
      },
      success: function (data) {
        if (data != '0') {
          $('#mat_available_msg').html('<span class="text-danger">Le matricule existe déjà</span>');
          $('#Enregistrer').attr("disabled", true);
        } else {
          $('#mat_available_msg').html('<span class="text-success">Matricule Disponible</span>');
          $('#Enregistrer').attr("disabled", false);
        }
      }
    })
  });
  $(document).on('click', '.trash_conf', function (event) {

    // table=$('#tab_details').val();
    // id=$('#tab_details').data('id');
    id = $(this).attr('id');

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_user.php",
        method: 'POST',
        data: {
          id: id
        },
        success: function (data) {
          alert(data);
        }
      });
    } else {
      return false;
    }
  });
  $(document).on('click', '.delete_per', function () {
    var id_per = $(this).attr("id");

    if (confirm("Etes-vous sur de vouloir effectuer cette operation ?")) {
      $.ajax({
        url: "Public/script/delete_per.php",
        method: "POST",
        data: {
          id_per: id_per
        },
        success: function (data) {
          alert(data);
          load_tab_periode('1');

        }
      })

    } else {
      return false;
    }
  });

  $(document).on('submit', '#form_utilisateur', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/adduser.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        alert(data);
        load_user_tab();
      }
    });

    $('#form_utilisateur')[0].reset();
  });

  $(document).on('submit', '#form_presences', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/addpresence.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        alert(data);
        load_presence_tab();
      }
    });

    $('#form_perso')[0].reset();
  });

  $(document).on('submit', '#form_notes', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/add_note.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        alert(data);
        load_notes_tab();
      }
    });

    $('#form_notes')[0].reset();
  });

  $(document).on('submit', '#form_perso', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/addperso.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        alert(data);
        load_personnel_tab();
      }
    });

    $('#form_perso')[0].reset();
  });

  $(document).on('submit', '#form_sal', function (event) {

    event.preventDefault();
    $.ajax({
      url: "Public/script/addsalstaff.php",
      method: 'POST',
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('#message').html('Enregistrement encours .....');
      },
      success: function (data) {
        alert(data);
        load_salaire_tab();
      }
    });

    $('#form_perso')[0].reset();
  });

  $(document).on("click", ".delete-user", function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    if (confirm("Voulez-vous supprimer? ")) {
      $.ajax({
        url: "Public/script/deleteuser.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {}
      });
    } else {
      return false;
    }
  });



});

function load_user_tab() {
  $.ajax({
    url: "Public/partials/users.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_user_profile() {
  $.ajax({
    url: "Public/partials/profiles.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}


function load_presence_tab() {
  $.ajax({
    url: "Public/partials/presences.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_notes_tab() {
  $.ajax({
    url: "Public/partials/notes.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_note(id) {
  $.ajax({
    url: "Public/partials/note.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_presence_filter(id) {
  $.ajax({
    url: "Public/partials/presences.php",
    method: "POST",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
    }
  })
}

function load_personnel_tab() {
  $.ajax({
    url: "Public/partials/personnels.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_salaire_tab() {
  $.ajax({
    url: "Public/partials/salaires.php",
    method: "POST",
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }
  })
}

function load_user_form(id) {
  $.ajax({
    url: "Public/partials/form_utilisateur.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_notes_form(id) {
  $.ajax({
    url: "Public/partials/form_notes.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_dette_customer(id) {
  $.ajax({
    url: "Public/script/dette_customer.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_commission(id) {
  $.ajax({
    url: "Public/partials/form_commission.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}


function load_perso_form(id) {
  $.ajax({
    url: "Public/partials/form_perso.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_sal_form(id) {
  $.ajax({
    url: "Public/partials/form_sal.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('#operation').data("Add");
    }
  })
}

function load_pres_form(id) {
  $.ajax({
    url: "Public/partials/form_pres.php",
    method: "GET",
    data: {
      id: id
    },
    beforeSend: function () {
      $("#page-content").html('<p>En chargement .....</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').DataTable();
      $('#operation').data("Add");
    }
  })
}

function load_last_user_tab() {
  //alert('je teste');
  $.ajax({
    url: "Public/script/last_user_tab.php",
    method: "POST",
    beforeSend: function () {
      $("#last_inserted").html('En chargement ..............');
    },
    success: function (data) {
      $('#last_inserted').html(data);
    }
  })
}


function getHome() {
  alert('je teste');
  $.ajax({
    url: "Public/script/last_user_tab.php",
    method: "POST",
    beforeSend: function () {
      $("#last_inserted").html('En chargement ..............');
    },
    success: function (data) {
      $('#last_inserted').html(data);
    }
  })
}