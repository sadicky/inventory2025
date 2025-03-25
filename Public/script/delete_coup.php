<?php

require_once '../load_model.php';
$coup = new BeanCoupon();

if(isset($_POST['coupon_id']))
{
  if($_POST['status']=='0')
  {
  $coup->update_one($_POST['coupon_id'],'coupon_id','status',false);
  echo 'Suppression reussie avec succès';
  }
  elseif($_POST['status']=='1')
  {
   $coup->update_one($_POST['coupon_id'],'coupon_id','status',true);
   echo 'Restauration reussie avec succès';
  }


}
else
{
echo " pas Id ";
}

?>
