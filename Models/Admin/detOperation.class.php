<?php
require_once("connexion.php");

class detOperation
{

    private $detailsId;
    private $opId;
    private $prodId;
    private $Quantity;
    private $amount;
    private $det;
    private $lot;
    private $dateExp;
    private $dateFab;


    public function setDetailsId($detailsId)
    {
        $this->detailsId = (int)$detailsId;
    }


    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }

    public function setDateFab($dateFab)
    {
        $this->dateFab = $dateFab;
    }

    public function setLot($lot)
    {
        $this->lot = $lot;
    }


    public function setDet($det)
    {
        $this->det = $det;
    }

    public function setProdId($prodId)
    {
        $this->prodId = (int)$prodId;
    }

    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getDetailsId()
    {
        return $this->detailsId;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getDateExp()
    {
        return $this->dateExp;
    }

    public function getDateFab()
    {
        return $this->dateFab;
    }

    public function getLot()
    {
        return $this->lot;
    }

    public function getDet()
    {
        return $this->det;
    }


    public function getProdId()
    {
        return $this->prodId;
    }

    public function getQuantity()
    {
        return $this->Quantity;
    }

    public function getAmount()
    {
        return $this->amount;
    }


    public function close()
    {
        //unset($this);
    } 

    public function getDetail($detailsId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_details_operation WHERE details_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$detailsId]);
        $tbP = $stmt->fetchObject();
        return $tbP;
    }
    public function select($detailsId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_details_operation WHERE details_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$detailsId]);
        $tbP = $stmt->fetchObject();
        return $tbP;
    }

    public function insert($opId,$prodId,$Quantity,$amount)
    {
        $db = getConnection();
        $sql =" INSERT INTO tbl_details_operation (op_id,product_id,quantity,amount) VALUES(:opId,:prodId,:Quantity,:amount)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("opId",$opId);
        $stmt->bindParam("prodId",$prodId);
        $stmt->bindParam("Quantity",$Quantity);
        $stmt->bindParam("amount",$amount);
        
        $stmt->execute();
        return $db->lastInsertId();

           
    }

    public function insert_($opId,$prodId,$Quantity,$amount,$red)
    {
        $db = getConnection();
        $sql =" INSERT INTO tbl_details_operation (op_id,product_id,quantity,amount,red) VALUES(:opId,:prodId,:Quantity,:amount,:red)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("opId",$opId);
        $stmt->bindParam("prodId",$prodId);
        $stmt->bindParam("Quantity",$Quantity);
        $stmt->bindParam("amount",$amount);
        $stmt->bindParam("red",$red);
        
        $stmt->execute();
        return $db->lastInsertId();

           
    }

 
    public function select_sum_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount*quantity) as tot FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();

            // $stmt = $db->prepare("SELECT discount as red FROM `tbl_coupons` where op_id=:opId");
            // $stmt->bindParam("opId", $opId);
            // $stmt->execute();
            // $res = $stmt->fetch();
            $sol = $stat['tot'] ;
            return $sol;
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function select_sum_op_0($opId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT sum(amount*quantity*(100-det)/100) as tot FROM tbl_details_operation where op_id=:id");
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $stat = $stmt->fetchObject();
        return $stat->tot;
    }

    public function select_sum_op_2($opId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT sum(amount*quantity) as tot FROM tbl_details_operation where op_id=:id");
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $stat = $stmt->fetchObject();
        return $stat->tot;
    }


    public function select_sum_op_1($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount*quantity*(det)/100) as tot FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_init($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount*quantity) as tot FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_ass($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum((amount*(det/100))*quantity) as tot FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_op($opId, $prodId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_details_operation WHERE op_id=:opId and prod_id=:prodId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("opId", $opId);
        $stmt->bindParam("prodId", $prodId);
        //$stmt->bindParam("stk",$stk);
        $stmt->execute();

        $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
        @$this->detailsId = $rowObject->details_id;
        @$this->opId = $rowObject->op_id;
        @$this->prodId = $rowObject->prod_id;
        @$this->Quantity = $rowObject->quantity;
        @$this->amount = $rowObject->amount;
        @$this->det = $rowObject->det;
        @$this->lot = $rowObject->lot;
        @$this->dateExp = $rowObject->date_exp;

        return $stmt->rowCount();
    }

    public function select_op_($opId, $prodId, $det)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_details_operation WHERE op_id=:opId and prod_id=:prodId and det=:det";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("opId", $opId);
        $stmt->bindParam("prodId", $prodId);
        $stmt->bindParam("det", $det);
        $stmt->execute();

        $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
        @$this->detailsId = $rowObject->details_id;
        @$this->opId = $rowObject->op_id;
        @$this->prodId = $rowObject->prod_id;
        @$this->Quantity = $rowObject->quantity;
        @$this->amount = $rowObject->amount;
        @$this->det = $rowObject->det;

        return $stmt->rowCount();
    }

    public function select_one_det_op($opId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_details_operation WHERE op_id=:opId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_cmd($opId)
    {
        $db =  getConnection();
        try {
            $stmt = $db->prepare("SELECT distinct det FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_2($det)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where det=:id");
            $stmt->bindParam("id", $det);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_3($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT amount, sum(quantity) as quantity,prod_id,lot FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_4($opId, $lot)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT amount, sum(quantity) as quantity,prod_id,det FROM tbl_details_operation where op_id=:id and lot=:lot group by prod_id");
            $stmt->bindParam("id", $opId);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_5($opId, $det)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT amount, sum(quantity) as quantity,prod_id FROM details_operation where op_id=:id and det=:det group by prod_id");
            $stmt->bindParam("id", $opId);
            $stmt->bindParam("det", $det);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_6($opId, $det)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation join tbl_products on tbl_details_operation.product_id=tbl_products.product_id where op_id=:id and det=:det order by product_name");
            $stmt->bindParam("id", $opId);
            $stmt->bindParam("det", $det);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_last_id($opType, $prodId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT max(details_id) as last_id FROM tbl_operations join tbl_details_operation on tbl_operations.op_id=tbl_details_operation.op_id 
            where tbl_operations.op_type=:opType and tbl_details_operation.product_id=:prodId");
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("opType", $opType);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_type($opType, $idPer, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations join tbl_details_operation on tbl_operations.op_id=tbl_details_operation.op_id
             where tbl_operations.op_type=:opType and id_per=:idPer and pos_id=:posId");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("idPer", $idPer);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_type_glob($opType, $idPer)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT product_id,amount,sum(quantity) as tot FROM tbl_operations join tbl_details_operation on tbl_operations.op_id=tbl_details_operation.op_id 
            where tbl_operations.op_type=:opType and id_per=:idPer  group by product_id");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("idPer", $idPer);
            //$stmt->bindParam("posId",$posId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_qt_lot($opType, $lot, $prodId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type=:opType and details_operation.lot=:lot and  details_operation.prod_id=:prodId  group by prod_id");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("lot", $lot);
            $stmt->bindParam("prodId", $prodId);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function select_qt_lot($lot, $prodId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_in FROM operation join details_operation on operation.op_id=details_operation.op_id where party_type='stock_in' and prod_id=:prodId and lot=:lot");
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_out FROM operation join details_operation on operation.op_id=details_operation.op_id where party_type='stock_out' and prod_id=:prodId and lot=:lot");
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();
            $out = $stmt->fetch();

            $solde = $in['tot_in'] - $out['tot_out'];

            return $solde;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_sum_amount($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount*quantity) as tot_achat FROM details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
 
    public function nb_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function nb_op_2($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where op_id=:id and det='0'");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($detailsId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_details_operation WHERE details_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $detailsId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete_op($opId, $prodId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM details_operation WHERE op_id=:opId and product_id=:prodId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("prodId", $prodId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    
    public function getDetailProd_op($opId, $prodId)
    {
        $db = getConnection();
        try {
            $sql = "SELECT * FROM tbl_details_operation WHERE op_id=? and product_id=?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$opId, $prodId]);
            $stat = $stmt->fetch(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function setDetailOperation($op_id, $prod_id, $quantity, $amount)
    {
        $db = getConnection();
        $sql = "INSERT INTO tbl_details_operation (op_id,product_id,quantity,amount) VALUES(?,?,?,?)";

        $stmt = $db->prepare($sql);
        $stmt->execute([$op_id, $prod_id, $quantity, $amount]);
        return $db->lastInsertId();
    }

    public function getDetailOperation($opId)
    {
        $db =  getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_details_operation where op_id=:id");
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $stat;
    }


    public function update($detailsId)
    {

        $db = getConnection();
        try {
            $sql = " UPDATE tbl_details_operation SET product_id=:prodId, quantity=:Quantity, amount=:amount WHERE details_id=:detailsId";

            $stmt = $db->prepare($sql);

            $stmt->bindParam("prodId", $this->prodId);
            $stmt->bindParam("Quantity", $this->Quantity);
            $stmt->bindParam("amount", $this->amount);
            $stmt->bindParam("detailsId", $detailsId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_sup($detailsId)
    {

        $db = getConnection();
        try {
            $sql = "  UPDATE  tbl_details_operation
            SET lot=:lot, date_exp=:dateExp, date_fab=:dateFab
            WHERE details_id=:detailsId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("lot", $this->lot);
            $stmt->bindParam("dateExp", $this->dateExp);
            $stmt->bindParam("dateFab", $this->dateFab);
            $stmt->bindParam("detailsId", $detailsId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_red($detailsId,$red)
    {

        $db = getConnection();
        try {
            $sql = "UPDATE  tbl_details_operation SET red=:red WHERE details_id=:detailsId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("red", $red);
            $stmt->bindParam("detailsId", $detailsId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function update_op($prodId, $opId)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_details_operation
                SET
                quantity=:Quantity,
                amount=:amount

            WHERE
            op_id=:opId and prod_id=:prodId";


            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("prodId", $prodId);
            //$stmt->bindParam("stk",$stk);
            $stmt->bindParam("Quantity", $this->Quantity);
            $stmt->bindParam("amount", $this->amount);


            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_opb($detId)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                details_operation
                SET
                quantity=:Quantity

            WHERE
            details_id=:detId";


            $stmt = $db->prepare($sql);
            $stmt->bindParam("detId", $detId);
            //$stmt->bindParam("prodId",$prodId);
            //$stmt->bindParam("stk",$stk);
            $stmt->bindParam("Quantity", $this->Quantity);
            //$stmt->bindParam("amount",$this->amount);


            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update_op_($prodId, $opId, $det)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_details_operation
                SET
                quantity=:Quantity,
                amount=:amount

            WHERE
            op_id=:opId and prod_id=:prodId and det=:det";


            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("det", $det);
            $stmt->bindParam("Quantity", $this->Quantity);
            $stmt->bindParam("amount", $this->amount);


            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_one($Id, $val_id, $val_n, $val_f)
    {


        $db = getConnection();
        try {
            $sql = " UPDATE tbl_details_operation SET " . $val_n . " =:val_f
            WHERE  " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function existop($opId)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from tbl_details_operationwhere op_id=:opId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            //$stmt->bindParam("prodId",$prodId);
            //$stmt->bindParam("stk",$stk);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function existop_2($opId, $prodId)
    {
        $db = getConnection();
        try {
            $sql = "SELECT * from tbl_details_operation where op_id=:opId and prod_id=:prodId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("prodId", $prodId);
            $stmt->execute();
            $res = $stmt->rowCount();
            /*if($res>=1) return true; else return false;*/
            return $res;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function existop_2_($opId, $prodId, $cmd)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from tbl_details_operation where op_id=:opId and prod_id=:prodId and det=:cmd";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("cmd", $cmd);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function exist_vente_enc($opType, $state)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from operation  where op_type=:opType and state=:state";
            $stmt = $db->prepare($sql);
            //$stmt->bindParam("opId",$opId);
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("state", $state);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function exist_sort_ing($opType, $opId, $state)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from operation join (details_operation join products on details_operation.prod_id=products.prod_id) on operation.op_id=details_operation.op_id  where op_type=:opType and operation.op_id=:opId and is_ing=:state";
            $stmt = $db->prepare($sql);
            //$stmt->bindParam("opId",$opId);
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("state", $state);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_sup2($lot, $dateExp, $prodId)
    {

        $db = getConnection();
        try {
            $sql = "
            UPDATE
                details_operation
            SET
                lot=:lot,
                date_exp=:dateExp
            WHERE
                lot=:lot2 and date_exp=:dateExp2 and prod_id=:prodId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("lot", $this->lot);
            $stmt->bindParam("dateExp", $this->dateExp);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("lot2", $lot);
            $stmt->bindParam("dateExp2", $dateExp);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function updateCurrent()
    {
        if ($this->detailsId != "") {
            return $this->update($this->detailsId);
        } else {
            return false;
        }
    }

    public function select_sum_unt($opType, $from_d, $to_d, $untMes)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity*amount) as tot_amount FROM tbl_operations join (tbl_details_operation join products on details_operation.prod_id=products.prod_id) on operation.op_id=details_operation.op_id where operation.op_type=:opType and (create_date
    between :from_d and :to_d) and  products.unt_mes=:untMes and is_paid=1  group by unt_mes");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("untMes", $untMes);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['tot_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_sum($opType, $idPer)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT prod_id,date_exp,amount FROM tbl_operations join tbl_details_operation on operation.op_id=details_operation.op_id where operation.op_type=:opType and id_per=:idPer");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_qt_sum($opType, $idPer, $prodId, $lot)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as quantity FROM tbl_operations join tbl_details_operation on operation.op_id=details_operation.op_id where operation.op_type=:opType and id_per=:idPer and prod_id=:prodId and lot=:lot");
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("idPer", $idPer);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['quantity'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_det($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount*quantity) as tot FROM tbl_details_operation where det=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
