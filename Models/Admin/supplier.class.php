<?php
require_once("connexion.php");

class Supplier
{
    public function setSupplier($supplier_name,$sup_adresse,$sup_nif,$sup_contact,$id)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_suppliers (supplier_name,sup_adresse,sup_nif,sup_contact,personne_id) VALUES (?,?,?,?,?)");
        $addline1 = $add1->execute(array($supplier_name,$sup_adresse,$sup_nif,$sup_contact,$id)) or die(print_r($add1->errorInfo()));
    
        return $addline1;
    }

    public function getSuppliers()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_suppliers order by supplier_name ASC");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getSupplier($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_suppliers where supplier_id=? ");
        $statement->execute([$id]);
        $tbP =  $statement->fetchObject();
        return $tbP;
    }
    
    public function searchSupplier($keyword)
    {
    $db  = getConnection();
    $stmt = $db->prepare("SELECT * FROM tbl_suppliers  where supplier_name like '%".$keyword."%'");
    $stmt->execute();
    $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $stat;
    }
}
