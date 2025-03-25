<?php
include_once("connexion.php");

class Personnes
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


    public function getTableName()
    {
        return "tbl_personnes";
    }

    public function select($personneId)
    {

        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_personnes WHERE personne_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_nom($personneId)
    {

        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_personnes WHERE nom_complet=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

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
            $stmt = $db->prepare("SELECT * FROM tbl_personnes order by nom_complet");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_role($role)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_personnes where role=:role order by nom_complet");
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_role_srch($role, $keyword)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_personnes where nom_complet like '%" . $keyword . "%' and role=:role");
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_role_srch_hot($role, $keyword)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_personnes join tbl_customers on tbl_personnes.personne_id=tbl_customers.personne_id where (nom_complet like '%" . $keyword . "%' or customer_num like '%" . $keyword . "%') and role=:role");
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_role_date($role, $last)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_personnes where date(last_update)=:lst and role=:role order by last_update desc");
            $stmt->bindParam("lst", $last);
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_role_code($role)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_personnes where role=:role order by contact, nom_complet");
            //$stmt->bindParam("lst",$last);
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function delete($personneId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_personnes WHERE personne_id=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $personneId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function setPersonne($role,$nom,$contact,$email,$genre,$adresse)
    {
           $db = getConnection();

            $stmt = $db->prepare("INSERT INTO tbl_personnes (role,nom_complet,contact,email,genre,adresse) VALUES(?,?,?,?,?,?)");
          $ok = $stmt->execute(array($role,$nom,$contact,$email,$genre,$adresse))or die(print_r($stmt->errorInfo()));
           
        //    $id = $db->lastInsertId();

            return $ok;
    }

    public function insert_2()
    {
        $db = getConnection();
        try {
            $sql = "INSERT INTO tbl_personnes
            (role,nom_complet)
            VALUES(:role,:nom)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("role", $this->role);
            $stmt->bindParam("nom", $this->nomComplet);
            $stmt->execute();

            return $db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($role,$nom,$tel,$email,$genre,$adresse,$personneId)
    {
        $db = getConnection();
        try {
            $sql = "  UPDATE tbl_personnes SET
				role=:role,
				nom_complet=:nom,
				contact=:contact,
				email=:email,
				genre=:genre,
                adresse=:adresse,
                last_update=now()
            WHERE
                personne_id=:personneId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("role", $role);
            $stmt->bindParam("nom", $nom);
            $stmt->bindParam("contact", $tel);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("genre", $genre);
            $stmt->bindParam("adresse", $adresse);
            $stmt->bindParam("personneId", $personneId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_2($personneId)
    {
        // $constants = get_defined_constants();
        $db = getConnection();
        try {
            $sql = "
            UPDATE
                tbl_personnes
            SET
                nom_complet=:nom
            WHERE
                personne_id=:personneId";

            $stmt = $db->prepare($sql);

            $stmt->bindParam("nom", $this->nomComplet);
            $stmt->bindParam("personneId", $personneId);

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
            UPDATE tbl_personnes
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


    public function exist_party($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where party_code=:partyCode");
            $stmt->bindParam("partyCode", $partyCode);
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

    public function exist_pos($partyCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where pos_id=:partyCode");
            $stmt->bindParam("partyCode", $partyCode);
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

    public function exist_pers($personneId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_operations where personne_id=:personneId");
            $stmt->bindParam("personneId", $personneId);
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

    public function nb_format($val)
    {
        return number_format($val, 1, '.', ',');
    }

    public function select_code($role)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT count(personne_id)+1 as last_code FROM tbl_personnes WHERE role=:role");
            $stmt->bindParam("role", $role);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['last_code'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
