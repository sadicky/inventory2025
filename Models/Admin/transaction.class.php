<?php
include_once("connexion.php");

class Transactions
{

    private $transactionId;
    private $jourId;
    private $caisse_id;
    private $transactionType;
    private $createDate;
    private $amount;
    private $opId;
    private $partyCode;
    private $status;
    private $posId;
    private $modePaie;
    private $descript;
    private $canceled;
    private $partyAux;


    public function setTransactionId($transactionId)
    {
        $this->transactionId = (int)$transactionId;
    }


    public function setJourId($jourId)
    {
        $this->jourId = $jourId;
    }

    public function setOpId($opId)
    {
        $this->opId = (int)$opId;
    }


    public function setTransactionType($transactionType)
    {
        $this->transactionType = (string)$transactionType;
    }

    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }


    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setPartyCode($partyCode)
    {
        $this->partyCode = (string)$partyCode;
    }


    public function setStatus($status)
    {
        $this->status = (string)$status;
    }

    public function setPosId($posId)
    {
        $this->posId = (int)$posId;
    }
    public function setCaisseId($caisse_id)
    {
        $this->caisse_id = (int)$caisse_id;
    }

    public function setDescript($descript)
    {
        $this->descript = $descript;
    }

    public function setModePaie($modePaie)
    {
        $this->modePaie = $modePaie;
    }

    public function setCanceled($canceled)
    {
        $this->canceled = $canceled;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getJourId()
    {
        return $this->jourId;
    }

    public function getOpId()
    {
        return $this->opId;
    }

    public function getModePaie()
    {
        return $this->modePaie;
    }

    public function getTransactionType()
    {
        return $this->transactionType;
    }


    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function getCaisseId()
    {
        return $this->caisse_id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getPartyCode()
    {
        return $this->partyCode;
    }

    public function getPartyAux()
    {
        return $this->partyAux;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function getPosId()
    {
        return $this->posId;
    }

    public function getDescript()
    {
        return $this->descript;
    }

    public function getCanceled()
    {
        return $this->canceled;
    }

    /**
     * Explicit destructor. It calls the implicit destructor automatically.
     */
    public function close()
    {
        //unset($this);
    }


    public function select($transactionId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_transactions WHERE transaction_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $transactionId);
        $stmt->execute();

        $rowObject = $stmt->fetchObject();

        return $rowObject;
    }
    public function select_0($transactionId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_avance_dettes WHERE ad_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $transactionId);
        $stmt->execute();

        $rowObject = $stmt->fetchObject();

        return $rowObject;
    }
    public function getAvanceDettes()
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_avance_dettes as ad,tbl_branches as b,tbl_customers as c,tbl_personnes as p 
        WHERE ad.branche_id = b.branche_id and ad.customer_id = c.customer_id and ad.personne_id = p.personne_id ";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rowObject;
    }
    public function getDettesCustommer($id)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_credits as ad,tbl_branches as b,tbl_customers as c,tbl_staff as p
        WHERE ad.branche_id = b.branche_id and ad.customer_id = c.personne_id and ad.staff_id = p.staff_id
          and ad.is_paid='0' and  ad.customer_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rowObject;
    }

    public function getDetteId($id)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_credits as ad,tbl_branches as b,tbl_customers as c,tbl_staff as p 
        WHERE ad.branche_id = b.branche_id and ad.customer_id = c.personne_id and ad.staff_id = p.staff_id
        and credits_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);

        $rowObject = $stmt->fetchObject();

        return $rowObject;
    }
    public function getAvanceDetteBranche($branche_id)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_avance_dettes as ad,tbl_branches as b,tbl_customers as c,tbl_personnes as p 
        WHERE ad.branche_id = b.branche_id and ad.customer_id = c.customer_id and ad.personne_id = p.personne_id and ad.branche_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $branche_id);
        $stmt->execute();

        $rowObject = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $rowObject;
    }
    public function select_sum_trans($transactionId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as dette FROM tbl_transactions where transaction_id=:id and transaction_type='Vente' and etat='1' and mode_paie='DETTE' group by transaction_id");
            $stmt->bindParam("id", $transactionId);
            $stmt->execute();
            $stat = $stmt->fetch(PDO::FETCH_OBJ);
            return $stat->paie;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_op($transactionId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_transactions WHERE op_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $transactionId);
        $stmt->execute();

        $rowObject = $stmt->fetch(PDO::FETCH_OBJ);


        return $rowObject;
    }

    public function select_last_jour($jourId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT max(transaction_id) as max_id FROM tbl_transactions WHERE jour_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $jourId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->transactionId = $rowObject->max_id;
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    // select all rows from tables;

    public function select_all()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_nb_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where op_id=?");
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $stat = $stmt->rowCount();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_op($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where op_id=?");
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_op_count($opId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where op_id=?");
            $stmt->bindValue(1, $opId);
            $stmt->execute();
            $stat = $stmt->rowCount();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_jour($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions join journal on tbl_transactions.jour_id=journal.jour_id where journal.jour_id=:jour_id order by create_date");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_jour_admin($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions join journal on tbl_transactions.jour_id=journal.jour_id where journal.jour_id=:jour_id  order by transaction_id");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_jour_admin_typ($jour_id, $idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions join journal on tbl_transactions.jour_id=journal.jour_id where (parent_id=:jour_id or journal.jour_id=:jour_id) and party_code<>'Enfant' and id_bq=:idBq  order by transaction_id");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_bal_jour($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as in_amount FROM tbl_transactions where jour_id=:jour_id AND status='IN'");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where jour_id=:jour_id AND status='OUT'");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $out = $stmt->fetch();

            $balance = (float)($in['in_amount'] - $out['out_amount']);
            return $balance;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_out($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where jour_id=:jour_id 
    AND transaction_type='Retrait' or transaction_type='Fourniture'");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_in($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where jour_id=:jour_id AND transaction_type='Versement'  ");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_cred($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as cred FROM tbl_transactions where party_code=:partyCode  and transaction_type='Vente' and etat='1' and mode_paie='DETTE' ");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['cred'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function tot_sum_cred($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT coalesce(sum(tbl_credits.total-tbl_credits.paid),0) as credit_total,
            CASE WHEN coalesce(sum(tbl_credits.total-tbl_credits.paid),0) > tbl_customers.credit_limit 
            THEN 'Oui' ELSE 'Non' END as statut_credit, 
            CASE WHEN MAX(tbl_credits.created_at) <= DATE_SUB(NOW(), INTERVAL 7 DAY) AND sum(tbl_credits.total-tbl_credits.paid) > 0 
            THEN 'Oui'  ELSE 'Non'  END as statut_paiement
            FROM tbl_credits left join tbl_customers on tbl_credits.customer_id=tbl_customers.personne_id  where tbl_credits.customer_id=:partyCode
             having credit_total>0 ");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $out = $stmt->fetch(PDO::FETCH_OBJ);

            return $out;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function tot_limit_cred($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(total-paid) as cred FROM tbl_credits where customer_id=:partyCode  and is_paid='0'  ");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['cred'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_sum_pay($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paye FROM tbl_transactions where party_code=:partyCode  and transaction_type='Vente' and etat='1' and mode_paie='CAISSE' ");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['paye'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_cred_0($partyCode, $idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as cred FROM tbl_transactions where party_code=:partyCode AND id_bq=:idBq");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['cred'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_bal_jour_admin($jour_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as in_amount FROM tbl_transactions join tbl_journal on tbl_transactions.jour_id=tbl_journal.jour_id where (parent_id=:jour_id or tbl_journal.jour_id=:jour_id) AND status='IN' AND canceled='1' and party_code<>'Enfant'");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions join tbl_journal on tbl_transactions.jour_id=tbl_journal.jour_id where (parent_id=:jour_id or tbl_journal.jour_id=:jour_id) AND status='OUT'  AND canceled='1' and party_code<>'Enfant'");
            $stmt->bindParam("jour_id", $jour_id);
            $stmt->execute();
            $out = $stmt->fetch();

            $balance = $in['in_amount'] - $out['out_amount'];
            return $balance;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_sum_cred_2($partyCode, $idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as cred FROM tbl_transactions where party_code=:partyCode AND id_bq=:idBq");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $out = $stmt->fetch();


            $stmt = $db->prepare("SELECT sum(tbl_paiements.amount) as paie FROM tbl_paiements join tbl_transactions on tbl_paiements.transaction_id=tbl_transactions.transaction_id
  where party_code=:partyCode group by party_code");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $paid = $stmt->fetch();

            $stmt = $db->prepare("SELECT open_bal FROM tbl_accounts where personne_id=:partyCode");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->execute();
            $ant = $stmt->fetch();

            $solde = (@$out['cred'] - @$ant['open_bal']) - @$paid['paie'];

            return $solde;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_sum_out_period($from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Retrait' and (date(create_date)
    between :from_d and :to_d)  ");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_out_period_2($from_d, $to_d, $party)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Retrait' and (date(create_date)
    between :from_d and :to_d) AND party_code=:party");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("party", $party);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_in_period($from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Versement' and (date(create_date)
    between :from_d and :to_d)  ");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_in_period_2($from_d, $to_d, $descript)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Versement' and (date(create_date)
    between :from_d and :to_d) and descript=:descript");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("descript", $descript);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_in_period_ant($from_d, $to_d, $descript)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions join operation on tbl_transactions.op_id=operation.op_id where transaction_type='Vente' and (date(tbl_transactions.create_date)
    between :from_d and :to_d) and operation.create_date<:fromD and descript=:descript");
            $stmt->bindParam("fromD", $from_d);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("descript", $descript);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_out_period_cat($from_d, $to_d, $cat)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where (transaction_type='Retrait' or transaction_type='Fourniture') and (date(create_date)
    between :from_d and :to_d) and party_code=:cat");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("cat", $cat);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_emprunt_period($from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Emprunt' and (date(create_date)
    between :from_d and :to_d)  ");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_out_period_dep($from_d, $to_d, $descript)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as out_amount FROM tbl_transactions where transaction_type='Retrait' and (date(create_date)
    between :from_d and :to_d)  AND descript=:descript ");
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("descript", $descript);
            $stmt->execute();
            $out = $stmt->fetch();

            return $out['out_amount'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_type($type)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where transaction_type=:type
    order by create_date desc limit 0,100");
            $stmt->bindParam("type", $type);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_type_period_bq($type, $from_d, $to_d, $idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where transaction_type=:type and id_bq=:idBq and (create_date
    between :from_d and :to_d) order by op_id");
            $stmt->bindParam("type", $type);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_type_period($type, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where transaction_type=:type  and (date(create_date)
    between :from_d and :to_d) order by op_id");
            $stmt->bindParam("type", $type);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_open_bal_bq($idBq, $from_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as totIn FROM tbl_transactions where id_bq=:idBq  and date(create_date)<:from_d and status='IN'");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->execute();
            $res = $stmt->fetch();
            $in = $res['totIn'];

            $stmt = $db->prepare("SELECT sum(amount) as totOut FROM tbl_transactions where id_bq=:idBq  and date(create_date)<:from_d and status='OUT'");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->execute();
            $res = $stmt->fetch();
            $out = $res['totOut'];

            return ($in - $out);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_open_bal_part($partyCode, $from_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as totIn FROM tbl_transactions where party_code=:partyCode  and date(create_date)<:from_d and status='IN'");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("from_d", $from_d);
            $stmt->execute();
            $res = $stmt->fetch();
            $in = $res['totIn'];

            $stmt = $db->prepare("SELECT sum(amount) as totOut FROM tbl_transactions where party_code=:partyCode  and date(create_date)<:from_d and status='OUT'");
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("from_d", $from_d);
            $stmt->execute();
            $res = $stmt->fetch();
            $out = $res['totOut'];

            return ($in - $out);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_period_bq($idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where id_bq=:idBq  and (date(create_date)
    between :from_d and :to_d) and mode_paie='CAISSE' order by create_date,op_id");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_period_bq_0($idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT tbl_transactions.* FROM tbl_transactions left join tbl_ventes on tbl_transactions.op_id=tbl_ventes.op_id where id_bq=:idBq  and (date(create_date)
                between :from_d and :to_d) and transaction_type='Vente' and mode_paie='CAISSE' and etat=1 order by idvente");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_period_bq_1($idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT tbl_transactions.* FROM tbl_transactions left join tbl_ventes on tbl_transactions.op_id=tbl_ventes.op_id where  id_bq=:idBq  and (date(create_date)
    between :from_d and :to_d) and transaction_type='Vente' and mode_paie='PROFORMAT' and etat=1 order by idvente");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_period_bq_2($idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT tbl_transactions.* FROM tbl_transactions left join tbl_ventes on tbl_transactions.op_id=tbl_ventes.op_id where id_bq=:idBq  and (date(create_date)
    between :from_d and :to_d) and transaction_type='Vente' and etat='1'  and mode_paie='DETTE' order by num_vente");
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_dette_bq($idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT tbl_transactions.* FROM tbl_transactions left join tbl_ventes on
             tbl_transactions.op_id=tbl_ventes.op_id where id_bq=:idBq and transaction_type='Vente' and etat='1'  and mode_paie='DETTE' order by num_vente");
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_all_dette($branche_id)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT staff_id,tbl_credits.customer_id,tbl_customers.customer_name, coalesce(sum(tbl_credits.total-tbl_credits.paid),0) as credit_total,tbl_customers.credit_limit,
            CASE WHEN coalesce(sum(tbl_credits.total-tbl_credits.paid),0) > tbl_customers.credit_limit 
            THEN 'Oui' ELSE 'Non' END as statut_credit, 
            CASE WHEN MAX(tbl_credits.created_at) <= DATE_SUB(NOW(), INTERVAL 7 DAY) AND sum(tbl_credits.total-tbl_credits.paid) > 0 
            THEN 'Oui'  ELSE 'Non'  END as statut_paiement
            FROM tbl_credits left join tbl_customers on tbl_credits.customer_id=tbl_customers.personne_id  where branche_id=? 
             GROUP by tbl_credits.customer_id,tbl_customers.customer_name,tbl_customers.credit_limit  having credit_total>0 ");
            $stmt->execute([$branche_id]);
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_dette_by_agent($branche_id, $agent)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_credits.staff_id,tbl_credits.customer_id,tbl_customers.customer_name, coalesce(sum(tbl_credits.total-tbl_credits.paid),0) as credit_total,tbl_customers.credit_limit,
            CASE WHEN coalesce(sum(tbl_credits.total-tbl_credits.paid),0) > tbl_customers.credit_limit 
            THEN 'Oui' ELSE 'Non' END as statut_credit, 
            CASE WHEN MAX(tbl_credits.created_at) <= DATE_SUB(NOW(), INTERVAL 7 DAY) AND sum(tbl_credits.total-tbl_credits.paid) > 0 
            THEN 'Oui'  ELSE 'Non'  END as statut_paiement
            FROM tbl_credits,tbl_customers,tbl_staff where tbl_credits.customer_id=tbl_customers.personne_id and tbl_credits.staff_id = tbl_staff.staff_id and tbl_credits.branche_id=? and tbl_credits.staff_id=?
             GROUP by tbl_credits.customer_id,staff_id,tbl_customers.credit_limit  having credit_total>0 ");
            $stmt->execute([$branche_id, $agent]);
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_period_bq_3($idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT DISTINCT tbl_transactions.* FROM tbl_transactions left join tbl_ventes on tbl_transactions.op_id=tbl_ventes.op_id where id_bq=:idBq  and transaction_type='Vente' and etat=1  and mode_paie='DETTE' order by idvente DESC");
            $stmt->bindParam("idBq", $idBq);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_sum_bq_2($posId, $idBq, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(tbl_transactions.amount) as tot FROM tbl_transactions left join tbl_ventes on tbl_transactions.op_id=tbl_ventes.op_id where pos_id=:posId and id_bq=:idBq  and (date(create_date)
    between :from_d and :to_d) and transaction_type='Vente' and mode_paie='CAISSE' and status='IN' and etat=1 ");
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idBq", $idBq);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetch(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_period($posId, $partyCode, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions  where pos_id=:posId and party_code=:partyCode  and (date(create_date)
    between :from_d and :to_d) order by op_id");
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_period_0($posId, $partyCode, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_transactions.* FROM tbl_transactions join vente on tbl_transactions.op_id=vente.op_id where pos_id=:posId and party_code=:partyCode  and (date(create_date)
    between :from_d and :to_d) order by num_vente");
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_period_1($partyCode, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions  where party_code=:partyCode  and (date(create_date)
    between :from_d and :to_d) order by create_date,op_id");
            //$stmt->bindParam("posId",$posId);
            $stmt->bindParam("partyCode", $partyCode);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function transaction_amount($transType, $from_d, $to_d)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as tot FROM tbl_transactions where transaction_type=:transType  AND (date(create_date) BETWEEN :from_d AND :to_d)");
            $stmt->bindParam("transType", $transType);
            $stmt->bindParam("from_d", $from_d);
            $stmt->bindParam("to_d", $to_d);
            $stmt->execute();
            $trans = $stmt->fetch();
            return $trans['tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_op_an_date_type($dateTrans, $id_bq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where date(create_date)<?  and id_bq=? and status='IN'  and transaction_type<>'Ouverture'");
            $stmt->bindValue(1, $dateTrans);
            $stmt->bindValue(2, $id_bq);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where date(create_date)<? and id_bq=? and status='OUT'  and transaction_type<>'Ouverture'");
            $stmt->bindValue(1, $dateTrans);
            $stmt->bindValue(2, $id_bq);
            $stmt->execute();

            $out = $stmt->fetch();

            $solde = $in['mont'] - $out['mont'];
            return $solde;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_op_by_date_type($dateTrans, $id_bq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT amount as mont, tbl_transactions.* FROM tbl_transactions where date(create_date)=? and id_bq=?  and transaction_type<>'Ouverture' order by transaction_id ");
            $stmt->bindValue(1, $dateTrans);
            $stmt->bindValue(2, $id_bq);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function delete($transactionId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_transactions WHERE transaction_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $transactionId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function insert($jour_id, $op_id, $transaction_type, $descript, $mount, $party_code, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $partyAux)
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO `tbl_transactions`(`jour_id`, `op_id`, `transaction_type`, `descript`,`amount`, `party_code`,`id_bq`, `pos_id`, `personne_id`,`status`,`create_date`,`mode_paie`,`party_aux`)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $db->prepare($sql);

            $ok = $stmt->execute([$jour_id, $op_id, $transaction_type, $descript, $mount, $party_code, $id_bq, $pos_id, $personne_id, $status, $create_date, $mode_paie, $partyAux]);
            return $ok;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function setAvanceDette($customer_id, $credits_id, $caisse_id, $personne_id, $amount, $created_at)
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO tbl_avance_dettes(customer_id,credits_id,branche_id,personne_id,amount,created_at)
            VALUES(?,?,?,?,?,?)";

            $stmt = $db->prepare($sql);

            $ok = $stmt->execute([$customer_id, $credits_id, $caisse_id, $personne_id, $amount, $created_at]);
            return $ok;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function setDette($op_id, $customer_id, $pos_id,  $staff_id, $total, $paid)
    {
        $db = getConnection();
        try {
            $sql = " INSERT INTO tbl_credits(op_id,customer_id,branche_id,staff_id,total,paid) VALUES(?,?,?,?,?,?)";

            $stmt = $db->prepare($sql);

            $ok = $stmt->execute([$op_id, $customer_id, $pos_id,  $staff_id, $total, $paid]);
            return $ok;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function insert_2()
    {
        $db = getConnection();
        try {
            $sql = "
            INSERT INTO `tbl_transactions`(`jour_id`, `op_id`, `transaction_type`, `descript`,`amount`, `party_code`,`pos_id`, `bal_after`, `personne_id`,`status`,`create_date`,`mode_paie`)
            VALUES(:jourId,:opId,:transactionType,:descript,:amount,:partyCode,:posId,:balAfter,:personneId,:status,:createDate,:modePaie)";

            $stmt = $db->prepare($sql);

            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($transactionId)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE
                tbl_transactions
            SET
				amount=:amount,
				descript=:descript,
				party_code=:partyCode,
                id_bq=:idBq,
                mode_paie=:modePaie,
                create_date=:createDate
            WHERE
                transaction_id=:transactionId";

            $stmt = $db->prepare($sql);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function updateDette($paid, $id)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_credits SET paid=? WHERE credits_id=?";

            $stmt = $db->prepare($sql);

            return (bool)$stmt->execute([$paid, $id]);
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function update_state($Id, $etat)
    {
        $db = getConnection();
        $sql = "UPDATE tbl_transactions SET etat=:etat WHERE op_id=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("etat", $etat);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }
    public function update_is_paid($Id, $descript, $status, $mode_paie, $date)
    {
        $db = getConnection();
        $sql = "UPDATE tbl_transactions SET mode_paie=:mode_paie, descript=:descript, status=:status,
         create_date=:create_date WHERE op_id=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("descript", $descript);
        $stmt->bindParam("mode_paie", $mode_paie);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("create_date", $date);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }
    public function update_dette_status($Id)
    {
        $db = getConnection();
        $sql = "UPDATE tbl_credits SET is_paid='1' WHERE credits_id=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }
    public function update_status($Id, $etat, $mode, $descript, $date)
    {
        $db = getConnection();
        $sql = "UPDATE tbl_transactions SET status=:status,mode_paie=:mode,descript=:descript,create_date=:create_date WHERE op_id=:id";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("status", $etat);
        $stmt->bindParam("mode", $mode);
        $stmt->bindParam("descript", $descript);
        $stmt->bindParam("create_date", $date);
        $stmt->bindParam("id", $Id);

        return (bool)$stmt->execute();
    }
    public function update_op($amount, $opId)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE
                tbl_transactions
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
                tbl_transactions
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
        if ($this->transactionId != "") {
            return $this->update($this->transactionId);
        } else {
            return false;
        }
    }


    function upload_image()
    {
        if (isset($_FILES["trans_image"])) {
            $extension = explode('.', $_FILES['trans_image']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = './../upload/' . $new_name;
            move_uploaded_file($_FILES['trans_image']['tmp_name'], $destination);
            return $new_name;
        }
    }

    public function select_sum_op_bq($jour)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_transactions join operation on tbl_transactions.op_id=operation.op_id where tbl_transactions.jour_id=:id and operation.jour_id=:id2 and canceled='1' and id_bq<>'1' and transaction_type='Vente' group by tbl_transactions.jour_id");
            $stmt->bindParam("id", $jour);
            $stmt->bindParam("id2", $jour);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_CAISSE($jour)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_transactions join operation on tbl_transactions.op_id=operation.op_id where tbl_transactions.jour_id=:id and operation.jour_id=:id2 and transaction_type='Vente' and mode_paie<>'Virement' group by tbl_transactions.jour_id");
            $stmt->bindParam("id", $jour);
            $stmt->bindParam("id2", $jour);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_v($jour)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_transactions join operation on tbl_transactions.op_id=operation.op_id where tbl_transactions.jour_id=:id and operation.jour_id=:id2 and transaction_type='Vente' and mode_paie='Virement' group by tbl_transactions.jour_id");
            $stmt->bindParam("id", $jour);
            $stmt->bindParam("id2", $jour);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_op_ant($jour)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as paie FROM tbl_transactions join operation on tbl_transactions.op_id=operation.op_id where tbl_transactions.jour_id=:id and operation.jour_id<>:id2 and transaction_type='Vente' group by tbl_transactions.jour_id");
            $stmt->bindParam("id", $jour);
            $stmt->bindParam("id2", $jour);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['paie'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function nb_format($val)
    {
        return number_format($val, 1, '.', ',');
    }

    public function getBalance($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where  party_code=? and status='IN'");
            $stmt->bindValue(1, $partyCode);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where party_code=? and status='OUT'");
            $stmt->bindValue(1, $partyCode);
            $stmt->execute();

            $out = $stmt->fetch();

            $solde = $in['mont'] - $out['mont'];
            return $solde;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function getBalanceBq($bank)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where  id_bq=? and status='IN'");
            $stmt->bindValue(1, $bank);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(amount) as mont FROM tbl_transactions where id_bq=? and status='OUT'");
            $stmt->bindValue(1, $bank);
            $stmt->execute();

            $out = $stmt->fetch();

            $solde = $in['mont'] - $out['mont'];
            return $solde;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function date_format($val)
    {
        return date('d-m-Y', strtotime($val));
    }

    public function exist_bq_trans($idBq)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_transactions where id_bq=:idBq");
            $stmt->bindParam("idBq", $idBq);
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
