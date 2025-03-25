
$(function() {

$(document).key('alt+a', function() {
  load_frm_new_sale('1');
 });

$(document).key('alt+r', function() {
  load_frm_new_sale('2');
 });

$(document).key('alt+n', function() {
  new_operation_v($('#id').val());
 });

$(document).key('alt+z', function() {
  ajust_num($('#pay_type').val());
  //load_frm_new_sale();
 });

$(document).key('alt+x', function() {
  var printable='facture';
  printData(printable);
 });

 })