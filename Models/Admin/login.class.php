<?php
require_once("connexion.php");

Class Login
{
    public $statut = 1;
    public $email;
    public $pwd;
    public $name; 
    public $type;

    public function login($email){
        $this->email=$email;
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_users WHERE STATUT=1 AND EMAIL=?");
        $statement->execute(array($email));
        $tbP = array();
        while($data =  $statement->fetchObject()){
            $tbP[] = $data;
        }
         return $tbP;

    }

}
?>