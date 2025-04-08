<?php
require_once("connexion.php");
require_once("branches.class.php");
class Caisse
{
    //
    //ajouter un article
    public function setCaisse($caisse, $branche, $status)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_caisses (caisse_name,branche_id,status) VALUES (?,?,?)");
        $addline1 = $add1->execute(array($caisse, $branche, $status)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }


    public function getCaisses()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_caisses as c, tbl_branches as b 
            WHERE  b.branche_id = c.branche_id order by b.branche");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getCaisseBranche($name)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_caisses as c, tbl_branches as b 
            WHERE  b.branche_id = c.branche_id and b.branche_id = ?");
        $statement->execute([$name]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }
    public function getIdCaisseBranche($name)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_caisses as c, tbl_branches as b 
            WHERE  b.branche_id = c.branche_id and b.branche_id = ?");
        $statement->execute([$name]);
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getCaisseId($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_caisses as c, tbl_branches as b 
            WHERE  b.branche_id = c.branche_id and c.caisse_id = ?");
        $statement->execute([$id]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }


    public function select_id($branche)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_caisses as c, tbl_branches as b, tbl_stores as s 
            WHERE  b.branche_id = c.branche_id and s.branche_id=b.branche_id and c.store_id =?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $branche);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function searchAllCaisses($let)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_caisses as p join tbl_branches as c on 
        p.branche_id=c.branche_id  where  caisse_name like '" . $let . "%' order by caisse_name");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function updateCaisse($caisse, $status, $id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_caisses SET caisse_name=?,status=? WHERE caisse_id =?");
        $ok = $update->execute(array($caisse, $status, $id)) or die(print_r($update->errorInfo()));
        return $ok;
    }

    public function select_status($status, $branche)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_caisses WHERE status=? and branche_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $status);
            $stmt->bindValue(2, $branche);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_status_2($status, $branche)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_caisses WHERE status=? and caisse_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $status);
            $stmt->bindValue(2, $branche);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_status_3($status)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_caisses WHERE status=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $status);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
