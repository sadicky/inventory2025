<?php
require_once("connexion.php");

class Salaires
{
    private $personneId;
    private $role;
    private $photo;
    private $nomComplet;
    private $contact;
    private $email;
    private $genre;
    private $adresse;
    private $lastUpdate;
    private $posId;


    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }


    public function setPersonneId($personneId)
    {
        $this->personneId = $personneId;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }


    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function setNomComplet($nom)
    {
        $this->nomComplet = $nom;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getNomComplet()
    {
        return $this->nomComplet;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }
    public function getPosId()
    {
        return $this->posId;
    }

    public function getTableName()
    {
        return "tbl_users";
    }


    //ajouter un Admin
    public function setUser($supplier_name, $sup_contact, $email, $usename, $pwd, $role, $id)
    {
        //   PWD

        $db = getConnection();
        $a = $db->prepare("INSERT INTO tbl_users (noms,tel,email,username,password,role_id,personne_id) VALUES (?,?,?,?,?,?,?)");
        $a->execute(array($supplier_name, $sup_contact, $email, $usename, $pwd, $role, $id)) or die(print_r($a->errorInfo()));

        return $a;
    }

    public function insert($name, $contact, $email, $usename, $pwd, $role, $pos_id, $id)
    {
        //   PWD

        $db = getConnection();
        $a = $db->prepare("INSERT INTO tbl_users (noms,tel,email,username,password,role_id,pos_id,personne_id) VALUES (?,?,?,?,?,?,?,?)");
        $a->execute(array($name, $contact, $email, $usename, $pwd, $role, $pos_id, $id)) or die(print_r($a->errorInfo()));

        return $a;
    }
    public function getRoles()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_roles");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getUsername($email)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT username FROM tbl_users WHERE username = ?");
        $statement->execute([$email]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }


    public function deleteUser($id)
    {
        $db = getConnection();
        $sql = $db->prepare("DELETE FROM tbl_users WHERE id_user=?");
        $ok = $sql->execute(array($id));
        return $ok;
    }

    public function activUser($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_users SET statut='1' WHERE id_user=?");
        $d = $req->execute(array($iduser));
        return $d;
    }
    public function desactUser($iduser)
    {
        $db = getConnection();
        $req = $db->prepare("UPDATE tbl_users SET statut='0' WHERE id_user=?");
        $d = $req->execute(array($iduser));
        return $d;
    }

    public function select($personneId)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * from tbl_users as u,tbl_roles as r WHERE u.role_id =r.role_id and user_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_3($personneId)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * from tbl_users as u,tbl_roles as r WHERE u.role_id =r.role_id and user_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_1($personneId)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * from tbl_users as u,tbl_roles as r WHERE u.role_id =r.role_id and user_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function select_cash($typeUser, $state)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * FROM tbl_users WHERE type_user=:typeUser and cash=:cash";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("cash", $state);
            $stmt->bindParam("typeUser", $typeUser);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return  $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_2($personneId)
    {
        $db =  getConnection();

        try {
            $sql =  "SELECT * FROM tbl_users as u,tbl_roles as r WHERE u.role_id =r.role_id and personne_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return  $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function doLogin($username, $password)
    {

        $db =  getConnection();

        try {
            $sql = "SELECT user_id, username, password, actif,type_user,pos_id,level_user FROM tbl_users WHERE username=:username";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("username", $username);
            $stmt->execute();


            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            if ($stmt->rowCount() == 1) {
                if (password_verify($password, $rowObject->password)) {
                    $user_id = $rowObject->user_id;
                    @$actif = $rowObject->actif;
                    @$this->posId = $rowObject->pos_id;
                    $_SESSION['user_session'] = $rowObject->user_id;
                    //$_SESSION['pos']=$rowObject->pos_id;
                    $_SESSION['level'] = $rowObject->level_user;
                    return true;
                } else {
                    return false;
                }
            }
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function is_loggedin()
    {
        if (isset($_SESSION['logged'])) {
            return true;
        } else {
            return false;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function doLogout()
    {
        session_destroy();
        unset($_SESSION['id']);
        return true;
    }


    public function update_one($Id, $val_id, $val_n, $val_f)
    {

        $db =  getConnection();
        try {
            $sql = " UPDATE tbl_users SET " . $val_n . " =:val_f WHERE " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function update_one_($Id, $val_id, $val_n, $val_f)
    {

        $db =  getConnection();
        try {
            $sql = " UPDATE tbl_staff SET " . $val_n . " =:val_f WHERE " . $val_id . "=:id";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_exist_pseudo($username)
    {
        $db =  getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_users where username=:username");
            $stmt->bindParam("username", $username);
            $stmt->execute();
            $stat = $stmt->rowCount();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    
    public function setStaff($noms,$tel,$sexe,$adress,$role,$statut,$id,$personneId)
    {  
        $db = getConnection();
        $add = $db->prepare("INSERT INTO tbl_staff (noms,tel,sexe,adress,role,statut,branche_id,personne_id) VALUES (?,?,?,?,?,?,?,?)");
        $addline = $add->execute(array($noms,$tel,$sexe,$adress,$role,$statut,$id,$personneId));
        return $addline;
    }
    

    public function setStaffSalaire($staff,$devise,$salaire)
    {  
        $db = getConnection();
        $add = $db->prepare("INSERT INTO tbl_salaire (staff_id,devise_id,salaire) VALUES (?,?,?)");
        $addline = $add->execute(array($staff,$devise,$salaire));
        return $addline;
    }
    
    
    public function getStaff()
    {  
        $db = getConnection();
        $add = $db->prepare("SELECT * FROM tbl_staff as s,tbl_branches as b WHERE b.branche_id = s.branche_id");
        $add->execute();
        $tbP = array();
        while($data =  $add->fetchObject()){
            $tbP[] = $data;
        }
         return $tbP;
    }

    public function getStaffId($id)
    {  
        $db = getConnection();
        $add = $db->prepare("SELECT * FROM tbl_staff as s,tbl_branches as b WHERE b.branche_id = s.branche_id and staff_id=?");
        $add->execute([$id]);
        $tbP =  $add->fetchObject();
         return $tbP;
    }
    
}
