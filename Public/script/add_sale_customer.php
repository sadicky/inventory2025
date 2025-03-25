<?php

session_start();
require_once '../load_model.php';
// $pers = new BeanPersonne();
// $cust = new BeanCustomer();
// $ben=new BeanBen();
// $vente=new BeanVente();
// $op=new BeanOperation();
// $det=new BeanDetailsOperation();

$cust_id=$_POST['cust_id'];
if(isset($_SESSION['op_vente_id']))
  {
    $op->select($_SESSION['op_vente_id']);
    $cust->select($op->getPartyCode());
  }
  
  if(empty($_POST['cust_id']))
  {
  if($cust->exist_code($_POST['cust_code']))
  {
    echo 'Numero matricule existe déjà';
  }
  else
  {
  $pers->setRole('4');
  $pers->setNomComplet($_POST['content_lib_cust']);
  $pers->setContact($_POST['tel']);
  $pers->setEmail('-');
  $pers->setGenre('-');
  $cust_id=$pers->insert();
  
  
  if(isset($_POST['cust_num'])) $cust->update_one($cust_id,'personne_id','customer_num',$_POST['cust_num']);
  if(isset($_POST['cust_adr'])) $cust->update_one($cust_id,'personne_id','customer_adr',$_POST['cust_adr']);
  
   //$cust->select($cust_id);
   if($cust->getCustomerCat()=='Anonyme')
   {
      $op->update_one($_POST['op_id'],'op_id','party_code',$cust_id);
      $cust->update_one($cust_id,'personne_id','customer_cat','Particulier');
   }
    else
    {
      $op->update_one($_POST['op_id'],'op_id','aff_id',$cust_id);
      $cust->update_one($cust_id,'personne_id','customer_code',$_POST['cust_code']);
      $cust->update_one($cust_id,'personne_id','customer_exp',$_POST['cust_exp']);
      $cust->update_one($cust_id,'personne_id','customer_type',$_POST['cust_ass']);
      $cust->update_one($cust_id,'personne_id','customer_percent',$_POST['cust_percent']);
      $cust->update_one($cust_id,'personne_id','customer_serv',$_POST['cust_serv']);
    }
  //echo 'a';
  }
  }
  else
  {
      if($cust->getCustomerCat()=='Anonyme')
      {
      $op->update_one($_POST['op_id'],'op_id','party_code',$cust_id);
      }
      else
      {
      $op->update_one($_POST['op_id'],'op_id','aff_id',$cust_id);

      $cust->update_one($cust_id,'personne_id','customer_exp',$_POST['cust_exp']);
      $cust->update_one($cust_id,'personne_id','customer_type',$_POST['cust_ass']);
      $cust->update_one($cust_id,'personne_id','customer_percent',$_POST['cust_percent']);
      $cust->update_one($cust_id,'personne_id','customer_code',$_POST['cust_code']);
      $cust->update_one($cust_id,'personne_id','customer_serv',$_POST['cust_serv']);
      }
      
      if(isset($_POST['cust_num']))$cust->update_one($cust_id,'personne_id','customer_num',$_POST['cust_num']);
      if(isset($_POST['cust_adr']))$cust->update_one($cust_id,'personne_id','customer_adr',$_POST['cust_adr']);
      
      //echo 'b';
  }

  if(empty($_POST['ben_id']) and !empty($_POST['ben_name']))
    {
      $ben->setName($_POST['ben_name']);
      $ben->setTyp($_POST['ben_typ']);
      $ben->setPersonneId($cust_id);
      $last_ben=$ben->insert();
      
      $op->update_one($_POST['op_id'],'op_id','ben_id',$last_ben);
      //echo 'c';
    }
    else
    {
     $op->update_one($_POST['op_id'],'op_id','ben_id',$_POST['ben_id']);
     //$ben->update_one($_POST[''],'name','ben_id',$_POST['ben_name']); 
     //echo 'd';
    }
    $det->update_one($_POST['op_id'],'op_id','det',$_POST['cust_percent']);
?>
