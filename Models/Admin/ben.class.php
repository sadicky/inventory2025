<?php
include_once("connexion.php");

class Ben 
{
    private $idBen;
    private $name;
    private $typ;
    private $personneId;

    public function setIdBen($idBen)
    {
        $this->idBen = (int)$idBen;
    }

    public function setName($name)
    {
        $this->name = (string)$name;
    }

    public function setTyp($typ)
    {
        $this->typ = (string)$typ;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = (int)$personneId;
    }

    public function getIdBen()
    {
        return $this->idBen;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTyp()
    {
        return $this->typ;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }


    public function getTableName()
    {
        return "tbl_Ben";
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
          $db = getConnection();
        try
        {
        $sql =  "SELECT * FROM tbl_ben WHERE id_ben=:id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id",$personneId);
        $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return  $rowObject;
        }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    

    public function select_all($personneId)
    {
     $db = getConnection();
    try
    {
        $stmt = $db->prepare("SELECT * FROM tbl_ben where personne_id=:personneId");
        $stmt->bindParam("personneId",$personneId);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }
    catch(PDOException $ex)
    {
        return $ex;
    }
    }

    public function select_all_2()
    {
     $db = getConnection();
    try
    {
        $stmt = $db->prepare("SELECT * FROM tbl_ben");
        //$stmt->bindParam("personneId",$personneId);
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }
    catch(PDOException $ex)
    {
        return $ex;
    }
    }


    public function insert()
    {
        $db = getConnection();
            try
            {
        $sql ="
            INSERT INTO tbl_ben
            (name,typ,personne_id)
            VALUES(:name,:typ,:personneId)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam("name",$this->name);
        $stmt->bindParam("typ",$this->typ);
        $stmt->bindParam("personneId",$this->personneId);
        $stmt->execute();
        return $db->lastInsertId();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update($personneId)
    {
         $db = getConnection();
            try
            {
        $sql ="
            UPDATE
                tbl_ben
            SET
				name=:name,
				typ=:typ
            WHERE
                personne_id=:personneId";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("name",$this->name);
        $stmt->bindParam("typ",$this->typ);
        $stmt->bindParam("personneId",$personneId);
        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }

    }

    public function update_one($Id,$val_id,$val_n,$val_f)
       {


         $db = getConnection();
            try
            {
            $sql ="
            UPDATE
                ".$this->getTableName()."
            SET
                ".$val_n." =:val_f
            WHERE
               ".$val_id."=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f",$val_f);
            $stmt->bindParam("id",$Id);

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
  $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT * FROM tbl_ben where personne_id=:id");
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

 public function select_all_srch($personneId,$keyword)
 {
  $db = getConnection();
 try
 {
 $stmt = $db->prepare("SELECT * FROM tbl_ben where name like '%".$keyword."%' and personne_id=:personneId");
 $stmt->bindParam("personneId",$personneId);
 $stmt->execute();
 $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
 return $stat;
 }
 catch(PDOException $ex)
 {
 return $ex;
 }
 }

}
?>
