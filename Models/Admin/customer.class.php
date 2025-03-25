<?php
include_once("connexion.php");
class Customer
{

    private $customerId;
    private $customerName;
    private $customerCode;
    private $personneId;
    private $actif;
    private $customerAdr;
    private $customerNum;
    private $customerTva;
    private $customerCat;
    private $customerType;
    private $customerExp;
    private $customerPercent;
    private $customerServ;
    private $customerMb;
    private $customerDisc;


    public function setCustomerId($customerId)
    {
        $this->customerId = (int)$customerId;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
    }

    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;
    }

    public function setCustomerCode($customerCode)
    {
        $this->customerCode = $customerCode;
    }

    public function setCustomerNum($customerNum)
    {
        $this->customerNum = $customerNum;
    }

    public function setCustomerTva($customerTva)
    {
        $this->customerTva = $customerTva;
    }

    public function setPersonneId($personneId)
    {
        $this->personneId = (int)$personneId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }
    public function getActif()
    {
        return $this->actif;
    }
    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getCustomerCode()
    {
        return $this->customerCode;
    }

    public function getCustomerNum()
    {
        return $this->customerNum;
    }

    public function getCustomerCat()
    {
        return $this->customerCat;
    }

    public function getCustomerType()
    {
        return $this->customerType;
    }

    public function getCustomerExp()
    {
        return $this->customerExp;
    }

    public function getCustomerPercent()
    {
        return $this->customerPercent;
    }

    public function getCustomerTva()
    {
        return $this->customerTva;
    }

    public function getCustomerAdr()
    {
        return $this->customerAdr;
    }

    public function getCustomerServ()
    {
        return $this->customerServ;
    }

    public function getCustomerMb()
    {
        return $this->customerMb;
    }

    public function getCustomerDisc()
    {
        return $this->customerDisc;
    }

    public function getPersonneId()
    {
        return $this->personneId;
    }


    public function select($personneId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_customers WHERE  personne_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function selectId($personneId)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_customers WHERE  customer_id=:personne_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("personne_id", $personneId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();

            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_code($customerCode)
    {
        $db = getConnection();

        try {
            $sql =  "SELECT * FROM tbl_customers WHERE customer_code=:customerCode";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("customerCode", $customerCode);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function setCustomer($nom, $contact, $adresse, $credit_limit, $customer_cat, $status, $id)
    {

        $db = getConnection();
        $sqla = "INSERT INTO tbl_customers(customer_name,customer_num,customer_adr,credit_limit,customer_cat,actif,personne_id) 
        values(?,?,?,?,?,?,?)";
        $stmta = $db->prepare($sqla);
        $stmta->execute([$nom, $contact, $adresse, $credit_limit, $customer_cat, $status, $id]);
        return $stmta;
    }

    public function update_one($Id, $val_id, $val_n, $val_f)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_customers SET " . $val_n . " =:val_f  WHERE " . $val_id . "=:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("val_f", $val_f);
            $stmt->bindParam("id", $Id);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($nom, $cust_num, $adresse, $credit_limit, $cust_cat, $status, $Id)
    {
        $db = getConnection();
        try {
            $sql = "UPDATE tbl_customers SET customer_name=?,customer_num=?,customer_adr=?,
            credit_limit=?,customer_cat=?,actif=?  WHERE personne_id=?";
            $stmt = $db->prepare($sql);
            $ok = $stmt->execute(array($nom, $cust_num, $adresse, $credit_limit, $cust_cat, $status, $Id)) or die(print_r($stmt->errorInfo()));

            return $ok;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function exist_code($customerCode)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_customers where customer_code=:customerCode");
            $stmt->bindParam("customerCode", $customerCode);
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

    public function select_exist_num($customerNum)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_customers where customer_num=:customerNum");
            $stmt->bindParam("customerNum", $customerNum);
            $stmt->execute();
            $stat = $stmt->rowCount();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_cat($customerCat)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_customers WHERE customer_cat=:customerCat");
            $stmt->bindParam("customerCat", $customerCat);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_customers as c, tbl_personnes as p WHERE c.personne_id = p.personne_id ");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
