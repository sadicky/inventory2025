<?php
require_once("connexion.php");

class POS
{
    private $posId;
    private $posName;
    private $posCode;
    private $status;

    public function setPosId($posId)
    {
        $this->posId = (int)$posId;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPosName($posName)
    {
        $this->posName = (string)$posName;
    }

    public function setPosCode($posCode)
    {
        $this->posCode = $posCode;
    }

    public function getPosId()
    {
        return $this->posId;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getPosName()
    {
        return $this->posName;
    }

    public function getPosCode()
    {
        return $this->posCode;
    }

    public function getTableName()
    {
        return "tbl_stores";
    }

    public function getPOS($posId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores WHERE store_id=:store_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("store_id", $posId);
        $stmt->execute();

        $rowObject = $stmt->fetchObject();

        return $rowObject;
    }

    public function getStorePrincipal()
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and b.isPrincipal='1'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getStorePrincipal1()
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and b.isPrincipal='1' and s.type='STOCK'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getStores()
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.statut='1'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getBranchePOS($branche)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.statut='1' and  b.branche_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$branche]);
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getBrancheStockPOS($branche)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.statut='1' and  b.branche_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$branche]);
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getBrancheStockPOS_0($branche)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.statut='1' and s.type='VENTE' and  b.branche_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$branche]);
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }


    public function getPOSBranche($pos)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.statut='1' and  s.store_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$pos]);
        $tbP = array();
        while ($data =  $stmt->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }


    public function getStoreId($posId)
    {
        $db = getConnection();
        $sql =  "SELECT * FROM tbl_stores as s, tbl_branches as b 
        WHERE s.branche_id = b.branche_id and s.store_id=:store_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("store_id", $posId);
        $stmt->execute();

        $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

        return $rowObject;
    }
}
