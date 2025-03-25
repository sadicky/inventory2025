<?php
require_once("connexion.php");

class Periode
{
    private $idPer;
    private $codePer;
    private $debut;
    private $fin;
    private $etat;
    private $crt;

    public function setIdPer($idPer)
    {
        $this->idPer = (int)$idPer;
    }

    public function setCodePer($codePer)
    {
        $this->codePer = (string)$codePer;
    }
    public function setDebut($debut)
    {
        $this->debut = (string)$debut;
    }
    public function setFin($fin)
    {
        $this->fin = (string)$fin;
    }
    public function setEtat($etat)
    {
        $this->etat = (string)$etat;
    }
    public function setCrt($crt)
    {
        $this->crt = (string)$crt;
    }
    public function getIdPer()
    {
        return $this->idPer;
    }

    public function getCodePer()
    {
        return $this->codePer;
    }
    public function getDebut()
    {
        return $this->debut;
    }
    public function getFin()
    {
        return $this->fin;
    }
    public function getEtat()
    {
        return $this->etat;
    }

    public function getCrt()
    {
        return $this->crt;
    }
    public function getTableName()
    {
        return "tbl_periodes";
    }


    public function select_crt($crt)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_periodes WHERE crt=?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $crt);
        $stmt->execute();
        $tbP = $stmt->fetchObject();
        return $tbP;
    }

    public function getPeriode($idPer)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_periodes WHERE periode_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idPer]);
        $rowObject = $stmt->fetchObject();
        return $rowObject;
    }
    public function select_all()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_periodes");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function exist_per($idPer)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where id_per=:idPer");
            $stmt->bindParam("idPer", $idPer);
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
