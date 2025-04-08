<?php
require_once("connexion.php");

class Operation
{

    private $opType;
    private $partyType;
    private $createDate;
    private $state;
    private $partyCode;
    private $isSend;
    private $personneId;
    private $jourId;
    private $posId;
    private $idPer;
    private $payType;
    private $docType;
    private $tarId;
    private $affId;
    private $benId;
    private $opId;
    private $isPaid;



    public function setOpType($opType)
    {
        $this->opType = (string)$opType;
    }

    public function setPartyType($partyType)
    {
        $this->partyType = (string)$partyType;
    }

    public function setPayType($payType)
    {
        $this->payType = $payType;
    }

    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    public function setState($state)
    {
        $this->state = (string)$state;
    }

    public function setIdPer($idPer)
    {
        $this->idPer = $idPer;
    }

    public function setPartyCode($partyCode)
    {
        $this->partyCode = (string)$partyCode;
    }

    public function setIsPaid($isPaid)
    {
        $this->isPaid = $isPaid;
    }

    public function setIsSend($isSend)
    {
        $this->isSend = $isSend;
    }


    public function setPersonneId($personneId)
    {
        $this->personneId = (int)$personneId;
    }

    public function setPosId($posId)
    {
        $this->posId = (int)$posId;
    }
    public function setJourId($jourId)
    {
        $this->jourId = $jourId;
    }

    public function getOpType()
    {
        return $this->opType;
    }

    public function getPartyType()
    {
        return $this->opType;
    }

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getIdPer()
    {
        return $this->idPer;
    }

    public function getPayType()
    {
        return $this->payType;
    }

    public function getDocType()
    {
        return $this->docType;
    }

    public function getPartyCode()
    {
        return $this->partyCode;
    }

    public function getIsPaid()
    {
        return $this->isPaid;
    }

    public function getIsSend()
    {
        return $this->isSend;
    }

    public function getTarId()
    {
        return $this->tarId;
    }

    public function getAffId()
    {
        return $this->affId;
    }

    public function getBenId()
    {
        return $this->benId;
    }


    public function getPersonneId()
    {
        return $this->personneId;
    }

    public function getPosId()
    {
        return $this->posId;
    }

    public function getJourId()
    {
        return $this->jourId;
    }

