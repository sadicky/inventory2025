<?php
require_once("connexion.php");

class CheckExp 
{

    private $id;
    private $prodId;
    private $det;
    private $lot;
    private $dateExp;
    private $idPer;
    private $qt;


    public function setId($id)
    {
        $this->id = (int)$id;
    }

    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }

    public function setIdPer($idPer)
    {
        $this->idPer = $idPer;
    }

    public function setLot($lot)
    {
        $this->lot = $lot;
    }


    public function setDet($det)
    {
        $this->det = $det;
    }

    public function setQt($qt)
    {
        $this->qt = $qt;
    }

    public function setProdId($prodId)
    {
        $this->prodId = (int)$prodId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateExp()
    {
        return $this->dateExp;
    }

    public function getIdPer()
    {
        return $this->idPer;
    }

    public function getLot()
    {
        return $this->lot;
    }

    public function getDet()
    {
        return $this->det;
    }

    public function getQt()
    {
        return $this->qt;
    }


    public function getProdId()
    {
        return $this->prodId;
    }


    public function getTableName()
    {
        return "tbl_tbl_check_exp";
    }

    public function __destruct()
    {
        $this->close();
    }


    public function close()
    {
        //unset($this);
    }

    public function select($id)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_check_exp WHERE id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$id);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->id = $rowObject->id;
            @$this->prodId = $rowObject->prod_id;
            @$this->det = $rowObject->det;
            @$this->lot = $rowObject->lot;
            @$this->dateExp = $rowObject->date_exp;

            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_min_date($id)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT min(date_exp) as dateExp FROM tbl_check_exp WHERE prod_id=:id and det='1'";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$id);
        $stmt->execute();
        $stat=$stmt->fetch();
        return $stat['dateExp'];
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_lot($dateExp,$prodId)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_check_exp WHERE date_exp=:dateExp and prod_id=:prodId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("dateExp",$dateExp);
        $stmt->bindParam("prodId",$prodId);
        //$stmt->bindParam("stk",$stk);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->id = $rowObject->id;
            @$this->prodId = $rowObject->prod_id;
            @$this->det = $rowObject->det;
            @$this->lot = $rowObject->lot;
            @$this->dateExp = $rowObject->date_exp;
            @$this->qt = $rowObject->qt;

            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_lot2($lot,$prodId)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_check_exp WHERE lot=:lot and prod_id=:prodId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$lot);
        $stmt->bindParam("prodId",$prodId);
        //$stmt->bindParam("stk",$stk);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->id = $rowObject->id;
            @$this->prodId = $rowObject->prod_id;
            @$this->det = $rowObject->det;
            @$this->lot = $rowObject->lot;
            @$this->dateExp = $rowObject->date_exp;
            @$this->qt = $rowObject->qt;

            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }


public function select_all($prodId,$det)
 {
 $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT * FROM tbl_check_exp where  prod_id=:prodId and det=:id ");
 $stmt->bindParam("id",$det);
 $stmt->bindParam("prodId",$prodId);
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

 public function select_nb_exp_prod_stk($n_days)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT *, (to_days(date_exp) - to_days(now())) as r_day FROM `tbl_check_exp` WHERE det='1' and (to_days(date_exp) - to_days(now()))<=:n_days";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("n_days",$n_days);
        //$stmt->bindParam("qt",$qt);
        //$stmt->bindParam("posId",$posId);
        $stmt->execute();

        return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_exp_prod_stk($n_days)
    {
        $db = getConnection();
        try
        {
        $sql =  "SELECT tbl_check_exp.*,(to_days(date_exp) - to_days(now())) as rem_days  FROM `tbl_check_exp` WHERE det='1' and (to_days(date_exp) - to_days(now()))<=:n_days";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("n_days",$n_days);
        //$stmt->bindParam("qt",$qt);
        //$stmt->bindParam("posId",$posId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function insert()
    {
        $db = getConnection();
            try
            {
        $sql ="
            INSERT INTO tbl_check_exp
            (lot,prod_id,date_exp,id_per)
            VALUES(:lot,:prodId,:dateExp,:idPer)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$this->lot);
        $stmt->bindParam("prodId",$this->prodId);
        $stmt->bindParam("dateExp",$this->dateExp);
        $stmt->bindParam("idPer",$this->idPer);

        $stmt->execute();
        return $db->lastInsertId();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }




    public function update_sup($id)
    {

        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_check_exp
            SET
                lot=:lot,
                date_exp=:dateExp,
                id_per=:idPer
            WHERE
                id=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$this->lot);
        $stmt->bindParam("dateExp",$this->dateExp);
        $stmt->bindParam("idPer",$this->idPer);
        $stmt->bindParam("id",$id);

        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update_sup2($lot,$dateExp,$prodId)
    {

        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_check_exp
            SET
                lot=:lot,
                date_exp=:dateExp
            WHERE
                lot=:lot2 and date_exp=:dateExp2 and prod_id=:prodId";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$this->lot);
        $stmt->bindParam("dateExp",$this->dateExp);
        $stmt->bindParam("prodId",$prodId);
        $stmt->bindParam("lot2",$lot);
        $stmt->bindParam("dateExp2",$dateExp);

        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update_det($lot,$prodId)
    {

        $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                tbl_check_exp
            SET
                det=:det
            WHERE
                lot=:lot and prod_id=:prodId";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$lot);
        $stmt->bindParam("prodId",$prodId);
        $stmt->bindParam("det",$this->det);

        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update_det2($lot,$dateExp)
    {

        $db = getConnection();
            try
            {
            $sql ="
            DELETE FROM tbl_check_exp 
            WHERE
                lot=:lot and date_exp=:dateExp";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("lot",$lot);
        $stmt->bindParam("dateExp",$dateExp);
        //$stmt->bindParam("det",$this->det);

        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update_qt($lot,$prodId)
    {

        $db = getConnection();
            try
            {
            $sql ="
            UPDATE tbl_check_exp SET qt=:qt 
            WHERE
                lot=:lot and prod_id=:prodId";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("qt",$this->qt);
        $stmt->bindParam("lot",$lot);
        $stmt->bindParam("prodId",$prodId);
        //$stmt->bindParam("det",$this->det);

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

public function exist_lot($lot,$prodId)
{
$db = getConnection();
            try
            {
$sql="SELECT count(*) from tbl_check_exp where lot=:lot and prod_id=:prodId";
$stmt = $db->prepare($sql);
$stmt->bindParam("lot",$lot);
$stmt->bindParam("prodId",$prodId);

$stmt->execute();
return (bool)$stmt->fetchColumn();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
}



    // public function updateCurrent()
    // {
    //     if ($this->id != "") {
    //         return $this->update($this->id);
    //     } else {
    //         return false;
    //     }
    // }

}
?>
