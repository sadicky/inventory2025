<?php
require_once("connexion.php");

class Paiement
{

    private $paieId;
    private $caisseId;
    private $opId;
    private $transactionId;
    private $amount;
    private $modePaie;
    private $autref;
    private $canceled;

    public function setPaieId($paieId)
    {
        $this->paieId = (int)$paieId;
    }

    public function setCaisseId($caisseId)
    {
        $this->caisseId = (int)$caisseId;
    }
    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }

    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function setModePaie($modePaie)
    {
        $this->modePaie = $modePaie;
    }

    public function setAutref($autref)
    {
        $this->autref = $autref;
    }

    public function setAmount($amount)
    {
        $this->amount = (int)$amount;
    }

    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;
    }

    public function getPaieId()
    {
        return $this->paieId;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getModePaie()
    {
        return $this->modePaie;
    }

    public function getAutref()
    {
        return $this->autref;
    }

    public function getCanceled()
    {
        return $this->canceled;
    }



    public function select($paieId)
    {

        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_paiements WHERE transaction_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $paieId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->paieId = $rowObject->paie_id;
            @$this->caisseId = $rowObject->caisseId;
            @$this->opId = $rowObject->op_id;
            @$this->transactionId = $rowObject->transaction_id;
            @$this->amount = $rowObject->amount;
            @$this->modePaie = $rowObject->mode_paie;
            @$this->autref = $rowObject->autref;
            @$this->canceled = $rowObject->canceled;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    // select all rows from tables;

    public function select_sum_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_paiements where op_id=:id group by op_id");
            $stmt->bindParam("id", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_part($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_paiements where op_id='0' and autref=:opId group by autref");
            $stmt->bindParam("opId", $opId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_trans($transactionId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_transactions where transaction_id=:id  group by transaction_id");
            $stmt->bindParam("id", $transactionId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_cash($jour)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_paiements join operation on tbl_paiements.op_id=operation.op_id where jour_id=:id and canceled='1' and mode_paie='Cash' group by jour_id");
            $stmt->bindParam("id", $jour);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_partyCode($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(tbl_paiements.amount) as paie FROM tbl_paiements join transactions on tbl_paiements.transaction_id=transactions.transaction_id
  where party_code=:partyCode group by party_code");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_date($opId, $date_p)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(tbl_paiements.amount) as paie FROM transactions join tbl_paiements on transactions.transaction_id=tbl_paiements.transaction_id where tbl_paiements.op_id=:id and tbl_paiements.canceled='1' and create_date<:date_p group by tbl_paiements.op_id");
            $stmt->bindParam("id", $opId);
            $stmt->bindParam("date_p", $date_p);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_by_trans($transactionId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_paiements WHERE transaction_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $transactionId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->paieId = $rowObject->paie_id;
            @$this->opId = $rowObject->op_id;
            @$this->transactionId = $rowObject->transaction_id;
            @$this->amount = $rowObject->amount;
            @$this->modePaie = $rowObject->mode_paie;
            @$this->autref = $rowObject->autref;
            @$this->canceled = $rowObject->canceled;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_by_op($transactionId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_paiements WHERE op_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $transactionId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->paieId = $rowObject->paie_id;
            @$this->opId = $rowObject->op_id;
            @$this->transactionId = $rowObject->transaction_id;
            @$this->amount = $rowObject->amount;
            @$this->modePaie = $rowObject->mode_paie;
            @$this->autref = $rowObject->autref;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_trans($trans_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_paiements where transaction_id=:trans_id");
            $stmt->bindParam('trans_id', $trans_id);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function delete($transId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_paiements WHERE trans_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $transId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function insert()
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO `tbl_paiements`(`op_id`, `transaction_id`, `amount`, `mode_paie`, `autref`,`caisse_id`)
            VALUES(:opId,:transactionId,:amount,:mode_paie,:autref,:caisseId)";

            $stmt = $db->prepare($sql);

            $stmt->bindParam("opId", $this->opId);
            $stmt->bindParam("transactionId", $this->transactionId);
            $stmt->bindParam("caisseId", $this->caisseId);
            $stmt->bindParam("amount", $this->amount);
            $stmt->bindParam("mode_paie", $this->modePaie);
            $stmt->bindParam("autref", $this->autref);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update($transId)
    {
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_paiements
            SET
				amount=:amount
            WHERE
                transaction_id=:transId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("amount", $this->amount);
            $stmt->bindParam("transId", $transId);
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
                tbl_paiements
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

    public function updateCurrent()
    {
        if ($this->paieId != "") {
            return $this->update($this->paieId);
        } else {
            return false;
        }
    }
}
