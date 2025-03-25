<?php
require_once("connexion.php");

class Sortie
{

    private $idsort;
    private $amount;
    private $opId;
    private $isPaid;
    private $numSort;
    private $motif;
    private $typeSort;

    public function setIdsort($idsort)
    {
        $this->idsort = (int)$idsort;
    }
    public function setTypeSort($typeSort)
    {
        $this->typeSort = $typeSort;
    }
    public function setNumSort($numsort)
    {
        $this->numSort = $numsort;
    }

    public function setAmount($amount)
    {
        $this->amount = (int)$amount;
    }

    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    public function setMotif($motif)
    {
        $this->motif = $motif;
    }

    public function getIdsort()
    {
        return $this->idsort;
    }

    public function getTypeSort()
    {
        return $this->typeSort;
    }

    public function getNumSort()
    {
        return $this->numSort;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getIsPaid()
    {
        return $this->isPaid;
    }

    public function getMotif()
    {
        return $this->motif;
    }

    public function getTableName()
    {
        return "tbl_sorties";
    }



    public function select($idsort)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_sorties WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $idsort);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idsort = $rowObject->idsort;
            @$this->amount = $rowObject->amount;
            @$this->opId = $rowObject->op_id;
            @$this->numSort = $rowObject->num_sort;
            @$this->isPaid = $rowObject->is_paid;
            @$this->motif = $rowObject->motif;
            @$this->typeSort = $rowObject->type_sort;
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    // select all rows from tables;

    public function select_all($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_sorties where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_last_num()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT max(idsort) as last_num FROM tbl_sorties");
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function delete($idsort)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_sorties WHERE idsort=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $idsort);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function insert($amount, $opId, $numSort, $motif, $typeSort)
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO tbl_sorties
            (amount,op_id,num_sort,motif,type_sort)
            VALUES(:amount,:opId,:numSort,:motif, :typeSort)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("amount", $amount);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("numSort", $numSort);
            $stmt->bindParam("motif", $motif);
            $stmt->bindParam("typeSort", $typeSort);
            return $stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_product_endom($prodId, $supId, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_endom WHERE product_id=:prodId and supplier_id=:sup and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("sup", $supId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_qt_endom($stockId, $qt)
    {

        $db = getConnection();
        try {
            $sql = "UPDATE tbl_endom SET qty=:qt WHERE endom_id=:stockId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("qt", $qt);
            $stmt->bindParam("stockId", $stockId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function setEndom($prodId, $quantity, $sup_id, $posId)
    {
        $db = getConnection();
        try {
            $sql = "INSERT INTO tbl_endom (product_id,qty,supplier_id,pos_id) VALUES(:prodId,:quantity,:supId,:posId)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("quantity", $quantity);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("supId", $sup_id);

            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update($opId, $amount)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_sorties
            SET
				amount=:amount,
                motif=:motif,
                type_sort=:typeSort
            WHERE
                op_id=:opId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("amount", $amount);
            $stmt->bindParam("motif", $this->motif);
            $stmt->bindParam("typeSort", $this->typeSort);
            $stmt->bindParam("opId", $opId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_2($opId, $amount)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_sorties
            SET
                amount=:amount
            WHERE
                op_id=:opId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("amount", $amount);
            $stmt->bindParam("opId", $opId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
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
}
