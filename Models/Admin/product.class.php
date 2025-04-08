<?php
require_once("connexion.php");
require_once("branches.class.php");
class Product
{
    //   
    private $prodId;
    private $categoryId;
    private $prodName;
    private $prodEquiv;
    private $isStock;
    private $qtMin;
    private $untMes;
    private $prodCode;
    private $lastUpdate;
    private $isTva;
    private $isLot;
    private $isExp;
    private $isFab;
    private $isPrio;
    private $prodState;

    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    }
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
    public function setProdId($prodId)
    {
        $this->prodId = (int)$prodId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = (int)$categoryId;
    }

    public function setProdName($prodName)
    {
        $this->prodName = (string)$prodName;
    }

    public function setProdEquiv($prodEquiv)
    {
        $this->prodEquiv = $prodEquiv;
    }


    public function setIsTva($isTva)
    {
        $this->isTva = $isTva;
    }

    public function setIsLot($isLot)
    {
        $this->isLot = $isLot;
    }

    public function setIsExp($isExp)
    {
        $this->isExp = $isExp;
    }

    public function setIsFab($isFab)
    {
        $this->isFab = $isFab;
    }

    public function setIsPrio($isPrio)
    {
        $this->isPrio = $isPrio;
    }

    public function setUntMes($untMes)
    {
        $this->untMes = $untMes;
    }

    public function setIsStock($isStock)
    {
        $this->isStock = $isStock;
    }

    public function setQtMin($qtMin)
    {
        $this->qtMin = $qtMin;
    }


    public function setProdCode($prodCode)
    {
        $this->prodCode = (string)$prodCode;
    }


    public function getProdId()
    {
        return $this->prodId;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getProdName()
    {
        return $this->prodName;
    }

    public function getProdEquiv()
    {
        return $this->prodEquiv;
    }

    public function getIsTva()
    {
        return $this->isTva;
    }

    public function getIsLot()
    {
        return $this->isLot;
    }

    public function getIsExp()
    {
        return $this->isExp;
    }

    public function getIsFab()
    {
        return $this->isFab;
    }

    public function getIsPrio()
    {
        return $this->isPrio;
    }

    public function getUntMes()
    {
        return $this->untMes;
    }

    public function getIsStock()
    {
        return $this->isStock;
    }

    public function getQtMin()
    {
        return $this->qtMin;
    }

    public function getProdCode()
    {
        return $this->prodCode;
    }

    public function getProdState()
    {
        return $this->prodState;
    }

    public function getTableName()
    {
        return "tbl_products";
    }


    //ajouter un article
    public function setProduct($category, $details, $price, $pa, $product, $cond, $qt_min)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_products (category_id,details,product_price,product_name,unt_mes,qt_min) VALUES (?,?,?,?,?,?)");
        $addline1 = $add1->execute(array($category, $details, $pa, $product, $cond, $qt_min)) or die(print_r($add1->errorInfo()));

        $product_id = $db->lastInsertId();

        $branches = new Branches();
        $branche = $branches->getBranches();

        $N = count($branche);
        for ($i = 1; $i <= $N; $i++) {
            $this->setProductPrice($product_id, $price, $i);
        }
        // for ($i = 1; $i <= $N; $i++) {
        //     if ($i == 1 or $i == 2)
        //         $this->setProductPrice($product_id, $price, $i);
        //     else
        //         $this->setProductPrice($product_id, 0, $i);
        // }


        return $addline1;
    }
    public function updateProduct($category, $details, $price, $product, $cond, $qt_min, $product_id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_products SET category_id=? ,details=?, product_price=?, product_name=?, unt_mes=?, qt_min=?
         WHERE product_id=?");

        $ok = $update->execute(array($category, $details, $price, $product, $cond, $qt_min, $product_id)) or die(print_r($update->errorInfo()));

        return $ok;
    }
    public function setProductPrice($product, $price, $branche)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_prices (product_id,price,branche_id) VALUES (?,?,?)");
        $addline1 = $add1->execute(array($product, $price, $branche)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }


    public function getProducts()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }
    public function getProductName($name)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products where product_name = ?");
        $statement->execute([$name]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }
    public function getProductId($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products as p,tbl_category as c 
        where p.category_id = c.category_id and p.product_id = ?");
        $statement->execute([$id]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }
    public function productNameExist($name)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products where product_name = ?");
        $statement->execute([$name]);
        $stat = $statement->rowCount();
        return $stat;
    }
    public function searchAllProducts($let)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products as p join tbl_category as c on 
        p.category_id=c.category_id  where  product_name like '" . $let . "%' order by product_name");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function searchAllDetails($let)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_products as p join tbl_category as c on 
        p.category_id=c.category_id  WHERE p.details like '%" . $let . "%' order by p.details");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }


    public function select_all_date($last)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_products where date(last_update)=? order by last_update desc");
            $stmt->bindValue(1, $last);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function exist_prod($prodId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_details_operation where product_id=:prodId");
            $stmt->bindParam("prodId", $prodId);
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


    public function select_all_cat($cat)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT  * FROM tbl_category join tbl_products on tbl_category.category_id=tbl_products.category_id where tbl_category.category_id=:cat order by product_name");
            $stmt->bindParam('cat', $cat);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_cat_alpha($cat, $alpha)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_products.* FROM tbl_products where tbl_products.category_id=:cat and product_name like '" . $alpha . "%' order by prod_name");
            $stmt->bindParam('cat', $cat);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function selectProductPrices($prodId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_prices as pr,tbl_products as p,tbl_branches as b
                         WHERE pr.branche_id = b.branche_id and pr.product_id=p.product_id and p.product_id=?");
        $stmt->execute([$prodId]);
        $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $stat;
    }

    public function selectProductPrice2($prodId)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT b.branche as branche, pr.price as montant, pr.price_last_update FROM tbl_prices as pr,tbl_products as p,tbl_branches as b
                         WHERE pr.branche_id = b.branche_id and pr.product_id=p.product_id and p.product_id=?");
        $stmt->execute([$prodId]);
        $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $stat;
    }


    public function selectPrice($price)
    {
        $db = getConnection();
        $stmt = $db->prepare("SELECT * FROM tbl_prices as pr,tbl_products as p,tbl_branches as b
                         WHERE pr.branche_id = b.branche_id and pr.product_id=p.product_id and pr.price_id=?");
        $stmt->execute([$price]);
        $stat = $stmt->fetch(PDO::FETCH_OBJ);
        return $stat;
    }

    public function newPrice($price, $date, $branche, $product_id)
    {
        $db = getConnection();
        $update = $db->prepare("UPDATE tbl_prices SET price=?,price_last_update=? WHERE branche_id=? and product_id=?");

        $ok = $update->execute(array($price, $date, $branche, $product_id)) or die(print_r($update->errorInfo()));

        return $ok;
    }
    public function select_all_srch_prod($let)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT tbl_products.*,tbl_category.* FROM tbl_products join tbl_category on tbl_products.category_id=tbl_category.category_id  where  product_name like '" . $let . "%' order by product_name");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function delete($prodId)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_products WHERE product_id=:id";
            $sql1 = "DELETE FROM tbl_stocks WHERE product_id=:id";
            $stmt = $db->prepare($sql);
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("id", $prodId);
            $stmt->bindParam("id", $prodId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_crt_tar($prod, $pos)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as quantity, tbl_products.product_id,product_name,details FROM tbl_products join tbl_stocks on tbl_products.product_id=tbl_stocks.product_id 
where quantity > 0 and pos_id='" . $pos . "' and details like '%" . $prod . "%' GROUP BY tbl_products.product_id order by product_name limit 0,10");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_crt_tar_($prod, $pos)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as quantity, tbl_products.product_id,product_name,details,category_name 
            FROM tbl_products join tbl_stocks on tbl_products.product_id=tbl_stocks.product_id join tbl_category c on c.category_id =  tbl_products.category_id
where quantity > 0 and pos_id='" . $pos . "' and details like '%" . $prod . "%' GROUP BY tbl_products.product_id order by product_name limit 0,10");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_crt_tar_0($prod, $pos)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as quantity, tbl_products.product_id,product_name FROM tbl_products join tbl_stocks on tbl_products.product_id=tbl_stocks.product_id 
where quantity > 0 and pos_id='" . $pos . "' and tbl_products.product_id ='" . $prod . "'");
            $stmt->execute();
            $stat = $stmt->fetch(PDO::FETCH_OBJ);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
