<?php
require_once("connexion.php");

// namespace beans;

class Account
{

    private $accId;
    private $status;
    private $openBal;
    private $closingBal;
    private $credLimit;
    private $accCur;
    private $personneId;
    private $ddl;



    public function setAccId($accId)
    {
        $this->accId = (int)$accId;
    }

    public function setStatus($status)
    {
        $this->status= (int)$status;
    }


    public function setOpenBal($openBal)
    {
        $this->openBal = (int)$openBal;
    }

    public function setClosingBal($closingBal)
    {
        $this->closingBal = (int)$closingBal;
    }

    public function setCredLimit($credLimit)
    {
        $this->credLimit = (string)$credLimit;
    }

    public function setAccCur($accCur)
    {
        $this->accCur = (string)$accCur;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = (int)$personneId;
    }


    public function getAccId()
    {
        return $this->accId;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getOpenBal()
    {
        return $this->openBal;
    }

    public function getClosingBal()
    {
        return $this->closingBal;
    }

    public function getCredLimit()
    {
        return $this->credLimit;
    }

    public function getAccCur()
    {
        return $this->accCur;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }



    public function getDdl()
    {
        return base64_decode($this->ddl);
    }

    public function select($personneId)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_accounts WHERE personne_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);


            return  $rowObject;
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }

    public function select_acc_perso($personneId)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_accounts WHERE personne_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->accId = $rowObject->acc_id;
            @$this->closingBal = $rowObject->closing_bal;
            @$this->credLimit = $rowObject->cred_limit;
            @$this->accCur = $rowObject->acc_cur;

            @$this->personneId = $rowObject->personne_id;
            @$this->status = $rowObject->status;


            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }




 public function select_all(){
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT tbl_personnes.*, tbl_accounts.* FROM tbl_personnes join tbl_accounts on tbl_personnes.personne_id=tbl_accounts.personne_id");
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

 public function select_all_role($role){
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT tbl_personnes.*, tbl_accounts.* FROM tbl_personnes join tbl_accounts on tbl_personnes.personne_id=tbl_accounts.personne_id where role=:role order by nom_complet");
 $stmt->bindParam("role",$role);
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

 public function select_all_role_cred($role){
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT personne.*, tbl_accounts.* FROM personne join tbl_accounts on personne.personne_id=tbl_accounts.personne_id where role=:role and cred_limit>0 order by nom_complet");
 $stmt->bindParam("role",$role);
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

 public function select_num_role($role){
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT tbl_personnes.*, tbl_accounts.* FROM tbl_personnes join tbl_accounts on tbl_personnes.personne_id=tbl_accounts.personne_id where role=:role");
 $stmt->bindParam("role",$role);
 $stmt->execute();
 $stat = $stmt->rowCount();
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }


 public function exist_acc_perso($personne_id){
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT count(*) as nb FROM tbl_accounts where personne_id=:personne_id");
  $stmt->bindParam("personne_id",$personne_id);
 $stmt->execute();
 $stat = $stmt->fetch();
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }


    public function delete($accId)
    {
        $db = getConnection();
        try
        {
        $sql = "DELETE FROM tbl_accounts WHERE acc_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$accId);
        return (bool)$stmt->execute();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }

    public function insert($personneId)
    {

        $db = getConnection();
            try
            {
         $sql = "INSERT INTO tbl_accounts
            (personne_id)
            VALUES(:personne_id)";
            $stmt = $db->prepare($sql);
            //$stmt->bindParam("closing_bal",$this->closingBal);
            //$stmt->bindParam("cred_limit",$this->credLimit);
            //$stmt->bindParam("acc_cur",$this->accCur);
            $stmt->bindParam("personne_id",$personneId);


            return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }


    public function update_bal($closingBal,$personneId)
    {
        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_accounts
            SET
				closing_bal=:closingBal
            WHERE
                personne_id=:personneId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("closingBal",$closingBal);
            $stmt->bindParam("personneId",$personneId);

            return (bool)$stmt->execute();


            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

        }

        public function update_cash($personneId)
    {


        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_accounts
            SET
                cred_limit=:cred_limit
            WHERE
                personne_id=:personneId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("cred_limit",$this->credLimit);
            $stmt->bindParam("personneId",$personneId);

            return (bool)$stmt->execute();


            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

        }



        public function update_one($Id,$val_id,$val_n,$val_f)
       {


        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_accounts
            SET
                ".$val_n." =:val_f
            WHERE
               ".$val_id."=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f",$val_f);
            $stmt->bindParam("id",$Id);

            return (bool)$stmt->execute();


            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

        }



    // public function updateCurrent()
    // {
    //     if ($this->accId != "") {
    //         return $this->update($this->accId);
    //     } else {
    //         return false;
    //     }
    // }



}
?>
