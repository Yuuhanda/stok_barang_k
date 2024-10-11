<?php

include '../database/config.php';

// Check if a file is uploaded
if (isset($_FILES['fileToUpload'])) {
    // Check if the uploaded file is a CSV
    $fileType = mime_content_type($_FILES['fileToUpload']['tmp_name']);
    if ($fileType != 'text/csv') {
        // Not a CSV file, redirect with error
        header("Location: ../admin/return-unit.php");
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

            // Redirect if 'gudang' is empty
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
                ':status' => '0',
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



