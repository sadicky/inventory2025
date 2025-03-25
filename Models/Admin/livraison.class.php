<?php
include_once("connexion.php");

class Livraison
{
    private $opId;
    private $livNum;
    private $cmdNum;
    private $dest;
    private $driver;
    private $proId;


    public function setOpId($opId)
    {
        $this->opId = $opId;
    }

    public function setProId($ProId)
    {
        $this->proId = $ProId;
    }

    public function setLivNum($livNum)
    {
        $this->livNum = $livNum;
    }

    public function setCmdNum($cmdNum)
    {
        $this->cmdNum = $cmdNum;
    }

    public function setDest($dest)
    {
        $this->dest = $dest;
    }

    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getProId()
    {
        return $this->proId;
    }

    public function getLivNum()
    {
        return $this->livNum;
    }

    public function getCmdNum()
    {
        return $this->cmdNum;
    }

    public function getDest()
    {
        return $this->dest;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getTableName()
    {
        return "tbl_livraisonss";
    }


    public function exist_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_livraisons where product_id=?");
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $stat = $stmt->rowCount();
            if ($stat > 0) return true;
            else return false;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_part($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_livraisons join tbl_operations on tbl_livraisons.op_id=tbl_operations.op_id where party_code=? and product_id=0");
            $stmt->bindValue(1, $partyCode);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_pro($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_livraisons where product_id=?");
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select($opId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_livraisons WHERE op_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->opId = $rowObject->op_id;
            @$this->proId = $rowObject->product_id;
            @$this->livNum = $rowObject->liv_num;
            @$this->cmdNum = $rowObject->cmd_num;
            @$this->dest = $rowObject->dest;
            @$this->driver = $rowObject->driver;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_pro($opId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_livraisons WHERE product_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->opId = $rowObject->op_id;
            @$this->proId = $rowObject->product_id;
            @$this->livNum = $rowObject->liv_num;
            @$this->cmdNum = $rowObject->cmd_num;
            @$this->dest = $rowObject->dest;
            @$this->driver = $rowObject->driver;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($opId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_livraisons WHERE op_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $opId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function insert($livNum, $cmdNum, $dest, $driver, $opId)
    {
        $db = getConnection();
        try {
            $sql = "INSERT INTO tbl_livraisons (liv_num,cmd_num,dest,driver,op_id) VALUES(?,?,?,?,?)";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $livNum);
            $stmt->bindValue(2, $cmdNum);
            $stmt->bindValue(3, $dest);
            $stmt->bindValue(4, $driver);
            $stmt->bindValue(5, $opId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update($opId)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_livraisons SET liv_num=? WHERE op_id=?";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $this->livNum);
            $stmt->bindValue(2, $opId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_2($opId, $livNum)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_livraisons SET liv_num=? WHERE op_id=?";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(1, $livNum);
            $stmt->bindValue(2, $opId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function updateCurrent()
    {
        if ($this->opId != "") {
            return $this->update($this->opId);
        } else {
            return false;
        }
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



    public function select_last_num($posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT max(liv_num) as num from tbl_livraisons join tbl_operations on tbl_livraisons.op_id=tbl_operations.op_id where pos_id=:posId");
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['num'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
