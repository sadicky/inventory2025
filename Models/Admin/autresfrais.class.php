<?php
include_once("connexion.php");

class AutreFrais
{

    private $autId;
    private $autDet;
    private $opId;
    private $amount;

    public function setAutId($autId)
    {
        $this->autId = (int)$autId;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setAutDet($autDet)
    {
        $this->autDet = (string)$autDet;
    }

    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    public function getAutId()
    {
        return $this->autId;
    }
    public function getAmount()
    {
        return $this->amount;
    }
    public function getAutDet()
    {
        return $this->autDet;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getTableName()
    {
        return "tbl_autre_frais";
    }

    public function close()
    {
        //unset($this);
    }

    public function select($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_autre_frais WHERE aut_id=:aut_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->autId = $rowObject->aut_id;
            @$this->autDet = $rowObject->aut_det;
            @$this->opId = $rowObject->op_id;
            @$this->amount = $rowObject->amount;

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function getReparationId($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_reparations WHERE reparation_id=:aut_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparation_encours_by_branche($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='0' and tbl_reparations.statutr ='encours' and branche_id=:aut_id  ORDER BY reparation_id DESC ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparation_annuler_by_branche($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='2' and tbl_reparations.statutr ='annulé' and branche_id=:aut_id  ORDER BY reparation_id DESC ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function getReparation_payer_by_branche($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,tbl_reparations.statutr,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
          and tbl_reparations.statutr ='effectué' and branche_id=:aut_id  ORDER BY reparation_id DESC ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparation_effectuer_by_branche($autId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statutr ='effectué' and branche_id=:aut_id  ORDER BY reparation_id DESC ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("aut_id", $autId);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparations_encours()
    {
        $db = getConnection();

        try {
            $sql = "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='0' and tbl_reparations.statutr ='encours' ORDER BY reparation_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparations_annuler()
    {
        $db = getConnection();

        try {
            $sql = "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='2' and tbl_reparations.statutr ='annulé' ORDER BY reparation_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparations_payer()
    {
        $db = getConnection();

        try {
            $sql = "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,tbl_reparations.statutr ,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='2' and tbl_reparations.statutr ='effectué' ORDER BY reparation_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function getReparations_effectuer()
    {
        $db = getConnection();

        try {
            $sql = "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and tbl_reparations.statut ='2' and tbl_reparations.statutr ='effectué' ORDER BY reparation_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function getReparations($from, $to, $pos_id)
    {
        $db = getConnection();

        try {
            $sql = "SELECT tbl_reparations.reparation_id,tbl_reparations.customer,tbl_reparations.montant,
         tbl_reparations.statut,tbl_reparations.date_create,tbl_users.noms,tbl_reparations.motif,
         tbl_reparations.tel from tbl_reparations,tbl_users Where tbl_reparations.personne_id = tbl_users.user_id 
         and (date(date_create) between :from_d and :to_d) and tbl_reparations.branche_id=:posId  ORDER BY reparation_id DESC";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("from_d", $from);
            $stmt->bindParam("to_d", $to);
            $stmt->bindParam("posId", $pos_id);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_sum_op($opId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT sum(amount) as tot FROM tbl_autre_frais where op_id=? group by op_id");
        $stmt->execute([$opId]);
        $stat = $stmt->fetchObject();
        return $stat;
    }

    public function select_all_op($op_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_autre_frais where op_id=?");
            $stmt->bindValue(1, $op_id);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($autId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_autre_frais WHERE aut_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $autId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function insert()
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO `tbl_autre_frais`(`op_id`,`amount`, `aut_det`)
            VALUES(:opId,:amount,:autDet)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam("opId", $this->opId);
            $stmt->bindParam("amount", $this->amount);
            $stmt->bindParam("autDet", $this->autDet);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function setCaisse($op_id, $client, $tel, $adresse, $motif, $montant, $date, $depot,  $statut, $idu)
    {
        $db = getConnection();
        $add = $db->prepare("INSERT INTO tbl_reparations (op_id,customer,tel,adresse,motif,montant,date_create,branche_id,statut,statutr,personne_id) 
         VALUES (?,?,?,?,?,?,?,?,?,?,?)
    ");
        $addline = $add->execute(array($op_id, $client, $tel, $adresse, $motif, $montant,  $date, $depot, $statut, 'encours', $idu)) or die(print_r($add->errorInfo()));
        return $addline;
    }
    public function update_one($Id, $val_id, $val_n, $val_f)
    {


        $db = getConnection();
        try {
            $sql = "
            UPDATE
                " . $this->getTableName() . "
            SET
                " . $val_n . " =:val_f
            WHERE
               " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function activRep($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_reparations SET statut='1' WHERE reparation_id=?");
        $d = $req->execute(array($iduser));
        return $d;
    }

    public function activRep1($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_reparations SET statutr='effectué' WHERE reparation_id=?");
        $d = $req->execute(array($iduser));
        return $d;
    }

    public function desactRep($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_reparations SET statut='0' WHERE reparation_id=?");
        $d = $req->execute(array($iduser));
        return $d;
    }
    public function annulRep($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_reparations SET statut='2', statutr='annulé'  WHERE reparation_id=?");
        $d = $req->execute(array($iduser));
        return $d;
    }
}
