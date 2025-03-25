<?php
require_once("connexion.php");

class Achat
{
    private $idachats;
    private $amount;
    private $opId;
    private $isPaid;
    private $numAchat;

    public function setIdachats($idachats)
    {
        $this->idachats = (int)$idachats;
    }
    public function setNumAchat($numachat)
    {
        $this->numAchat = $numachat;
    }

    public function setAmount($amount)
    {
        $this->amount = (int)$amount;
    }

    public function getIdachats()
    {
        return $this->idachats;
    }

    public function getNumAchat()
    {
        return $this->numAchat;
    }

    public function getAmount()
    {
        return $this->amount;
    }


    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }
    public function setIsPaid($isPaid)
    {
        $this->isPaid = (string)$isPaid;
    }

        public function getAchat($idachats)
    {

        $db = getConnection();
        $sql =  "SELECT * FROM tbl_achats WHERE op_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idachats]);
        $tbP = $stmt->fetchObject();
        return $tbP;
    }

    public function setAchat($amount,$op_id,$num_achat,$is_paid)
    {
        $db = getConnection();
        $sql ="INSERT INTO tbl_achats (amount,op_id,num_achat,etat) VALUES(?,?,?,?)";
        $add1 = $db->prepare($sql);
        $addline1 = $add1->execute(array($amount,$op_id,$num_achat,$is_paid)) or die(print_r($add1->errorInfo()));

        return $addline1;

    }

    public function update($amount,$opId)
    {
        $db = getConnection();
            try 
            {
            $sql =" UPDATE tbl_achats SET amount=:amount WHERE op_id=:opId";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("amount",$amount);
         $stmt->bindParam("opId",$opId);
        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }


}
