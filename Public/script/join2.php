<?php
        require_once '../../Models/Admin/connexion.php';
        $db = getConnection();

        if (isset($_POST['pos_id'])&& !empty($_POST['pos_id'])) {
        	$query = $db->prepare("SELECT * FROM tbl_caisses as c,tbl_branches as b 
			where b.branche_id = c.branche_id and b.branche_id= ?");
            $query->execute(array($_POST['pos_id']));
        	$rc = $query->rowCount();
        	if ($rc>0) {
        		while ($value=$query->fetchObject()) {
        			echo "<option value=".$value->caisse_id.">".$value->caisse_name."(".$value->branche.")</option>";
               		}
        		# code...
        	}
        	else{

        		echo "<option> non disponible</option>";
        	}
       }
?>