<?php
require_once("connexion.php");

class Branches
{
    public $branches_id;
    public $branches;
    public $pays;

    //                

    //ajouter un article
    public function setBranches($branche, $adresse)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_branches (branche,adresse) VALUES (?,?)");
        $addline1 = $add1->execute(array($branche, $adresse)) or die(print_r($add1->errorInfo()));

        $id = $db->lastInsertId();

        $add = $db->prepare("INSERT INTO tbl_stores (store,type,branche_id) VALUES (?,?,?)");
        $add->execute(array($branche, 'VENTE', $id)) or die(print_r($add1->errorInfo()));

        $ad = $db->prepare("INSERT INTO tbl_stores (store,type,branche_id) VALUES (?,?,?)");
        $ad->execute(array($branche, 'STOCK', $id)) or die(print_r($add1->errorInfo()));



        // $a= $db->prepare("INSERT INTO tbl_users (noms,tel,email,username,password,role_id) VALUES (?,?,?,?,?,?)");
        // $a->execute(array($branche,'','',$usename,$pwd,2)) or die(print_r($add1->errorInfo()));

        // $e= $db->prepare("INSERT INTO tbl_personnes (nom_complet,contact,email,adresse,role) VALUES (?,?,?,?,?)");
        // $e->execute(array($branche,'','','','',5)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }

    public function setNotes($type, $descr, $user_id)
    {
        $db = getConnection();

        $a = $db->prepare("INSERT INTO tbl_notes (type,descr,user_id) VALUES (?,?,?)");
        $addline1 = $a->execute(array($type, $descr, $user_id)) or die(print_r($a->errorInfo()));

        return $addline1;
    }



    public function getBranches()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_branches where statut='1'");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getAll()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_branches");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getNotes()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_notes as n, tbl_users as u WHERE n.user_id = u.user_id");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getBranche($branches_id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * 
            FROM tbl_branches WHERE  statut='1' and branche_id = ?");
        $statement->execute([$branches_id]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }

    public function getBranche_0($branches_id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * 
            FROM tbl_branches WHERE  statut='1' and branche_id = ?");
        $statement->execute([$branches_id]);
        $tbP = $statement->fetchAll(PDO::FETCH_OBJ);
        return $tbP;
    }

    public function getStoreId($posId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.store_id=:store_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("store_id", $posId);
        $stmt->execute();

        $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rowObject;
    }

    public function getNoteId($note_id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_notes as n, tbl_users as u WHERE n.user_id = u.user_id and note_id = ?");
        $statement->execute([$note_id]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }

    public function getBrancheId($branches_id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * 
            FROM tbl_branches WHERE  statut='1' and branche_id = ?");
        $statement->execute([$branches_id]);
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }


    public function deletebranches($branches_id)
    {
        $db = getConnection();
        $sql = $db->prepare("DELETE FROM tbl_branches WHERE branche_id=?");
        $ok = $sql->execute(array($branches_id));
        return $ok;
    }

    public function updatebranches($branches, $pays, $id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_branches SET branches=?,pays=? WHERE branches_id =?");
        $ok = $update->execute(array($branches, $pays, $id)) or die(print_r($update->errorInfo()));
        return $ok;
    }


    public function select_1($personneId)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * from tbl_branches where branche_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_one($Id, $val_id, $val_n, $val_f)
    {

        $db =  getConnection();
        try {
            $sql = " UPDATE tbl_branches SET " . $val_n . " =:val_f WHERE " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
