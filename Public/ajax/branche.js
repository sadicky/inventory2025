function refreshPage() {
  location.reload();
}

function load_branche() {
  $.ajax({
    url: "Public/partials/branches.php",
    method: 'GET',
    data: {}, 
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
    }
  })
}
function load_society() {
  $.ajax({
    url: "Public/partials/society.php",
    method: 'GET',
    data: {}, 
    beforeSend : function ()
      {
         $("#page-content").html('<p>En chargement .....</p>');
      },
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
    }
  })
}
function load_dashboard() {
  $.ajax({
    url: "Public/partials/dashboard.php",
    method: 'GET',
    data: {}, 
    beforeSend : function ()
      {
         $("#page-content").html('<p>En chargement .....</p>');
      },
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
    }
  })
}
$(document).ready(function () {

  $('.select2').select2();
  
  $(document).on('click', '#getbranches', function () {
    load_branche();
  });

  $(document).on('click', '#society', function () {
    load_society();
  });

  $(document).on('click', '#dashboard', function () {
    load_dashboard();
  });
  
$(document).on('submit', '#frm_society', function(event){

  event.preventDefault();
    $.ajax({
    url:"Public/script/insert_soc.php",
    method:'POST',
    data:new FormData(this),
    contentType:false,
    processData:false,
    success:function(data)
    {

     alert(data);
     load_society();
    }
   });

   $('#frm_society')[0].reset();
});

  $(document).on('submit','#form_branche',function (event) {
    event.preventDefault();
    $.ajax({
      url: "Public/script/addbranche.php",
      method: "POST",
      type: "post",
      data: $("#form_branche").serialize(),
      success: function (data) {
        load_branche();
        // $("#formulaire-branche")[0].reset();
      }
    });
  });


  $(document).on("click", ".delete-branche", function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    if (confirm("Voulez-vous supprimer? ")) {
      $.ajax({
        url: "Public/script/delete_branche.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          $('#message').html(data).slideDown();
          load_branche();
        }
      });
    } else {
      return false;
    }
  });

  
  $(document).on("click", ".activer", function (event) {
    // alert("l");
    event.preventDefault();
    var id = $(this).attr("id");
    if (confirm("Voulez-vous Effectuer cette action? ")) {
      $.ajax({
        url: "Public/script/active_branche.php",
        method: "POST",
        data: {
          id: id
        },
        success: function (data) {
          $('#message').html(data).slideDown();
          load_branche();
        }
      });
    } else {
      return false;
    }
  });


});