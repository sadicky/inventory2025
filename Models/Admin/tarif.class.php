<?php
include_once("connexion.php");

class Tarif
{

    private $tarId;
    private $tarCode;
    private $tarName;
    private $status;
    private $personneId;

    public function setTarId($tarId)
    {
        $this->tarId = (int)$tarId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = $personneId;
    }

    public function setTarName($tarName)
    {
        $this->tarName = (string)$tarName;
    }

    public function setTarCode($tarCode)
    {
        $this->tarCode = (string)$tarCode;
    }

    public function getTarId()
    {
        return $this->tarId;
    }
    public function getStatus()
    {
        return $this->status;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }

    public function getTarName()
    {
        return $this->tarName;
    }

    public function getTarCode()
    {
        return $this->tarCode;
    }


    public function select($tarId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_prices as p,tbl_branches as b WHERE p.branche_id=b.branche_id and b.branche_id=:tarId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("tarId", $tarId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_3($prodId, $tarId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT product_name FROM tbl_prices as p,tbl_products as pr WHERE p.product_id=pr.product_id and  product_id=:id and branche_id=:tarId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $prodId);
            $stmt->bindParam("tarId", $tarId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    
    public function select_2($prodId, $tarId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_prices  WHERE product_id=:id and branche_id=:tarId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $prodId);
            $stmt->bindParam("tarId", $tarId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function select_status($status)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_prices WHERE status=:status";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("status", $status);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->tarId = $rowObject->price_id;
            @$this->tarName = $rowObject->tar_name;
            @$this->tarCode = $rowObject->tar_code;
            @$this->status = $rowObject->status;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_prices order by price");
            //$stmt->bindParam("personneId",$personneId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($tableId)
    {

        $db = getConnection();
        try {
            $sql = "DELETE FROM `tbl_prices` WHERE price_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $tableId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($tarId)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_prices
            SET
                tar_name=:tarName,
                tar_code=:tarCode,
                status=:status,
                personne_id=:personneId
            WHERE
                branche_id=:tarId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("tarName", $this->tarName);
            $stmt->bindParam("tarCode", $this->tarCode);
            $stmt->bindParam("status", $this->status);
            $stmt->bindParam("personneId", $this->personneId);
            $stmt->bindParam("tarId", $tarId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_2($val_f)
    {


        $db = getConnection();
        try {
            $sql = "
            UPDATE tbl_prices
            SET
                status =:val_f";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            //$stmt->bindParam("personneId",$personneId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_code($code)
    {
        $db = getConnection();

        try
        {
            $sql =  "SELECT * FROM tbl_prices WHERE tar_code=:code";
            $stmt=$db->prepare($sql);
            $stmt->bindParam("code",$code);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->tarId = $rowObject->tar_id;
            @$this->tarName = $rowObject->tar_name;
            @$this->tarCode = $rowObject->tar_code;
            @$this->status = $rowObject->status;
            @$this->personneId = $rowObject->personneId;

            return $stmt->rowCount();

        }
        catch(PDOException $ex)
        {
            return $ex;
        }
    }


    public function update_one($Id, $val_id, $val_n, $val_f)
    {


        $db = getConnection();
        try {
            $sql = "
            UPDATE tbl_prices
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

    public function exist_tar($tarId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM price where branche_id=:tarId");
            $stmt->bindParam("tarId", $tarId);
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function exist_tar_prod($tarId, $prodId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_prices where branche_id=:tarId and product_id=:prodId");
            $stmt->bindParam("tarId", $tarId);
            $stmt->bindParam("prodId", $prodId);
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
