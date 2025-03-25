<?php
include_once("connexion.php");

class Config 
{
    
    public function getTableName()
    {
        return "tbl_config";
    }

    public function select_all()
    {
     $db = getConnection();
    try
    {
        $stmt = $db->prepare("SELECT * FROM config");
        $stmt->execute();
        $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stat;
    }
    catch(PDOException $ex)
    {
        return $ex;
    }
    }

    public function getSociety()
    {
     $db = getConnection();
    try
    {
        $stmt = $db->prepare("SELECT * FROM tbl_society");
        $stmt->execute();
        $stat = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stat;
    }
    catch(PDOException $ex)
    {
        return $ex;
    }
    }

    public function select($cfgId)
    {
     $db = getConnection();
    try
    {
        $stmt = $db->prepare("SELECT * FROM tbl_config where cfg_id=?");
        $stmt->bindValue(1,$cfgId);
        $stmt->execute();
        $stat = $stmt->fetch();
        return $stat;
    }
    catch(PDOException $ex)
    {
        return $ex;
    }
    }

    public function updateSoc($tp_type,$tp_name,$tp_tin,$tp_trade_number,$tp_postal_number,$tp_phone_number, $tp_address_province,$tp_address_commune,$tp_address_quartier,$tp_address_avenue,$tp_address_rue,$tp_address_number,$vat_taxpayer,$ct_taxpayer,$tl_taxpayer,$tp_fiscal_center,$tp_activity_sector,$tp_legal_form,$tp_id)
    {
        $db =getConnection();
            try
            {
        $sql ="UPDATE `tbl_society` SET `tp_type`=?,`tp_name`=?,`tp_tin`=?,`tp_trade_number`=?,`tp_postal_number`=?,`tp_phone_number`=?,`tp_address_province`=?,`tp_address_commune`=?,`tp_address_quartier`=?,`tp_address_avenue`=?,`tp_address_rue`=?,`tp_address_number`=?,`vat_taxpayer`=?,`ct_taxpayer`=?,`tl_taxpayer`=?,`tp_fiscal_center`=?,`tp_activity_sector`=?,`tp_legal_form`=?  WHERE tp_id=?";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(1,$tp_type);
        $stmt->bindValue(2,$tp_name);
        $stmt->bindValue(3,$tp_tin);
        $stmt->bindValue(4,$tp_trade_number);
        $stmt->bindValue(5,$tp_postal_number);
        $stmt->bindValue(6,$tp_phone_number);
        $stmt->bindValue(7,$tp_address_province);
        $stmt->bindValue(8,$tp_address_commune);
        $stmt->bindValue(9,$tp_address_quartier);
        $stmt->bindValue(10,$tp_address_avenue);
        $stmt->bindValue(11,$tp_address_rue);
        $stmt->bindValue(12,$tp_address_number);
        $stmt->bindValue(13,$vat_taxpayer);
        $stmt->bindValue(14,$ct_taxpayer);
        $stmt->bindValue(15,$tl_taxpayer);
        $stmt->bindValue(16,$tp_fiscal_center);
        $stmt->bindValue(17,$tp_activity_sector);
        $stmt->bindValue(18,$tp_legal_form);
        $stmt->bindValue(19,$tp_id);

        return (bool)$stmt->execute();

            }
        catch(PDOException $ex)
            {
                 return $ex;
            }
    }

    public function update_one_soc($Id,$val_id,$val_n,$val_f)
       {


        $db =getConnection();
            try
            {
            $sql ="UPDATE tbl_society SET
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

    public function update_one($Id,$val_id,$val_n,$val_f)
       {


         $db = getConnection();
            try
            {
            $sql =" UPDATE tbl_config SET ".$val_n." =:val_f WHERE ".$val_id."=:id";

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
}
?>
