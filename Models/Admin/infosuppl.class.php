<?php
include_once("dbconnect.php");

class BeanInfoSuppl extends dbconnect
{
    private $idInfo;
    private $cni;
    private $nat;
    private $personneId;

    public function setIdInfo($idInfo)
    {
        $this->idInfo = (int)$idInfo;
    }

    public function setCni($cni)
    {
        $this->cni = (string)$cni;
    }

    public function setNat($nat)
    {
        $this->nat = (string)$nat;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = (int)$personneId;
    }

    public function getIdInfo()
    {
        return $this->idInfo;
    }

    public function getCni()
    {
        return $this->cni;
    }

    public function getNat()
    {
        return $this->nat;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }


    public function getTableName()
    {
        return "info_suppl";
    }


    public function __construct($idInfo = null)
    {
        $this->initDB();
        if (!empty($idInfo)) {
            $this->select($idInfo);
        }
    }


    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        //unset($this);
    }


    public function select($personneId)
    {
         $db = $this->dbase;
        try
        {
        $sql =  "SELECT * FROM info_suppl WHERE personne_id=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idInfo = $rowObject->id_info;
            @$this->cni = $rowObject->cni;
            @$this->nat = $rowObject->nat;
            @$this->personneId = $rowObject->personne_id;
            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_cni($personneId)
    {
         $db = $this->dbase;
        try
        {
        $sql =  "SELECT * FROM info_suppl WHERE cni=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->idInfo = $rowObject->id_info;
            @$this->cni = $rowObject->cni;
            @$this->nat = $rowObject->nat;
            @$this->personneId = $rowObject->personne_id;
            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function select_tel($personneId)
    {
         $db = $this->dbase;
        try
        {
        $sql =  "SELECT * FROM personne WHERE contact=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->personneId = $rowObject->personne_id;
            
            return $stmt->rowCount();
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }


    public function insert()
    {
       $db = $this->dbase;
            try
            {
        $sql ="
            INSERT INTO info_suppl
            (cni,nat,personne_id)
            VALUES(:cni,:nat,:personneId)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("cni",$this->cni);
        $stmt->bindParam("nat",$this->nat);
        $stmt->bindParam("personneId",$this->personneId);
        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update($personneId)
    {
        $db = $this->dbase;
            try
            {
        $sql ="
            UPDATE
                info_suppl
            SET
				cni=:cni,
				nat=:nat
            WHERE
                personne_id=:personneId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("cni",$this->cni);
        $stmt->bindParam("nat",$this->nat);
        $stmt->bindParam("personneId",$personneId);
        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }


    public function updateCurrent()
    {
        if ($this->personneId != "") {
            return $this->update($this->personneId);
        } else {
            return false;
        }
    }

    // select all rows from tables;

 public function select_num_row($personneId)
 {
 $db = $this->dbase;
 try
 {
 $stmt = $db->prepare("SELECT * FROM info_suppl where personne_id=:id");
 $stmt->bindParam("id",$personneId);
 $stmt->execute();
 $stat = $stmt->rowCount();
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

}
?>
