<?php
require_once("connexion.php");

class Presence
{
   private $staff_id;
   private $date_presence;
   private $presence;
   private $motif;
   private $justify;
    public function insert($staff_id,$date_presence,$presence,$motif)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_presences(staff_id,date_presence,presence,motif) VALUES (?,?,?,?)");
        $addline1 = $add1->execute(array($staff_id,$date_presence,$presence,$motif)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }

    public function updatePresence($staff_id,$date_presence,$presence,$motif,$justify, $id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_presences SET staff_id=?,date_presence=?,presence=?,motif=?,justify=?   WHERE devise_id =?");
        $ok = $update->execute(array($staff_id,$date_presence,$presence,$motif,$justify, $id)) or die(print_r($update->errorInfo()));
        return $ok;
    }

    public function getPresences()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_presences order by devise ASC");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getPresences_by_branche($staff_id,$date)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT presence FROM tbl_presences WHERE staff_id =? AND date_presence =? ");
        $statement->execute([$staff_id,$date]);
        $tbP = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $tbP;
        
    }
    //afficher les catégories
  
    public function getPresenceId($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_presences WHERE presence_id=?");
        $statement->execute([$id]);
        $data =  $statement->fetchObject();
        return $data;
    }

    public function countPresence($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT count(presence) as nbr FROM tbl_presences WHERE presence=1 and staff_id=?");
        $statement->execute([$id]);
        $data =  $statement->fetchObject();
        return $data;
    }


    public function deletePresence($id)
    {
        $db = getConnection();
        $delete =  $db->prepare("DELETE FROM tbl_presences WHERE presence_id =?");

        $ok = $delete->execute(array($id));
        return $ok;
    }

}
