<?php

include '../database/config.php';

// Check if a file is uploaded
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
    // Check if the uploaded file is a CSV
    $fileType = mime_content_type($_FILES['fileToUpload']['tmp_name']);
    if ($fileType != 'text/csv') {
        // Not a CSV file, redirect with error
        header("Location: ../admin/return-unit.php?error=4");
        exit();
    }

    // Open and read the CSV file
    if (($handle = fopen($_FILES['fileToUpload']['tmp_name'], 'r')) !== false) {
        // Skip the first line if it contains headers
        $firstRow = true;
        $units = [];

        // Loop through the rows of the CSV file
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if ($firstRow) {
                // Skip header row
                $firstRow = false;
                continue;
            }

            //CSV columns: 0 = nomor_seri, 1 = kondisi, 2 = id_gudang, 3 = komentar
            $nomor_seri = trim($data[0]);
            $kondisi = trim($data[1]);
            $id_gudang = trim($data[2]);
            $komentar = trim($data[3]);

            // Redirect if 'nomor_seri' is empty
            if (empty($nomor_seri)) {
                fclose($handle);
                header("Location: ../admin/return-unit.php?alert=1");
                exit();
            }

            // Temporarily store the data
            $units[] = [
                'serial_number' => $nomor_seri,
                'kondisi' => $kondisi,
                'id_gudang' => $id_gudang,
                'komentar' => $komentar,
            ];
        }

        fclose($handle);

        
        foreach ($units as $unit) {
            // Check if id_gudang exists in gudang table
            $checkQuery = "SELECT COUNT(*) FROM gudang WHERE id_gudang = :id_gudang";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([':id_gudang' => $unit['id_gudang']]);
            $exists = $checkStmt->fetchColumn();

            if ($exists == 0) {
                // id_gudang does not exist, handle the error
                header("Location: ../admin/return-unit.php?alert=2");
                exit();
            }
        
            // Check if id_unit exist
            $checkUnit = "SELECT COUNT(*) FROM barang_unit WHERE serial_number = :serial_number";
            $unitStmt = $pdo->prepare($checkUnit);
            $unitStmt->execute([':serial_number' => $unit['serial_number']]);
            $unitExist = $unitStmt->fetchColumn();

            if ($unitExist == 0) {
                // serial_number does not exist, handle the error
                header("Location: ../admin/return-unit.php?alert=1");
                exit();
            }
            //sn and id_unit
            $sn = $unit['serial_number'];
            $unit_query = $mysqli->query("SELECT id_unit FROM barang_unit WHERE serial_number = '$sn'");
            $id_f_unit = $unit_query->fetch_object();
            //query for log content
            $logquery = $mysqli->query("SELECT b.nama_barang, g.Nama_gudang 
                FROM barang_unit bu
                JOIN barang b ON bu.id_barang = b.id_barang
                JOIN gudang g ON bu.id_gudang = g.id_gudang
                WHERE bu.serial_number = '$sn' 
                LIMIT 1
            ");
            $data = $logquery->fetch_object();
            $nama_barang = $data->nama_barang;
            $nGudang = $data->Nama_gudang;
            $id_unit = $id_f_unit->id_unit;

            // Log content
            $log_content = $nama_barang . " Unit ". $unit['serial_number'] . " dikembalikan ke gudang " . $nGudang ;

            // Proceed with the insertion since id_gudang and serial_number is valid
            $query = "UPDATE `barang_unit` 
            SET `status`=:status, 
                `id_employee`= NULL, 
                `id_gudang`=:id_gudang, 
                `id_user`=:id_user, 
                `comment`=:komentar, 
                `kondisi`=:kondisi 
            WHERE `serial_number`=:serial_number";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':id_gudang' => $unit['id_gudang'],
                ':serial_number' => $unit['serial_number'],
                ':komentar' => $unit['komentar'],
                ':id_user' => $_SESSION['id_user'],
                ':kondisi' => $unit['kondisi'],
                ':status' => '0',]);
            
            // Query for log
            $loginsert = "INSERT INTO `unit_log`(`id_unit`, `content`) VALUES (:id_unit, :content)";
            $stmt = $pdo->prepare($loginsert);
            $stmt->execute([
                ':id_unit' => $id_unit,
                ':content' => $log_content,
            ]);

            
  
        }
        
        

        // Redirect after successful processing
        header("Location: ../admin/return-unit.php?alert=3");
        exit();
    } else {
        // Failed to open file
        header("Location: .../admin/return-unit.php?error=1");
        exit();
    }
} else {
    // No file uploaded, redirect back
    header("Location: ../admin/return-unit.php?error=3");
    exit();
}



