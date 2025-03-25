<?php
// Connexion aux bases
$localDb = new PDO("mysql:host=localhost;dbname=db_marco_pharma", "root", "", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$onlineDb = new PDO("mysql:host=web58.lws-hosting.com;dbname=c2533323c_marcopharma", "c2533323c_marcopharma", "2bMmFf6gy9vBA3F", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

try {
    // Récupérer la dernière synchronisation
    $lastSyncQuery = $localDb->query("SELECT last_sync FROM tbl_sync_status WHERE id=1");
    $lastSync = $lastSyncQuery->fetchColumn();

    // Récupérer toutes les tables de la base locale
    $tables = $localDb->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($tables as $table) {
        echo "Vérification de la table: $table...\n";

        // Vérifier si la table a une colonne "updated_at"
        $columnsQuery = $localDb->query("SHOW COLUMNS FROM `$table` LIKE 'updated_at'");
        if ($columnsQuery->rowCount() == 0) {
            echo "Table $table ignorée (pas de updated_at)\n";
            continue;
        }

        // 🔹 Synchronisation des ajouts/modifications
        $stmt = $localDb->prepare("SELECT * FROM `$table` WHERE updated_at > ?");
        $stmt->execute([$lastSync]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            echo "Synchronisation des ajouts/modifications de la table $table...\n";
            $columns = implode(',', array_keys($data[0]));
            $placeholders = implode(',', array_fill(0, count($data[0]), '?'));

            $insertQuery = $onlineDb->prepare("REPLACE INTO `$table` ($columns) VALUES ($placeholders)");

            foreach ($data as $row) {
                $insertQuery->execute(array_values($row));
            }
        } else {
            echo "Aucune mise à jour pour $table.\n";
        }

        // 🔹 Gestion des suppressions (si la table a deleted_at)
        $deletedQuery = $localDb->query("SHOW COLUMNS FROM `$table` LIKE 'deleted_at'");
        if ($deletedQuery->rowCount() > 0) {
            $stmtDel = $localDb->prepare("SELECT id FROM `$table` WHERE deleted_at IS NOT NULL AND deleted_at > ?");
            $stmtDel->execute([$lastSync]);
            $deletedRows = $stmtDel->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($deletedRows)) {
                echo "Suppression des enregistrements de la table $table...\n";
                $placeholders = implode(',', array_fill(0, count($deletedRows), '?'));
                $deleteQuery = $onlineDb->prepare("DELETE FROM `$table` WHERE id IN ($placeholders)");
                $deleteQuery->execute($deletedRows);
            }
        }
    }

    // 🔹 Mettre à jour la dernière synchronisation
    $localDb->exec("UPDATE tbl_sync_status SET last_sync = NOW() WHERE id=1");

    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
