function refreshPage() {
    location.reload();
  }
  
$(document).ready(function () {
  $(document).on('click', '#getcommandes', function () {
    load_commandes();
  });

$('#formulaire_commande').submit(function(event){
    event.preventDefault();
      $.ajax({
      url: "Public/script/addcommande.php",
      method:'POST',
      data:$("#formulaire_commande").serialize(),
      success:function(data)
      {
        // setInterval(refreshPage, 1000);
        load_commandes(); 
        $('#operation').val("Add");
      }
     });
     $('#formulaire_commande')[0].reset();
  });



  $(document).on('click', '.new_cmd', function(){
    new_operation_cmd();
 });

 
 $("#search_products" ).autocomplete({
  source: function( request, response ) {
      $.ajax({
          url: 'Public/script/list_products.php',
          type: 'post',
          dataType: "json",
          data: { search: request.term },
          success: function( data ) {
              response( data );
          }
      });
  },
  select: function (event, ui) {
    $("#search_products").val(ui.item.label);        
      $( "#prod_id" ).val( ui.item.value );
      return false;
  },
  select: function (event, ui) {
    $('#search_products').val(ui.item.label); // display the selected text
    $('#prod_id').val(ui.item.value); // save selected id to input
    return false;
},
}).autocomplete('instance')._renderItem=function(ul,item){
return $("<li>").append("<div class='list-group-item list-group-item-action'>"+item.label+"</div>").appendTo(ul);
};

$(document).on('click', '.del_det_cmd', function(){
  var det_id = $(this).attr("id");
  
  if(confirm("Etes-vous sur de vouloir effectuer cette operation ?"))
  {
   $.ajax({
    url:"Public/script/delete_cmd.php",
    method:"POST",
    data:{det_id:det_id},
    success:function(data)
    {
      setInterval(refreshPage, 1000);
    }
  })
  }
  else
  {
   return false;
  }
 });
});

function new_operation_cmd()
{
  $.ajax({
   url:"Public/script/end_session.php",
   success:function(data)
   {
    setInterval(refreshPage, 1000);
   }
  })
}


function load_commandes() {
  $.ajax({
    url: "Public/partials/commandes.php",
    method: 'GET',
    data: {}, 
    success: function (data) {
      $('.afficher').hide();
      $('#page-content').html(data);
      search_sup_op("Public/script/list_supplier.php");
      search_art("Public/script/list_products.php");
    }
  })
}

function load_frm_new_cmd()
{
  $.ajax({
   url:"Public/partials/form_new_cmd.php",
   method:'GET',
   data:{},
   success:function(data)
   {
    $('.afficher').hide();
    $('#page-content').html(data);
    search_sup_op("Public/script/list_supplier.php");
    search_art("Public/script/list_products.php");
   }
  })
}
