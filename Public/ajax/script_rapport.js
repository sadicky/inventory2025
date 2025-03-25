$(function() {

$(document).on('click', '#print_rap', function(){
  var printable='rap_to_print';
  printData(printable);
 });

$(document).on('blur', '.edit_qt_inv', function(){

    var val=$(this).html();
    val=val.replace('<br>','');
    val=val.trim();
    var det_id=$(this).attr('id');
    var field=$(this).data('id');
    
    //alert(det_id);
     $.ajax({
                     url:"backend/edit_qt_inv.php",
                     method:"POST",
                     data:{val:val,det_id:det_id,field:field},
                     success:function(data)
                     {
                      //alert(data);
                      //load_inv_valo();
                     }
                });


  });



$(document).on('submit', '#frm_search_rap_syn_cui', function(event){

  event.preventDefault();

  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var pos=$('#pos_rap').val();
  var id_per=$('#id_per').val();
  var stk='0';

  load_rap_syn_cui_per(from_d,to_d,stk,pos,id_per);


});

$(document).on('click', '#tab_end_stock', function(){
  //alert('cool');
  load_tab_rupture();
 });

$(document).on('change', '#srch_tarif_vente', function(){
  ass=$(this).val();
  load_tab_tarif_vente(ass);
 });



$(document).on('click', '#syn_cui_per', function(){
  //alert('cool');
  load_srch_rap_syn_cui_tab();
 });

$(document).on('click', '#tab_near_exp', function(){
  //alert('cool');
  load_tab_near_exp();
 });



$(document).on('click', '#op_vente_jour_ant', function(){
  jour=$(this).data('id');
  load_tab_prod_sale_jour_ant(jour);
 });

$(document).on('click', '#tab_exp_prod', function(){
  //alert('cool');
  load_tab_exp_prod();
 });

$(document).on('click', '#bon_cmd', function(){
  //alert('cool');
  load_srch_bon_cmd();
 });

$(document).on('click', '#rap_conso_per', function(){
  load_srch_conso_per();
 });

$(document).on('click', '#fiche_syn', function(){
  load_srch_syn_per();
 });

$(document).on('click', '.inv_val', function(){
  //alert('cool');
  id_per=$(this).data('id');
  load_inv_valo(id_per);
  //load_srch_inv_valo()
 });

$(document).on('click', '#inv_init', function(){
  load_inv_init();
 });

$(document).on('click', '#syn_stk', function(){
  load_syn_stk();
 });

$(document).on('click', '#rap_vente', function(){
  //alert('cool');
  load_srch_rap_vente_tab();
 });

$(document).on('click', '#rap_vente_ingred', function(){
  //alert('cool');
  load_srch_rap_vente_ingred();
 });

$(document).on('click', '#rap_situ_stk_mp', function(){
  //load_rap_situ_stk_mp();

  load_srch_situ_stock();
 });

$(document).on('click', '#aff_tarif_vente', function(){
  load_srch_tarif_vente();
 });


$(document).on('click', '#rap_prod', function(){
  //alert('cool');
 load_srch_rap_prod_tab();
 });

$(document).on('click', '#rap_caisse', function(){
  load_srch_rap_caisse_tab();
 });

$(document).on('click', '#cont_caisse', function(){
  load_srch_cont_caisse_tab();
 });

$(document).on('click', '#rap_stk_mp', function(){
  load_srch_rap_stk_mp_tab();
 });

$(document).on('click', '#rap_stk_pf', function(){
  //alert('cool');
  load_srch_rap_stk_pf_tab();
 });

$(document).on('change','#situ_stock_pos',function(){
pos=$('#situ_stock_pos').val();
cat=$('#situ_cat').val();
load_rap_situ_stk_mp(pos,cat);
});

$(document).on('change','#situ_cat',function(){
pos=$('#situ_stock_pos').val();
cat=$('#situ_cat').val();
load_rap_situ_stk_mp(pos,cat);
});

//search period customers
$(document).on('submit', '#frm_search_rap_vente', function(event){

  event.preventDefault();
  var client=$('#cat_rap').val();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var party=$('#party').val();

  load_rap_vente_tab(client,from_d,to_d,party);


});

$(document).on('submit', '#frm_search_rap_vente_ingred', function(event){

  event.preventDefault();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();

  load_rap_vente_tab_ingred(from_d,to_d);


});

$(document).on('click', '#only_ingred', function(event){


  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();

  load_rap_vente_tab_tot_ingred(from_d,to_d);


});

$(document).on('submit', '#frm_search_rap_inv_valo', function(event){

  event.preventDefault();
  var pos=$('#pos_rap').val();
  load_inv_valo(pos);
});

$(document).on('submit', '#frm_search_rap_situ_gen', function(event){

  event.preventDefault();
  var pos=$('#situ_stock_pos').val();
  load_rap_situ_stk_mp(pos);

});

$(document).on('submit', '#frm_search_rap_situ_lot', function(event){

  /*event.preventDefault();
  var pos=$('#pos_rap').val();*/
  load_rap_situ_stk_pf();
});

//search period customers
$(document).on('submit', '#frm_search_rap_caisse', function(event){

  event.preventDefault();
  var caisse=$('#caisse_rap').val();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();

  load_rap_caisse_tab(caisse,from_d,to_d);


});

$(document).on('submit', '#frm_search_cont_caisse', function(event){

  event.preventDefault();
  var caisse=$('#caisse_rap').val();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();

  load_cont_caisse_tab(caisse,from_d,to_d);


});

$(document).on('submit', '#frm_search_rap_stk_mp', function(event){

  event.preventDefault();

  var prod=$('#prod_id').val();
  //alert(prod);
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var pos=$('#pos_rap').val();
  var id_per=$('#id_per').val();
  var stk='0';
if ($("#gros").is(':checked')) {
  stk=$("#gros").val();
}
else {
stk=$("#det").val();
}

  load_rap_stk_mp_tab(prod,from_d,to_d,stk,pos,id_per);


});

$(document).on('submit', '#frm_search_rap_stk_pf', function(event){

  event.preventDefault();
  var prod=$('#lib_mp_rap').val();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var pos=$('#pos_rap').val();

  load_rap_stk_pf_tab(prod,from_d,to_d,pos);


});

//rapport bob

//search period suppliers
$(document).on('submit', '#frm_search_bon_cmd', function(event){

  event.preventDefault();
  var four=$('#four_hist').val();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var pos=$('#pos_rap').val();

  load_tab_bon_cmd(four,from_d,to_d,pos);


});

$(document).on('submit', '#frm_search_conso_per', function(event){

  event.preventDefault();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();
  var pos=$('#pos_rap').val();

  load_tab_conso_per(from_d,to_d,pos);


});

$(document).on('submit', '#frm_search_syn_per', function(event){

  event.preventDefault();
  var from_d=$('#datepicker').val();
  var to_d=$('#datepicker2').val();

  var pos=$('#pos_rap').val();
  var user=$('#user_rap').val();

if ($("#gros").is(':checked')) {
  stk=$("#gros").val();
}
else {
stk=$("#det").val();
}
  load_tab_syn_per(from_d,to_d,stk,pos,user);


});

$(document).on('click', '.row_bon_cmd', function(){
  var op_id=$(this).data('id');
    load_det_bon_cmd(op_id);
});

})

