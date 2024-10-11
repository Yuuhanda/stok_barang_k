<?php

include '../database/config.php';

// Check if a file is uploaded
if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
    // Check if the uploaded file is a CSV
    $fileType = mime_content_type($_FILES['fileToUpload']['tmp_name']);
    
    // Check if the file is indeed a CSV
    if ($fileType != 'text/csv') {
        // Not a CSV file, redirect with error
        header("Location: ../admin/add-item.php?error=3");
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
                // Skip the header row
                $firstRow = false;
                continue;
            }
        
            // Assuming CSV columns: 0 = nama_barang, 1 = sku
            $nama_barang = trim($data[0]);
            $sku = trim($data[1]);
        
            // Redirect if 'nama_barang' is empty
            if (empty($nama_barang)) {
                fclose($handle);
                header("Location: ../admin/add-item.php?error=4");
                exit();
            }
        
        
            // Auto-generate SKU if it's empty
            if (empty($sku)) {
                // Example SKU: "<5 char random>-<random number>-<timestamp>"
                $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5); // Generate a 5 character random string
                $sku = $randomStr . "-" . rand(1,1000) . "-" . time(); // random string, random number, and timestamp
            }
        
            // Check if 'sku' is unique
            $skuQuery = $mysqli->query("SELECT `sku` FROM `barang` WHERE `sku` = '$sku' LIMIT 1");
            if ($skuQuery->num_rows > 0) {
                // If the generated or provided SKU already exists, regenerate it
                $randomStr = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5); // Generate new random string
                $sku = $randomStr . "-" . time(); // Regenerate with different random string and timestamp
            
                // Check again for uniqueness
                $skuQuery = $mysqli->query("SELECT `sku` FROM `barang` WHERE `sku` = '$sku' LIMIT 1");
                if ($skuQuery->num_rows > 0) {
                    // If the SKU is still not unique after regeneration, throw an error
                    fclose($handle);
                    header("Location: ../admin/add-item.php?error=6"); // Error code 6 for SKU not unique
                    exit();
                }
            }
        
            // Temporarily store the valid data
            $units[] = [
                'nama_barang' => $nama_barang,
                'sku' => $sku,
            ];
        }


        fclose($handle);

        
        foreach ($units as $unit) {
            // Data insertion
            $query = "INSERT INTO barang (nama_barang, sku) VALUES (:nama_barang, :sku)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':nama_barang' => $unit['nama_barang'],
                ':sku' => $unit['sku'],
            ]);
        }
        
        

        // Redirect after successful processing
        header("Location: ../admin/unit-manage.php");
        exit();
    } else {
        // Failed to open file
        header("Location: .../admin/add-item.php?error=1");
        exit();
    }
} else {
    // No file uploaded, redirect back
    header("Location: ../admin/add-item.php?error=2");
    exit();
}


