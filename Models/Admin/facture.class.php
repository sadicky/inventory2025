<?php
require_once("dbconnect.php");


// namespace beans;

class BeanFacture extends dbconnect
{

    private $factId;
    private $factDebut;
    private $factFin;
    private $factEch;
    private $factRed;
    private $factAmount;
    private $factCust;
    private $factNum;

    public function setFactId($factId)
    {
        $this->factId =$factId;
    }
    public function setFactDebut($factDebut)
    {
        $this->factDebut =$factDebut;
    }

    public function setFactFin($factFin)
    {
        $this->factFin =$factFin;
    }

    public function setFactEch($factEch)
    {
        $this->factEch = $factEch;
    }

    public function setFactRed($factRed)
    {
        $this->factRed =$factRed;
    }

    public function setFactAmount($factAmount)
    {
        $this->factAmount =$factAmount;
    }

    public function setFactCust($factCust)
    {
        $this->factCust = (int)$factCust;
    }

    public function setFactNum($factNum)
    {
        $this->factNum = $factNum;
    }

    public function getFactId()
    {
        return $this->factId;
    }

    public function getFactDebut()
    {
        return $this->factDebut;
    }

    public function getFactFin()
    {
        return $this->factFin;
    }

    public function getFactEch()
    {
        return $this->factEch;
    }

    public function getFactRed()
    {
        return $this->factRed;
    }

    public function getFactAmount()
    {
        return $this->factAmount;
    }



    public function getFactCust()
    {
        return $this->factCust;
    }

    public function getFactNum()
    {
        return $this->factNum;
    }

    public function getTableName()
    {
        return "facture";
    }


    public function __construct($factId = null)
    {
        $this->initDB();
        if (!empty($factId)) {
            $this->select($factId);
        }
    }


    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        //unset($this);
    }


    public function select($factId)
    {
        $db = $this->dbase;
        try
        {
        $sql =  "SELECT * FROM facture WHERE fact_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$factId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->factId = $rowObject->fact_id;
            @$this->factDebut = $rowObject->fact_debut;
            @$this->factFin = $rowObject->fact_debut;
            @$this->factEch = $rowObject->fact_ech;
            @$this->factRed = $rowObject->fact_red;
            @$this->factAmount = $rowObject->fact_amount;
            @$this->factCust = $rowObject->fact_cust;
            @$this->factNum = $rowObject->fact_num;
            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

public function select_all(){
 $db = $this->dbase;
 try
 {
 $stmt = $db->prepare("SELECT * from facture order by fact_num");
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

    public function delete($factId)
    {
        $db = $this->dbase;
        try
        {
        $sql = "DELETE FROM facture WHERE fact_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$factId);
        return (bool)$stmt->execute();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }

    public function insert()
    {
        $db = $this->dbase;
            try
            {
        $sql ="INSERT INTO facture
            (fact_debut,fact_fin,fact_ech,fact_red,fact_amount,fact_cust,fact_num)
            VALUES(:factDebut,:factFin,:factEch,:factRed,:factAmount,:factCust,
            :factNum)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("factDebut",$this->factDebut);
            $stmt->bindParam("factFin",$this->factFin);
            $stmt->bindParam("factEch",$this->factEch);
            $stmt->bindParam("factRed",$this->factRed);
            $stmt->bindParam("factAmount",$this->factAmount);
            $stmt->bindParam("factNum",$this->factNum);
            $stmt->bindParam("factCust",$this->factCust);
            

            return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }


    public function update($factId)
    {

            $db = $this->dbase;
            try
            {
                $sql = "
            UPDATE
                facture
            SET
				fact_debut=:factFin,
                fact_fin=:factFin,
				fact_ech=:factEch,
				fact_red=:factRed,
				fact_amount=:factAmount,
                fact_cust=:factCust,
                fact_num=:factNum
            WHERE
                fact_id=:factId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("factFin",$this->factFin);
            $stmt->bindParam("factEch",$this->factEch);
            $stmt->bindParam("factRed",$this->factRed);
            $stmt->bindParam("factAmount",$this->factAmount);
            $stmt->bindParam("factDebut",$this->factDebut);
            $stmt->bindParam("factCust",$this->factCust);
            $stmt->bindParam("factNum",$this->factNum);
            $stmt->bindParam("factId",$factId);


            return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

public function update_one($Id,$val_id,$val_n,$val_f)
       {


        $db = $this->dbase;
            try
            {
            $sql ="
            UPDATE
                ".$this->getTableName()."
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


    public function updateCurrent()
    {
        if ($this->factId != "") {
            return $this->update($this->factId);
        } else {
            return false;
        }
    }

}
?>
