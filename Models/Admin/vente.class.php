<?php
require_once("connexion.php");

class Vente
{

    private $idvente;
    private $amount;
    private $opId;
    private $assId;
    private $isPaid;
    private $numVente;
    private $state;
    private $tva;
    private $type;
    private $sendState;
    private $signature;
    private $ben;

    public function setIdvente($idvente)
    {
        $this->idvente = (int)$idvente;
    }
    public function setNumVente($numvente)
    {
        $this->numVente = $numvente;
    }

    public function setAmount($amount)
    {
        $this->amount = (int)$amount;
    }

    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    public function setAssId($assId)
    {
        $this->assId = (int)$assId;
    }

    public function setIsPaid($isPaid)
    {
        $this->isPaid = (string)$isPaid;
    }

    public function setSendState($state)
    {
        $this->state = $state;
    }

    public function setTva($tva)
    {
        $this->tva = $tva;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getIdvente()
    {
        return $this->idvente;
    }

    public function getNumVente()
    {
        return $this->numVente;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getAssId()
    {
        return $this->assId;
    }

    public function getBen()
    {
        return $this->ben;
    }

    public function getIsPaid()
    {
        return $this->isPaid;
    }

    public function getTva()
    {
        return $this->tva;
    }

    public function getSendState()
    {
        return $this->sendState;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function getTableName()
    {
        return "tbl_ventes";
    }


    public function select($idvente)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $idvente);
            $stmt->execute();
            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_0($idvente)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $idvente);
            $stmt->execute();
            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_by_table_av($place)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  WHERE place=:id and is_send='0'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $place);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idvente = $rowObject->idvente;
            @$this->amount = $rowObject->amount;
            @$this->opId = $rowObject->op_id;
            @$this->assId = $rowObject->ass_id;
            @$this->numVente = $rowObject->num_vente;
            @$this->tva = $rowObject->tva;
            @$this->isPaid = $rowObject->is_paid;
            @$this->type = $rowObject->type;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_dette($opType, $client)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_operations as o, tbl_transactions as t where t.op_id=o.op_id  
            and o.op_type=:op_type and o.party_code=:id and o.state=1 and o.is_paid='0'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $client);
            $stmt->bindParam("op_type", $opType);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_dette_0($opType, $client)
    {
        $db = getConnection();
        try {
            $sql = "SELECT * FROM tbl_operations as o, tbl_transactions as t where t.op_id=o.op_id  
            and o.op_type=:op_type and o.party_code=:id and o.state=1 and o.is_paid='0' and ";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $client);
            $stmt->bindParam("op_type", $opType);
            $stmt->execute();

            $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_by_table_ass($assId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  WHERE ass_id=:id and is_send='0'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $assId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_vente_encours($assId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  WHERE pos_id=:id and send_state='0'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $assId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_by_table_ass2($assId, $personneId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  WHERE ass_id=:id and is_send='0' and personne_id=:personneId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $assId);
            $stmt->bindParam("personneId", $personneId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_plus_vendus_branche($idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT p.product_id, p.details, c.category_name,sum(d.quantity) as total_vendu
             FROM tbl_details_operation d  join tbl_operations o on o.op_id=d.op_id join tbl_products p on d.product_id=p.product_id
             join tbl_category c on c.category_id=p.category_id where o.pos_id=:idBq  and (date(d.updated_at)
                between :from_d and :to_d) and o.op_type='Vente' and o.is_paid =1 group by p.product_id, p.product_name, c.category_name  order by total_vendu desc");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_id($idvente)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes WHERE idvente=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $idvente);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idvente = $rowObject->idvente;
            @$this->amount = $rowObject->amount;
            @$this->opId = $rowObject->op_id;
            @$this->assId = $rowObject->ass_id;
            @$this->numVente = $rowObject->num_vente;
            @$this->tva = $rowObject->tva;
            @$this->isPaid = $rowObject->is_paid;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_tab($tab)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id WHERE is_send='0' and place=:tab";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("tab", $tab);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idvente = $rowObject->idvente;
            @$this->amount = $rowObject->amount;
            @$this->opId = $rowObject->op_id;
            @$this->assId = $rowObject->ass_id;
            @$this->numVente = $rowObject->num_vente;
            @$this->tva = $rowObject->tva;
            @$this->isPaid = $rowObject->is_paid;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    // select all rows from tables;

    public function select_all($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_ventes where op_id=:id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_last_num($posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT max(num_vente) as num from tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id WHERE pos_id=:posId");
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['num'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }




    public function delete($opId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_ventes WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $opId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function setVente($amount, $opId, $assId, $numVente, $isPaid, $caisse)
    {
        $db = getConnection();
        try {
            $sql = " INSERT INTO tbl_ventes (amount,op_id,ass_id,num_vente,is_paid,caisse_id)  VALUES(?,?,?,?,?,?)";

            $stmt = $db->prepare($sql);
            $ok = $stmt->execute([$amount, $opId, $assId, $numVente, $isPaid, $caisse]);
            return $ok;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update($opId, $amount)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_ventes SET amount=:amount WHERE op_id=:opId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("amount", $amount);
            $stmt->bindParam("opId", $opId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function updateBq($opId, $caisse)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_ventes
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



    public function nb_table($assId)
    {

        $db = getConnection();
        try {
            $sql = "SELECT * from tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  where ass_id=:assId and is_send='0'";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("assId", $assId);
            $stmt->execute();
            $res = $stmt->rowCount();
            return $res;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function update_one($Id, $val_id, $val_n, $val_f)
    {
        $db = getConnection();
        $sql = " UPDATE tbl_ventes SET " . $val_n . " =:val_f WHERE  " . $val_id . "=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("val_f", $val_f);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }

    public function update_valider($Id, $m_paye, $is_paid, $send_state)
    {
        $db = getConnection();
        $sql = " UPDATE tbl_ventes SET m_paye=:m_paye, is_paid =:is_paid, send_state=:send_state WHERE idvente=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("is_paid", $is_paid);
        $stmt->bindParam("m_paye", $m_paye);
        $stmt->bindParam("send_state", $send_state);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }

    public function update_pay($Id, $m_paye, $is_paid)
    {
        $db = getConnection();
        $sql = " UPDATE tbl_ventes SET m_paye=:m_paye, is_paid =:is_paid WHERE idvente=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("is_paid", $is_paid);
        $stmt->bindParam("m_paye", $m_paye);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }
    public function get_op_table($table)
    {

        $db = getConnection();
        try {
            $sql = "SELECT tbl_operations.op_id as crt_op_id from tbl_ventes join tbl_operations on tbl_ventes.op_id=tbl_operations.op_id  where is_send='0'
and place=:table";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("table", $table);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['crt_op_id'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_srch_bill($keyword)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_ventes where idvente like '%" . $keyword . "%'");
            $stmt->execute();
            $stat = $stmt->fetchAll();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_commission_agent($agent, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT party_code,create_date,amount,party_aux FROM tbl_transactions 
            where transaction_type='Vente' and status='IN' and etat=1 AND party_aux=:agent 
            and (date(create_date) between :from_d and :to_d)");
            $stmt->bindParam("agent", $agent);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $out = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $out;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function insert()
    {
        $db = getConnection();
        $sql = " INSERT INTO tbl_ventes (amount,op_id,num_vente,is_paid,send_state) VALUES(:amount,:opId,:numVente, :isPaid, :send_state)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("amount", $this->amount);
        $stmt->bindParam("opId", $this->opId);
        $stmt->bindParam("send_state", $this->state);
        $stmt->bindParam("numVente", $this->numVente);
        $stmt->bindParam("isPaid", $this->isPaid);
        return (bool)$stmt->execute();
    }
}
