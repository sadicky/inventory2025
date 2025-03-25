<?php
require_once("connexion.php");

class Devise
{
   
    public function setDevise($devise, $short, $taux)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_devise (devise,short,taux) VALUES (?,?,?)");
        $addline1 = $add1->execute(array($devise, $short, $taux)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }

    public function updateDevise($devise, $short, $taux, $id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_devise SET devise=?,short=?,taux=?  WHERE devise_id =?");
        $ok = $update->execute(array($devise, $short, $taux, $id)) or die(print_r($update->errorInfo()));
        return $ok;
    }

    public function getDevises()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_devise order by devise ASC");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getDevises2()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_devise where statut='1' order by devise ASC");
        $statement->execute();
        $tbP = $statement->fetchObject();
        return $tbP;
    }
    public function getDevises3()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_devise where statut='0' order by devise ASC");
        $statement->execute();
        $tbP = $statement->fetchObject();
        return $tbP;
    }
    //afficher les catégories
  
    public function getDeviseId($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_devise  WHERE devise_id=?");
        $statement->execute([$id]);
        $data =  $statement->fetchObject();
        return $data;
    }

    public function deleteDevise($id)
    {
        $db = getConnection();
        $delete =  $db->prepare("DELETE FROM tbl_devise WHERE devise_id =?");

        $ok = $delete->execute(array($id));
        return $ok;
    }

}
