<?php
include_once("connexion.php");

class Journal
{

    private $jourId;
    private $personneId;
    private $openBal;
    private $closingBal;
    private $closingCash;
    private $startDate;
    private $endDate;
    private $fromD;
    private $toD;
    private $jourState;
    private $posId;

    public function setJourId($jourId)
    {
        $this->jourId = $jourId;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = $personneId;
    }

    public function setPosId($posId)
    {
        $this->posId = $posId;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = (string)$startDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = (string)$endDate;
    }

    public function setJourState($jourState)
    {
        $this->jourState = (string)$jourState;
    }

    public function setOpenBal($openBal)
    {
        $this->openBal = $openBal;
    }

    public function setClosingBal($closingBal)
    {
        $this->closingBal = $closingBal;
    }


    public function getJourId()
    {
        return $this->jourId;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }

    public function getPosId()
    {
        return $this->posId;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function getFromD()
    {
        return $this->fromD;
    }

    public function getToD()
    {
        return $this->toD;
    }

    public function getJourState()
    {
        return $this->jourState;
    }

    public function getOpenBal()
    {
        return $this->openBal;
    }

    public function getClosingBal()
    {
        return $this->closingBal;
    }

    public function getClosingCash()
    {
        return $this->closingCash;
    }

    public function getTableName()
    {
        return "tbl_journal";
    }

    public function select_by_state($personneId)
    {
        $db = getConnection();
        try
        {
            $stmt = $db->prepare("SELECT * FROM tbl_journal WHERE personne_id=? and jour_state='1'");
            $stmt->bindValue(1,$personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }
    public function getJournal($jourId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_journal WHERE journal_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$jourId]);
        $data = $stmt->fetchObject();
        return $data;
    }
    public function getJournalActif($personneId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_journal WHERE user_id=? and jour_state='1'");
        $stmt->execute([$personneId]);
        $rowObject = $stmt->fetchObject();
        return $rowObject;
    }
    public function select_by_date($posId,$startDate)
    {
        $db = getConnection();
            $stmt = $db->prepare("SELECT * FROM tbl_journal WHERE store_id=? and start_date=?");
            $stmt->bindValue(1,$posId);
            $stmt->bindValue(2,$startDate);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject();
    }

    public function insert($personneId,$posId,$openBal,$startDate)
    {
        $db = getConnection();
        try
        {
            $sql = "INSERT INTO tbl_journal (user_id,store_id,open_bal,start_date) VALUES(?,?,?,?)";
            $stmt = $db->prepare($sql);
            
            $stmt->execute([$personneId,$posId,$openBal,$startDate]);
            return $db->lastInsertId();
        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }

    
    public function close_day($personneId,$closingBal,$closingCash)
    {
        $db = getConnection();
        try
        {
            $sql = " UPDATE tbl_journal SET closing_bal=?,closing_cash=?,end_date=now(),to_d=now(),jour_state='0' WHERE user_id=? and jour_state='1'";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1,$closingBal);
            $stmt->bindValue(2,$closingCash);
            $stmt->bindValue(3,$personneId);

            return (bool)$stmt->execute();
        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }
    
    public function insert_2($personneId,$posId,$startDate)
    {
        $db = getConnection();
        try
        {
            $sql = " INSERT INTO tbl_journal (user_id,store_id,start_date) VALUES(?,?,?)";
            $stmt = $db->prepare($sql);
            
            $stmt->execute([$personneId,$posId,$startDate]);
            return $db->lastInsertId();
        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }

    public function select($jourId)
    {
        $db = getConnection();
        try
        {
            $sql =  "SELECT * FROM tbl_journal WHERE journal_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id",$jourId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }
}
