<?php
include_once("connexion.php");

class Coupon
{

    private $couponId;
    private $opId;
    private $discount;
    private $isPaid;

    public function setCouponId($couponId)
    {
        $this->couponId = (int)$couponId;
    }
    public function setDiscount($discount)
    {
        $this->discount = (int)$discount;
    }
    public function setOpId($opId)
    {
        $this->opId = (string)$opId;
    }


    public function getCouponId()
    {
        return $this->couponId;
    }

    public function getIsPaid()
    {
        return $this->isPaid;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function getTableName()
    {
        return "tbl_coupons";
    }


    public function nb_op($cmd)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where det=:id");
            $stmt->bindParam("id", $cmd);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select($opId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM `tbl_coupons` WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $opId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->couponId = $rowObject->coupon_id;
            @$this->opId = $rowObject->op_id;
            @$this->isPaid = $rowObject->is_paid;
            @$this->discount = $rowObject->discount;

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_exist_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_coupons where op_id=:opId");
            $stmt->bindParam("opId", $opId);
            $stmt->execute();
            $stat = $stmt->rowCount();
            if ($stat >= 1)
                return true;
            else
                return false;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    // select all rows from coupons;
    public function select_all()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM `tbl_coupons` order by op_id");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function getRed($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT discount as red FROM `tbl_coupons` where op_id=:opId");
            $stmt->bindParam("opId", $opId);
            $stmt->execute();
            $stat = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($couponId)
    {

        $db = getConnection();
        try {
            $sql = "DELETE FROM `tbl_coupons` WHERE coupon_id=:id";
            $$stmt = $db->prepare($sql);
            $stmt->bindParam("id", $couponId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function insert()
    {
        $db = getConnection();
        try {
            $sql = " INSERT INTO `tbl_coupons` (op_id,discount) VALUES(:opId,:discount)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $this->opId);
            $stmt->bindParam("discount", $this->discount);
            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($opId)
    {
        $db = getConnection();
        try {
            $sql = "  UPDATE `tbl_coupons` SET discount=:discount WHERE op_id=:opId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("discount", $this->discount);
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
            $sql = " UPDATE tbl_coupons SET
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
