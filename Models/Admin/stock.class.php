<?php
require_once("connexion.php");

class Stock
{

    private $stockId;
    private $prodId;
    private $quantity;
    private $updateDate;
    private $posId;
    private $lot;
    private $dateExp;
    private $dateFab;

    public function setStockId($stockId)
    {
        $this->stockId = $stockId;
    }

    public function getStockId()
    {
        return $this->stockId;
    }

    public function setProdId($prodId)
    {
        $this->prodId = (int)$prodId;
    }

    public function setPosId($posId)
    {
        $this->posId = (int)$posId;
    }

    public function setDateExp($dateExp)
    {
        $this->dateExp = $dateExp;
    }

    public function setDateFab($dateFab)
    {
        $this->dateFab = $dateFab;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function setUpdateDate($updateDate)
    {
        $this->updateDate = (string)$updateDate;
    }

    public function setLot($lot)
    {
        $this->lot = $lot;
    }

    public function getProdId()
    {
        return $this->prodId;
    }

    public function getPosId()
    {
        return $this->posId;
    }

    public function getDateExp()
    {
        return $this->dateExp;
    }

    public function getDateFab()
    {
        return $this->dateFab;
    }

    public function getLot()
    {
        return $this->lot;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    public function getTableName()
    {
        return "tbl_stocks";
    }




    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        //unset($this);
    }

    public function select($stockId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_stocks WHERE stock_id=:stockId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("stockId", $stockId);

            $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_by_lot($prodId, $lot, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_stocks WHERE product_id=:prodId and pos_id=:posId and lot=:lot";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();

            return  $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_by_prod($prodId, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_stocks WHERE product_id=:prodId and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();

            $rowObject = $stmt->fetchObject();
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_by_product($prodId, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM tbl_stocks WHERE product_id=:prodId and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            return $rowObject;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_sum_qt($prodId, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT sum(quantity) as qt FROM stock WHERE product_id=:prodId and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['qt'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_lot($lot)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM stock WHERE lot=:lot";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("lot", $lot);
            $stmt->execute();

            $rowObject = $stmt->fetch(PDO::FETCH_OBJ);
            @$this->stockId = $rowObject->stock_id;
            @$this->prodId = $rowObject->product_id;
            @$this->posId = $rowObject->pos_id;
            @$this->quantity = $rowObject->quantity;
            @$this->dateExp = $rowObject->date_exp;
            @$this->lot = $rowObject->lot;

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function qt_tot($prodId, $posId, $dateExp)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT sum(quantity) as qt_tot FROM stock WHERE product_id=:prodId and pos_id=:posId and pack_id=:dateExp group by product_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("dateExp", $dateExp);
            $stmt->execute();
            $res = $stmt->fetch();
            return $res['qt_tot'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_nb_under_min($posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * from tbl_products join tbl_stocks on tbl_products.product_id=tbl_stocks.product_id WHERE quantity<=qt_min and quantity>0 and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_nb_zero($posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT *,sum(quantity) as tot from tbl_stocks right join tbl_products on tbl_stocks.product_id=tbl_products.product_id where pos_id=:posId group by tbl_stocks.product_id having tot=0";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            //$stmt->bindParam("seuil",$seuil);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_under_min($posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * from tbl_products join tbl_stocks on tbl_products.product_id=tbl_stocks.product_id WHERE quantity<=qt_min and quantity>0 and pos_id=:posId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            //$stmt->bindParam("seuil",$seuil);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_zero($posId)
    {
        $db = getConnection();
        try {
            $sql = "SELECT *,sum(quantity) as tot from tbl_stocks right join tbl_products on tbl_stocks.product_id=tbl_products.product_id where pos_id=:posId group by tbl_stocks.product_id having tot=0";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    /**/
    public function select_all($posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT stock.*,products.* FROM stock join products on stock.product_id=products.product_id WHERE pos_id=:posId");
            $stmt->bindParam('posId', $posId);
            //$stmt->bindParam('dateExp',$dateExp);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_0($posId, $dateExp)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as qt_tot,products.* FROM stock join products on stock.product_id=products.product_id WHERE pos_id=:posId and pack_id=:dateExp group by stock.product_id having qt_tot<=0");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('dateExp', $dateExp);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_cat($posId, $catId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT stock.*,stock.product_id FROM stock join products on stock.product_id=products.product_id
  WHERE pos_id=:posId  and category_id=:catId and quantity>0");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('catId', $catId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_gen($posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt,tbl_stocks.product_id 
            FROM tbl_stocks, tbl_products where tbl_stocks.product_id=tbl_products.product_id and pos_id=:posId  group by tbl_stocks.product_id");
            $stmt->bindParam('posId', $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_gen_endom($posId, $supId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(qty) as tot_qt,tbl_endom.product_id, tbl_suppliers.supplier_name
            FROM tbl_endom, tbl_products,tbl_suppliers where tbl_endom.product_id=tbl_products.product_id and pos_id=:posId and tbl_suppliers.supplier_id = tbl_endom.supplier_id  and tbl_endom.supplier_id=:supId  group by tbl_endom.product_id");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('supId', $supId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_cat_gen_endom($posId, $supId, $catId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(tbl_endom.qty) as tot_qt,tbl_endom.product_id, tbl_suppliers.supplier_name FROM tbl_endom, tbl_products,tbl_suppliers 
            where tbl_suppliers.supplier_id = tbl_endom.supplier_id and  tbl_endom.product_id=tbl_products.product_id and pos_id=:posId and supplier_id=:supId  and category_id=:catId group by tbl_endom.product_id");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('catId', $catId);
            $stmt->bindParam('supId', $supId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
    public function select_all_cat_gen($posId, $catId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(tbl_stocks.quantity) as tot_qt,tbl_stocks.product_id FROM tbl_stocks, tbl_products 
            where tbl_stocks.product_id=tbl_products.product_id and pos_id=:posId and category_id=:catId group by tbl_stocks.product_id");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('catId', $catId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    } 

    public function select_all_lot($srch)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_stocks WHERE lot like '%" . $srch . "%' order by lot");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_prod($prodId, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM stock WHERE product_id=:prodId and pos_id=:posId order by date_exp");
            $stmt->bindParam('prodId', $prodId);
            $stmt->bindParam('posId', $posId);
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function qt_stock_lot($posId, $prodId, $lot, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.party_type='stock_in' and pos_id=:posId and details_operation.lot=:lot and  details_operation.product_id=:prodId and id_per=:id_per  group by product_id");
            $stmt->bindParam("lot", $lot);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("id_per", $per);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.party_type='stock_out' and pos_id=:posId and details_operation.lot=:lot and  details_operation.product_id=:prodId and id_per=:id_per  group by product_id");
            $stmt->bindParam("lot", $lot);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("id_per", $per);
            $stmt->execute();
            $out = $stmt->fetch();


            $qt = $in['tot_qt'] - $out['tot_qt'];

            return $qt;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function qt_stock($posId, $prodId, $per)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.party_type='stock_in' and pos_id=:posId and  details_operation.product_id=:prodId and id_per=:id_per  group by product_id");
            //$stmt->bindParam("lot",$lot);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("id_per", $per);
            $stmt->execute();
            $in = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.party_type='stock_out' and pos_id=:posId  and  details_operation.product_id=:prodId and id_per=:id_per  group by product_id");
            //$stmt->bindParam("lot",$lot);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("id_per", $per);
            $stmt->execute();
            $out = $stmt->fetch();


            $qt = $in['tot_qt'] - $out['tot_qt'];

            return $qt;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function stock_syn_qt($prodId, $posId, $idPer)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Approvisionnement' and pos_id=:posId and details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);

            $stmt->execute();
            $app = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Inventaire' and pos_id=:posId  and  details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            $inv = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Transfert produit' and party_code=:posId  and  details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            $trans_ent = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Transfert produit' and pos_id=:posId  and  details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            $trans_sort = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Sortie' and pos_id=:posId  and  details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            $sort = $stmt->fetch();

            $stmt = $db->prepare("SELECT sum(quantity) as tot_qt FROM operation join details_operation on operation.op_id=details_operation.op_id where operation.op_type='Vente' and pos_id=:posId  and  details_operation.product_id=:prodId and id_per=:idPer  group by product_id");

            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("idPer", $idPer);
            $stmt->execute();
            $vente = $stmt->fetch();

            $qt = ($app['tot_qt'] + $inv['tot_qt'] + $trans_ent['tot_qt']) - ($sort['tot_qt'] + $vente['tot_qt'] + $trans_sort['tot_qt']);

            return $qt;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_qt($stockId, $qt)
    {

        $db = getConnection();
        try {
            $sql = "UPDATE tbl_stocks SET quantity=:qt WHERE stock_id=:stockId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("qt", $qt);
            $stmt->bindParam("stockId", $stockId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function update($prodId, $qt)
    {

        $db = getConnection();
        try {
            $sql = "UPDATE tbl_stocks SET quantity=:qt WHERE product_id=:stockId";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("qt", $qt);
            $stmt->bindParam("stockId", $prodId);

            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function delete($product_id)
    {
        $db = getConnection();
        try {
            $sql = "DELETE FROM tbl_stocks WHERE product_id:id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $prodId);
            return (bool)$stmt->execute();
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function insert($prodId, $quantity, $posId)
    {
        $db = getConnection();

        // $this->prodId = $prodId;
        // $this->quantity = $quantity;
        // $this->posId = $posId;
        try {
            $sql = "INSERT INTO tbl_stocks (product_id,quantity,pos_id) VALUES(:prodId,:quantity,:posId)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("prodId", $prodId);
            $stmt->bindParam("quantity", $quantity);
            $stmt->bindParam("posId", $posId);

            $stmt->execute();
            return $db->lastInsertId();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function update_one($Id, $val_id, $val_n, $val_f)
    {


        $db = getConnection();
        try {
            $sql = "
            UPDATE tbl_stocks
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

    public function existstock_by_lot($prodId, $posId, $lot)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from tbl_stocks where pos_id=:posId and lot=:lot and product_id=:prodId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("lot", $lot);
            $stmt->bindParam("prodId", $prodId);

            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function existstock_by_prod($prodId, $posId)
    {
        $db = getConnection();
        try {
            $sql = "SELECT count(*) from tbl_stocks where pos_id=:posId and product_id=:prodId";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("posId", $posId);
            $stmt->bindParam("prodId", $prodId);

            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function updateCurrent()
    {
        // if ($this->prodId != "") {
        //     return $this->update($this->prodId);
        // } else {
        //     return false;
        // }
    }

    public function select_nb()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT count(*) as nb FROM tbl_stocks WHERE quantity<>'0'");
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['nb'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_stk_0()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT count(*) as nb FROM tbl_stocks WHERE quantity='0'");
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['nb'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_pat()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity*pa) as pat FROM tbl_stocks");
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['pat'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_pvt()
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT sum(quantity*pv) as pvt FROM tbl_stocks");
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat['pvt'];
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_exp_prod_stk($n_days)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT stock.*,(to_days(date_exp) - to_days(now())) as rem_days  FROM `tbl_stocks` WHERE quantity<>0 and (to_days(date_exp) - to_days(now()))<=:n_days";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("n_days", $n_days);
            //$stmt->bindParam("qt",$qt);
            //$stmt->bindParam("posId",$posId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }



    public function get_stock($prodId, $posId)
    {
        // $prod = new BeanProducts();
        // $prod->select($prodId);

        // if ($prod->getIsLot() == '1') {
        //     $this->select_by_lot($prodId, $this->getLot(), $posId);
        // } else {
        //     $this->select_by_prod($prodId, $posId);
        // }
    }

    public function select_nb_exp_prod_stk($d_min, $d_max, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT * FROM `tbl_stocks` WHERE pos_id=:posId and quantity>0 and (to_days(date_exp) - to_days(now()))<=:d_max and (to_days(date_exp) - to_days(now()))>:d_min";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("d_min", $d_min);
            $stmt->bindParam("d_max", $d_max);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_all_exp_prod_stk($d_min, $d_max, $posId)
    {
        $db = getConnection();
        try {
            $sql =  "SELECT tbl_stocks.*, (to_days(date_exp) - to_days(now())) as r_day FROM `tbl_stocks` WHERE pos_id=:posId and  quantity>0 and (to_days(date_exp) - to_days(now()))<=:d_max and (to_days(date_exp) - to_days(now()))>:d_min";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("d_min", $d_min);
            $stmt->bindParam("d_max", $d_max);
            $stmt->bindParam("posId", $posId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function select_min_exp($prodId, $posId)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT min(date_exp) as Exp,lot FROM tbl_stocks where pos_id=:posId and product_id=:prodId");
            $stmt->bindParam('posId', $posId);
            $stmt->bindParam('prodId', $prodId);
            $stmt->execute();
            $stat = $stmt->fetch();
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }

    public function reset()
    {
        $db = getConnection();
        try {
            $sql =  "
                SET FOREIGN_KEY_CHECKS = 0; 
                TRUNCATE table tbl_operations; 
                TRUNCATE table tbl_details_operation;
                TRUNCATE table tbl_achats; 
                TRUNCATE table tbl_ventes;
                TRUNCATE table tbl_sortie;
                TRUNCATE table tbl_transactions;
                TRUNCATE table tbl_paiements;
                TRUNCATE table tbl_stocks;
                TRUNCATE table tbl_journal;
                SET FOREIGN_KEY_CHECKS = 1";

            $stmt = $db->prepare($sql);
            $stmt->execute();
            return true;
        } catch (PDOException $ex) {
            return $ex;
        }
    }
}
