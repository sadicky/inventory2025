<?php
require_once("connexion.php");

class Category
{
    public $bank;

    //                

    //ajouter un article
    public function setCategory($category_name, $category_parent, $is_sale, $status)
    {
        $db = getConnection();
        $add1 = $db->prepare("INSERT INTO tbl_category(category_name,category_parent,is_sale,statut) VALUES (?,?,?,?)");
        $addline1 = $add1->execute(array($category_name, $category_parent, $is_sale, $status)) or die(print_r($add1->errorInfo()));

        return $addline1;
    }

    public function select_all_srch_cat($keyword)
    {
        $db = getConnection();
        try {
            $stmt = $db->prepare("SELECT * FROM tbl_category where category_name like '%" . $keyword . "%' order by category_name");
            $stmt->execute();
            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $ex) {
            return $ex;
        }
    }


    public function getCategories()
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_category order by category_id asc");
        $statement->execute();
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getCategoryParent($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT * FROM tbl_category where category_parent=? and is_sale='Oui'  order by category_name");
        $statement->execute(array($id));
        $tbP = array();
        while ($data =  $statement->fetchObject()) {
            $tbP[] = $data;
        }
        return $tbP;
    }

    public function getCategoryId($id)
    {
        $db = getConnection();
        $statement = $db->prepare("SELECT *  FROM tbl_category WHERE category_id = ?");
        $statement->execute([$id]);
        $tbP = $statement->fetchObject();
        return $tbP;
    }
}
