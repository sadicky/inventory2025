function refreshPage() {
  location.reload();
}

function load_frm_cash(id) {
  url = "Public/script/list_caisses.php";
  $.ajax({
    url: "Public/partials/form_new_cash.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('chargement ...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      // $('.number-separator').number( true, 0 );
      search_cash(url);
    }
  })
}

function load_form_paiement(id) {
  // url = "Public/script/list_caisses.php";
  $.ajax({
    url: "Public/partials/form_paiement.php",
    method: 'GET',
    data: {
      id,
      id
    },
    beforeSend: function () {
      $("#page-content").html('chargement ...');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      // $('.number-separator').number( true, 0 );
      // search_cash(url);
    }
  })
}

function search_cash(url) {
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
      load_frm_cash(ui.item.value);
      return false;
    },
    focus: function (event, ui) {
      $("#autocomplete").val(ui.item.label);
      $("#tiers_id").val(ui.item.value);
      return false;
    },
  });
}


function load_compte() {
  $.ajax({

    url: "Public/partials/caisses.php",
    method: "GET",
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
    }

  })
}
function load_devise(id) {
  $.ajax({

    url: "Public/partials/devises.php",
    method: "GET",
    data: {
      id:id
    },
    beforeSend: function () {
      $('#page-content').html('<p>page en chargement .......</p>');
    },
    success: function (data) {
      $('#page-content').html(data);
      $('.afficher').hide();
      $('.tab').dataTable({
        'Ordering': false,
      });
    }

  })
}
$(document).ready(function () {

  $(document).on('click', '#new_cash', function () {
    load_frm_cash('');
  });

  $(document).on('click', '.new_cash', function () {
    id = $(this).data('id');
    load_frm_cash(id);
  });

  
  $(document).on('click', '#comptes', function () {
    load_compte();
  });

   
  $(document).on('click', '#devises', function () {
    load_devise();
  });

  $(document).on('click', '#form-paiement', function () {
    load_form_paiement();
  });

  $(document).on('submit', '#formulaire_compte', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/addcaisse.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (data) {
        $('#message').html(data).slideDown();
        // alert(data);
        load_frm_cash(data.id);
        $("#formulaire_compte")[0].reset();
      }
    });
  });

  $(document).on('submit', '#formulaire_devise', function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/adddevise.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (data) {
        $('#message').html(data).slideDown();
        alert(data.msg);
        // load_devise();
        setInterval(refreshPage, 1000);
      }
    });
  });

  $(document).on('click', '.update_devise', function(){
    devise_id = $(this).attr("id");
    load_devise(devise_id );
   });

  $(document).on('click', '#sup_achat', function () {
    load_tab_tiers_achat($('#caisse_id').val(), '', '');
  });

     $("#search_caisse" ).autocomplete({
      source: function( request, response ) {
          $.ajax({
              url: 'Public/script/list_caisse.php',
              type: 'post',
              dataType: "json",
              data: { search: request.term },
              success: function( data ) {
                  response( data );
              }
          });
      },
      select: function (event, ui) {
        $("#search_caisse").val(ui.item.label);
          return false;
      }
      // focus: function(event, ui){
      //     $( "#search_caisse" ).val( ui.item.value );
      //     return false;
      // },
  }).autocomplete('instance')._renderItem=function(ul,item){
    return $("<li>").append("<div class='list-group-item list-group-item-action'>"+item.label+"</div>").appendTo(ul);
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

  $(document).on("click", ".delete-devise", function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    if (confirm("Voulez-vous supprimer? ")) {
      $.ajax({
        url: "Public/script/deletedevise.php",
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



  //recharger cette fonction toute les secondes
  // setInterval(1000);

});


function load_tab_tiers_achat(id, from_d, to_d) {
  $.ajax({

    url: "Public/script/hist_achat_caisse.php",
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
    }

  })
}