function load_srch_rap_vente_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_vente.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_rap_vente_ingred()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_vente_ingred.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_rap_caisse_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_caisse.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_cont_caisse_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_cont_caisse.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_rap_vente_tab(client,from_d,to_d,party)
{
var stock = $("#pos_rap option:selected").text();
var user = $("#client_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

/*if(stock=='Tous')
{*/
  stock='GENERAL';
//}
if(user=='Tous')
{
  user='All';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='VENTE DU ' + from_d + ' AU ' + to_d;
  var bas='Etabli par ' + $('#sess_name').val() + ' A la date du ' + today ;
  var titre='BLUE SKY';

  $.ajax({
   url:"tables/tab_rap_vente.php",
   method:'GET',
   data:{cat:client,from_d:from_d,to_d:to_d,party:party},
   beforeSend : function ()
      {
         $("#tab_rap_vente").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_vente').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      "paging":false,
                      "bFilter":false,
                      "ordering":false
                     });

    }
    })
}

function load_rap_vente_tab_ingred(from_d,to_d)
{
  $.ajax({
   url:"tables/tab_rap_vente_ingred.php",
   method:'GET',
   data:{from_d:from_d,to_d:to_d},
   beforeSend : function ()
      {
         $("#tab_rap_vente").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_vente').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_rap_vente_tab_tot_ingred(from_d,to_d)
{
  $.ajax({
   url:"tables/tab_rap_vente_tot_ingred.php",
   method:'GET',
   data:{from_d:from_d,to_d:to_d},
   beforeSend : function ()
      {
         $("#tab_rap_vente").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_vente').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_rap_caisse_tab(caisse,from_d,to_d)
{
var caisse2 = $("#caisse_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

if(caisse2=='')
{
  caisse2='GENERAL';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='USER : ' + caisse2 + '/RAPPORT DE LA CAISSE DU ' + from_d + ' AU ' + to_d;
  var bas='Etabli par ' + $('#sess_name').val() + ' A la date du ' + today ;
  var titre='Hotel';

  $.ajax({
   url:"tables/tab_rap_caisse.php",
   method:'GET',
   data:{caisse:caisse,from_d:from_d,to_d:to_d},
   beforeSend : function ()
      {
         $("#tab_rap_caisse").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_caisse').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "ordering":false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv',
                      {
              extend: 'excel',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }
                    ,
                    {
              extend: 'pdf',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    },
                  {
              extend: 'print',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }]
                     });


    }
    })
}

function load_cont_caisse_tab(caisse,from_d,to_d)
{
var caisse2 = $("#caisse_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

if(caisse2=='')
{
  caisse2='GENERAL';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='USER : ' + caisse2 + '/RAPPORT DE LA CAISSE DU ' + from_d + ' AU ' + to_d;
  var bas='Etabli par ' + $('#sess_name').val() + ' A la date du ' + today ;
  var titre='Hotel';

  $.ajax({
   url:"tables/tab_cont_caisse.php",
   method:'GET',
   data:{caisse:caisse,from_d:from_d,to_d:to_d},
   beforeSend : function ()
      {
         $("#tab_cont_caisse").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_cont_caisse').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "ordering":false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv',
                      {
              extend: 'excel',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }
                    ,
                    {
              extend: 'pdf',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    },
                  {
              extend: 'print',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }]
                     });


    }
    })
}

function load_rap_stk_mp_tab(prod,from_d,to_d,stk,pos,id_per)
{
var stock = $("#pos_rap option:selected").text();
var product = $("#content_id").val();
var today = new Date();
var dd = today.getDate();

if(stock=='Tous')
{
  stock='GENERAL';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='STOCK : ' + stock + ' \n FICHE DU STOCK : ' + product + '\n DU ' + from_d + ' AU ' + to_d;
  var bas='Etabli par ' + $('#sess_name').html() + ' \n A la date du ' + today ;
  var titre=$('#soft_title').html();

  $.ajax({
   url:"tables/tab_rap_stk_mp.php",
   method:'GET',
   data:{prod:prod,from_d:from_d,to_d:to_d,stk:stk,pos_rap:pos,id_per:id_per},
   beforeSend : function ()
      {
         $("#tab_rap_stk_mp").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_stk_mp').html(data);
        $('#example23').DataTable({
                      "ordering":false,
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', {
              extend: 'excel',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }
                    ,
                    {
              extend: 'pdf',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    },
                  {
              extend: 'print',
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }]

                     });


    }
    })
}

function load_rap_stk_pf_tab(prod,from_d,to_d,pos)
{
  $.ajax({
   url:"tables/tab_rap_stk_pf.php",
   method:'GET',
   data:{prod:prod,from_d:from_d,to_d:to_d,pos:pos},
   beforeSend : function ()
      {
         $("#tab_rap_stk_pf").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_stk_pf').html(data);
        $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });


    }
    })
}

function load_srch_rap_stk_mp_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_stk_mp.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      //$(".select2").select2();
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_rap_stk_pf_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_stk_pf.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      $(".select2").select2();
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_rap_prod_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_hist_prod.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_rap_prod_tab(from_d,to_d)
{
  $.ajax({
   url:"tables/tab_hist_prod.php",
   method:"GET",
   data:{from_d:from_d, to_d:to_d},
   beforeSend : function ()
      {
         $("#tab_hist_prod").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_hist_prod').html(data);

        $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      "pageLength": 10,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });
    }
    })
}





//rapport bob

function load_srch_bon_cmd()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_bon_cmd.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}



