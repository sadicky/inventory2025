<?php
// Connexion aux bases
	$localDb = new PDO("mysql:host=localhost;dbname=db_marco_pharma", "root", "");
    

try {
	$onlineDb=new PDO('mysql:host=web58.lws-hosting.com;dbname=c2533323c_marcopharma','c2533323c_marcopharma','2bMmFf6gy9vBA3F');    
    return json_encode(["message"=>"Connected"]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    // exit;
}
	
try {
   
    // Récupérer la dernière synchronisation
    $lastSyncQuery = $localDb->query("SELECT last_sync FROM tbl_sync_status WHERE id=1");
    $lastSync = $lastSyncQuery->fetchColumn();

    // var_dump($lastSync);

    function getPrimaryKey($pdo, $table) {
    $query = $pdo->prepare("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['Column_name'] : null;
}

    // Récupérer toutes les tables
    $tables = $localDb->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
       // echo "Vérification de la table: $table...\n";

          // Trouver la clé primaire
        $primaryKey = getPrimaryKey($localDb, $table);
        if (!$primaryKey) {
            echo "⚠ Aucune clé primaire trouvée pour $table, table ignorée.\n";
            continue;
        }

        // Vérifier si la table a "updated_at"
        $columnsQuery = $localDb->query("SHOW COLUMNS FROM `$table` LIKE 'updated_at'");
        if ($columnsQuery->rowCount() == 0) continue;

        // 🔹 Synchronisation des ajouts et modifications
        $stmt = $localDb->prepare("SELECT * FROM `$table` WHERE updated_at > ?");
        $stmt->execute([$lastSync]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            echo "Mise à jour de la table $table...\n";
            $columns = implode(',', array_keys($data[0]));
            $placeholders = implode(',', array_fill(0, count($data[0]), '?'));

            $insertQuery = $onlineDb->prepare("REPLACE INTO `$table` ($columns) VALUES ($placeholders)");
            $logQuery = $localDb->prepare("INSERT INTO tbl_sync_logs (table_name, action, record_id) VALUES (?, ?, ?)");

            foreach ($data as $row) {
                $insertQuery->execute(array_values($row));
                $logQuery->execute([$table, 'UPDATE', $row[$primaryKey]]);
            }
        }

        // 🔹 Gestion des suppressions (si la table a "deleted_at")
        $deletedQuery = $localDb->query("SHOW COLUMNS FROM `$table` LIKE 'deleted_at'");
        if ($deletedQuery->rowCount() > 0) {
            $stmtDel = $localDb->prepare("SELECT $primaryKey FROM `$table` WHERE deleted_at IS NOT NULL AND deleted_at > ?");
            $stmtDel->execute([$lastSync]);
            $deletedRows = $stmtDel->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($deletedRows)) {
                echo "Suppression de la table $table...\n";
                $placeholders = implode(',', array_fill(0, count($deletedRows), '?'));
                $deleteQuery = $onlineDb->prepare("DELETE FROM `$table` WHERE $primaryKey IN ($placeholders)");
                $logQuery = $localDb->prepare("INSERT INTO tbl_sync_logs (table_name, action, record_id) VALUES (?, ?, ?)");

                foreach ($deletedRows as $id) {
                    $deleteQuery->execute([$id]);
                    $logQuery->execute([$table, 'DELETE', $id]);
                }
            }
        }
    }

    // 🔹 Mise à jour de la dernière synchronisation
    $localDb->exec("UPDATE tbl_sync_status SET last_sync = NOW() WHERE id=1");

    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    echo json_encode(["erreur" => $e->getMessage()]);
}
?>