    public function setOperation($user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $personne_id, $party_type, $pos_id, $caisse)
    {
        $db = getConnection();
        $sql = "INSERT INTO tbl_operations (user_id,op_type,jour_id,party_code,state,is_paid,id_per,party_type,pos_id,caisse_id)
            VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $personne_id, $party_type, $pos_id, $caisse]);
        return $db->lastInsertId();
    }
    public function setOperation_($date, $user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $personne_id, $party_type, $pos_id, $caisse)
    {
        $db = getConnection();
        $sql = "INSERT INTO tbl_operations (create_date,user_id,op_type,jour_id,party_code,state,is_paid,id_per,party_type,pos_id,caisse_id)
            VALUES(?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$date, $user_id, $op_type, $jour_id, $party_code, $state, $is_paid, $personne_id, $party_type, $pos_id, $caisse]);
        return $db->lastInsertId();
    }


    //
    public function select_all_by_period_tiers($opType, $is_paid, $user, $from_d, $to_d)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and is_paid =:is_paid  and party_code=:partyCode and (date(create_date) between :from_d and :to_d)");
        $stmt->bindParam("op_type", $opType);
        $stmt->bindParam("from_d", $from_d);
        $stmt->bindParam("to_d", $to_d);
        $stmt->bindParam("is_paid", $is_paid);
        $stmt->bindParam("partyCode", $user);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }
    public function select_all_dette($opType, $user)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and is_paid =0
        and party_code=:partyCode");
        $stmt->bindParam("op_type", $opType);
        $stmt->bindParam("partyCode", $user);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }

    public function select_all_by_period_tiers1($opType, $user, $from_d, $to_d)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type  and party_code=:partyCode and (date(create_date) between :from_d and :to_d)");
        $stmt->bindParam("op_type", $opType);
        $stmt->bindParam("from_d", $from_d);
        $stmt->bindParam("to_d", $to_d);
        $stmt->bindParam("partyCode", $partyCode);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }


    public function getOperationTypes($opType, $state)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_operations where op_type=? and state=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$opType, $state]);
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }

    public function getOperationType($opType)
    {
        $db = getConnection();
        $sql =  "SELECT max(op_id) as last_id FROM tbl_operations where op_type=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$opType]);
        $res = $stmt->fetchObject();
        return $res;
    }

    public function getOperationId($opId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_operations WHERE op_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $rowObject = $stmt->fetchObject();
        return $rowObject;
    }

    public function getOperationPartyCode($opId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_operations WHERE party_code=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $rowObject = $stmt->fetchObject();
        return $rowObject;
    }


    public function getOperation($opId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_operations WHERE state=0";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $rowObject = $stmt->fetchObject();
        return $rowObject;
    }

    public function select_all_facture_no_1($opId, $opType)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and op_type!='Vente' and op_id=:opId and state=0 and ben_id=0");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("opId", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_facture_no_2($opId, $opType, $caisse)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and op_type='Vente' and op_id=:opId and caisse_id=:caisse order by create_date");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("opId", $opId);
            $stmt->bindParam("caisse", $caisse);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_op_paid_type($opType, $partyCode, $isPaid)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_operations where op_type=:opType and party_code=:partyCode and is_paid=:isPaid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("opType", $opType);
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("isPaid", $isPaid);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_facture_no_0($pos_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where state=0 and caisse_id=? and ben_id=0 order by create_date DESC");
            $stmt->execute([$pos_id]);
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_facture_no_0_()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type='Vente' order by h_op DESC");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_no_send_0($opType, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations  where op_type=:op_type  and pos_id=:posId and is_paid=0");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function exist_in_vente($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_ventes where op_id=:opId");
            $stmt->bindParam("opId", $opId);
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

    public function delete($opId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_operations WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $opId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function select_sum_op($opId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT sum(amount*quantity) as tot FROM tbl_details_operation where op_id=:id");
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        $stat = $stmt->fetch();

        $stmt = $db->prepare("SELECT discount as red FROM `tbl_coupons` where op_id=:opId");
        $stmt->bindParam("opId", $opId);
        $stmt->execute();
        $res = $stmt->fetch();
        return $stat['tot'] - $res['red'];
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

    public function nb_op($opId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_details_operation where op_id=:id");
        $stmt->bindParam("id", $opId);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function update_one($Id, $val_id, $val_n, $val_f)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_operations SET " . $val_n . " =:val_f WHERE " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function update_state($Id, $benId, $state)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_operations SET state =:state,ben_id=:ben_id WHERE op_id =:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("state", $state);
            $stmt->bindParam("id", $Id);
            $stmt->bindParam("ben_id", $benId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_is_paid($Id, $state, $date)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_operations SET is_paid=:is_paid,create_date=:create_date WHERE op_id =:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("is_paid", $state);
            $stmt->bindParam("create_date", $date);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function exist_in_trans($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where op_id=:opId");
            $stmt->bindParam("opId", $opId);
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
    public function select_one_per($idPer, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_operations WHERE op_type='Inventaire' and id_per=:idPer  and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("idPer", $idPer);
            $stmt->bindParam("posId", $posId);
            $res = $stmt->execute();
            return $res;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_last($typ, $idPer, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT max(op_id) as last_id FROM tbl_operations where op_type=:typ and id_per=:idPer and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("idPer", $idPer);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("typ", $typ);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['last_id'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_date_rap_an($partyType, $prod, $from_d, $pos, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as totqt FROM tbl_operations, tbl_details_operation 
            WHERE tbl_operations.op_id=tbl_details_operation.op_id AND party_type=:party_type and id_per=:per and product_id=:prod and create_date < :from_d  and pos_id=:pos");
            $stmt->bindParam("prod", $prod);
            $stmt->bindParam("party_type", $partyType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("per", $per);
            $stmt->bindParam("pos", $pos);
            $stmt->execute();
            $stat = $stmt->fetchObject();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_prod_pos($partyType, $prod, $pos, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as totqt FROM tbl_operations, tbl_details_operation 
            WHERE tbl_operations.op_id=tbl_details_operation.op_id and id_per=:per AND party_type=:party_type and product_id=:prod and pos_id=:pos");
            $stmt->bindParam("prod", $prod);
            $stmt->bindParam("party_type", $partyType);
            $stmt->bindParam("per", $per);
            $stmt->bindParam("pos", $pos);
            $stmt->execute();
            $stat = $stmt->fetchObject();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_between_date_rap($prod, $from_d, $to_d, $pos, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT o.*, d.product_id, quantity as totqt FROM tbl_operations as o,tbl_details_operation as d where o.op_id=d.op_id and product_id=:prod and id_per=:per and (pos_id=:pos or party_code=:pos) and (date(create_date) between :from_d and :to_d)");
            $stmt->bindParam("prod", $prod);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("pos", $pos);
            $stmt->bindParam("per", $per);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_by_date_rap($prod, $from_d, $pos, $per)
    {

        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_operations.*, tbl_products.*,tbl_details_operation.* FROM tbl_operations join (tbl_details_operation join tbl_products on tbl_details_operation.product_id=tbl_products.product_id) on tbl_operations.op_id=tbl_details_operation.op_id where tbl_details_operation.product_id=:prod and id_per=:per and date(create_date)=:from_d and pos_id=:pos");
            $stmt->bindParam("prod", $prod);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("pos", $pos);
            $stmt->bindParam("per", $per);

            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_date_rap_an_2($opType, $prod, $from_d, $pos, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_operations.*, tbl_products.product_id, quantity*qt as totqt FROM tbl_operations join (details_operation join (products join composition on composition.prod_id=products.prod_id) on details_operation.prod_id=products.prod_id) on operation.op_id=details_operation.op_id where op_type=:op_type and id_per=:per and composition.ingred=:prod and create_date<:from_d  and pos_id=:pos GROUP BY prod_id");
            $stmt->bindParam("prod", $prod);
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("per", $per);
            $stmt->bindParam("pos", $pos);

            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function select_all_by_period_pos($opType, $from_d, $to_d, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and (date(create_date)
            between :from_d and :to_d and pos_id=:posId) order by create_date,op_id");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_period_vente($opType, $from_d, $to_d, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and state=1 and is_paid=1 and (date(create_date)
            between :from_d and :to_d and pos_id=:posId) order by create_date,op_id");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_by_period_dette($opType, $from_d, $to_d, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and state=1 and is_paid=0 and (date(create_date)
            between :from_d and :to_d and pos_id=:posId) order by create_date,op_id");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_by_period($opType, $from_d, $to_d, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and (date(create_date)
            between :from_d and :to_d) and pos_id=:posId");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_by_period_pay_type($opType, $from_d, $to_d, $posId, $id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and (date(create_date)
            between :from_d and :to_d and pos_id=:posId and pay_type=:id) order by create_date,op_id");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_facture_no($opType, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and pos_id=:posId and ben_id=0 order by create_date,op_id DESC");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_facture_vente($opType, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and pos_id=:posId and state=1 order by create_date,op_id DESC");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_facture($opType, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and pos_id=:posId order by create_date,op_id");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_period_pos_user($opType, $from_d, $to_d, $user, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type and (date(create_date)
             between :from_d and :to_d and pos_id=:posId and user_id=:user)");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("user", $user);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_by_state3($opType, $isPaid)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where op_type=:op_type  and is_paid=:isPaid");
            $stmt->bindParam("op_type", $opType);
            $stmt->bindParam('isPaid', $isPaid);

            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