function load_srch_tarif_vente()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_tarif.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);

    }
  });
}

function load_tab_bon_cmd(four,from_d,to_d,pos)
{
  $.ajax({
   url:"tables/tab_bon_cmd.php",
   method:'GET',
   data:{four:four,from_d:from_d,to_d:to_d,pos:pos},
   beforeSend : function ()
      {
         $("#tab_bon_cmd").html('Chargement...');
      },
   success:function(data)
   {

    $('#tab_bon_cmd').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_det_bon_cmd(op_id)
{
  $.ajax({
   url:"tables/tab_det_bon_cmd.php",
   method:'POST',
   data:{op_id:op_id},
   beforeSend : function ()
      {
         $("#tab_bon_cmd").html('Chargement...');
      },
   success:function(data)
   {
    $('#tab_bon_cmd').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_tab_conso_per(from_d, to_d, pos)
{
  $.ajax({
   url:"tables/tab_rap_conso_per.php",
   method:'POST',
   data:{from_d:from_d,to_d:to_d, pos:pos},
   beforeSend : function ()
      {
         $("#tab_conso_per").html('Chargement ...');
      },
   success:function(data)
   {
    $('#tab_conso_per').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_tab_syn_per(from_d, to_d,stk,pos,user)
{
var stock = $("#pos_rap option:selected").text();
var user2 = $("#user_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

if(stock=='Tous')
{
  stock='GENERAL';
}
if(user2=='Tous')
{
  user2='All';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='STOCK : ' + stock + ' & USER : ' + user2 + '/CONSOMMATION DU ' + from_d + ' AU ' + to_d;
  var bas='Etabli par ' + $('#sess_name').val() + ' A la date du ' + today ;
  var titre='BLUE SKY';

  $.ajax({
   url:"tables/tab_rap_fiche_syn.php",
   method:'POST',
   data:{from_d:from_d,to_d:to_d,stk:stk,pos:pos,user:user},
   beforeSend : function ()
      {
         $("#tab_syn_per").html('Chargement ...');
      },
   success:function(data)
   {
    $('#tab_syn_per').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv',
                      {
              extend: 'excel',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }
                    ,
                    {
              extend: 'pdf',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    },
                  {
              extend: 'print',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }]
                     });

    }
    })
}

function load_inv_valo(id_per)
{
  $.ajax({
   url:"tables/tab_inv_val.php",
   method:'POST',
   data:{id_per:id_per},
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_inv_init()
{
  $.ajax({
   url:"tables/tab_inv_init.php",
   method:'POST',
   //data:{id_per:id_per},
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_syn_stk()
{
  $.ajax({
   url:"tables/tab_syn_stk.php",
   method:'POST',
   //data:{id_per:id_per},
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_srch_conso_per()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_conso_per.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_inv_valo()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_inv_val.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_situ_gen()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_situ_gen.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_situ_lot()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_situ_lot.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_srch_syn_per()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_syn_per.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}



function load_tab_rupture()
{
  $.ajax({
   url:"tables/tab_situ_stock_rupture.php",
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_tab_near_exp()
{
  $.ajax({
   url:"tables/tab_situ_stock_en_exp.php",
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}

function load_tab_exp_prod()
{
  $.ajax({
   url:"tables/tab_situ_stock_exp_prod.php",
   beforeSend : function ()
      {
         $("#page-content").html('Chargement...');
      },
   success:function(data)
   {
    $('#page-content').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                     });

    }
    })
}



function load_tab_prod_sale_jour_ant(jour)
{

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'_'+mm+'_'+dd;

  var haut='Sythèse de Caisse Par  : '+ $('#sess_name').html() +'\n';
  var bas='Etabli par ' + $('#sess_name').html() + '\n A la date du ' + today ;
  var titre='synthese_caisse_du_'+today + '_par_' + $('#sess_name').html();

  $.ajax({
    method:'GET',
    url:'tables/tab_prod_sale_jour_ant.php',
    data:{jour:jour},
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      $('#example2').DataTable({
                      "bInfo": false,
                      "ordering": false,
                      "paging":false,
                      "bLengthChange": false,
                      "bFilter":false
                     });
    }
  });
}

function load_tab_tarif_vente(ass)
{

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='Tarif de vente';
  var bas='Etabli par ' + $('#sess_name').html() + '\n à la date du ' + today ;
  var titre=$('#soft_title').html();

  $.ajax({
   url:"tables/tab_tarif_vente.php",
   method:'GET',
   data:{ass:ass},
   beforeSend : function ()
      {
         $("#disp_tarif_vente").html('Chargement...');
      },
   success:function(data)
   {

    $('#disp_tarif_vente').html(data);
    $('#example23').DataTable({
                      "bInfo": false,
                      "bLengthChange": false,
                      dom: 'Bfrtip',
                      buttons: ['copy', 'csv',
                      {
              extend: 'excel',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }
                    ,
                    {
              extend: 'pdf',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    },
                  {
              extend: 'print',
              footer:true,
              title: titre,
              messageTop: haut,
              messageBottom: bas
                    }]
                     });

    }
    })
}


function load_srch_rap_syn_cui_tab()
{
  $.ajax({
    type:'GET',
    url:'forms/frm_srch_rap_syn_cui.php',
    beforeSend : function ()
      {
         $("#page-content").html('loading...');
      },
    success:function(data)
    {
      $('#page-content').html(data);
      jQuery('#datepicker').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
      jQuery('#datepicker2').datepicker({
               autoclose: true
                , todayHighlight: true
                , format: 'yyyy-mm-dd'
              });
    },
    error: function() {
    alert('La requête n\'a pas abouti'); }
  });
}

function load_rap_syn_per(from_d,to_d,stk,pos,id_per)
{
var stock = $("#pos_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

if(stock=='Tous')
{
  stock='GENERAL';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='MOUVEMENT DU STOCK : ' + stock + ' \n DU ' + from_d + ' AU ' + to_d;
  var bas='A la date du ' + today ;
  var titre=$('#soft_title').html();

  $.ajax({
   url:"tables/tab_rap_syn_stk.php",
   method:'GET',
   data:{from_d:from_d,to_d:to_d,stk:stk,pos_rap:pos,id_per:id_per},
   beforeSend : function ()
      {
         $("#tab_rap_syn").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_syn').html(data);
        $('#example23').DataTable({
                      //"bInfo": false,
                      //"paging":false,
                      "bLengthChange": false,
                      "ordering":false,
                      //bFilter:false,
                      pagingType: "simple"
                     });


    }
    })
}

function load_rap_syn_cui_per(from_d,to_d,stk,pos,id_per)
{
var stock = $("#pos_rap option:selected").text();
var today = new Date();
var dd = today.getDate();

if(stock=='Tous')
{
  stock='GENERAL';
}

var mm = today.getMonth()+1;
var yyyy = today.getFullYear();
if(dd<10)
{
    dd='0'+dd;
}

if(mm<10)
{
    mm='0'+mm;
}
today = yyyy+'/'+mm+'/'+dd;

  var haut='MOUVEMENT DU STOCK : ' + stock + ' \n DU ' + from_d + ' AU ' + to_d;
  var bas='A la date du ' + today ;
  var titre=$('#soft_title').html();

  $.ajax({
   url:"tables/tab_rap_syn_stk_cui.php",
   method:'GET',
   data:{from_d:from_d,to_d:to_d,stk:stk,pos_rap:pos,id_per:id_per},
   beforeSend : function ()
      {
         $("#tab_rap_syn").html('Chargement...');
      },
   success:function(data)
   {
        $('#tab_rap_syn').html(data);
        $('#example23').DataTable({
                      //"bInfo": false,
                      //"paging":false,
                      "bLengthChange": false,
                      "ordering":false,
                      //bFilter:false,
                      pagingType: "simple"
                     });


    }
    })
}