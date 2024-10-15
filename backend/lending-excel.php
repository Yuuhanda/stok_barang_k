<?php
// Ensure no output is sent before headers
ob_start();

require '../vendor/autoload.php';
include('../database/config.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

try {
    // Database query
    $query = $pdo->query("SELECT 
            bu.kondisi AS kondisi, bu.serial_number AS serial_number, bu.id_unit AS id_unit, bu.status AS status, 
            u.nama_user AS nama_admin, g.Nama_gudang AS nama_gudang, e.emp_name AS nama_karyawan, 
            bu.comment AS comment, ul.datetime AS datetime
        FROM 
            barang_unit bu
        LEFT JOIN 
            barang b ON b.id_barang = bu.id_barang
        LEFT JOIN 
            gudang g ON bu.id_gudang = g.id_gudang
        LEFT JOIN 
            employee e ON bu.id_employee = e.id_employee
        LEFT JOIN 
            user u ON u.id_user = bu.id_user
        LEFT JOIN 
            unit_log ul ON ul.id_unit = bu.id_unit
        INNER JOIN (
            SELECT 
                id_unit, MAX(datetime) AS latest_datetime
            FROM 
                unit_log
            GROUP BY 
                id_unit
        ) latest_logs ON ul.id_unit = latest_logs.id_unit AND ul.datetime = latest_logs.latest_datetime
        WHERE 
            bu.status = '1';
    ");

    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    // Create new spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add header row
    if (!empty($data)) {
        $headers = array_keys($data[0]); // Extract headers
        $sheet->fromArray($headers, NULL, 'A1'); // Write headers to first row

        // Add data rows
        $rowIndex = 2; // Starting from row 2
        foreach ($data as $row) {
            // Apply the switch case for the 'kondisi' field
            switch ($row['kondisi']) {
                case 0:
                    $row['kondisi'] = "Tidak ada kerusakan";
                    break;
                case 1:
                    $row['kondisi'] = "Kerusakan Ringan";
                    break;
                case 2:
                    $row['kondisi'] = "Kerusakan Sedang. Komponen Hilang";
                    break;
                case 3:
                    $row['kondisi'] = "Kerusakan Berat. Tidak bisa digunakan";
                    break;
                case 4:
                    $row['kondisi'] = "Rusak Total/Hilang";
                    break;
                default:
                    $row['kondisi'] = "Unknown status";
                    break;
            }

            // Write the modified row to the spreadsheet
            $sheet->fromArray(array_values($row), NULL, 'A' . $rowIndex); // Write each row
            $rowIndex++;
        }
    } else {
        throw new Exception("No data found.");
    }

    $timestamp = time();
    // Set the headers to download the file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="daftar_peminjaman_' . $timestamp . '.xlsx"');
    header('Cache-Control: max-age=0');
    header('Expires: 0');
    header('Pragma: public');

    // Clear the output buffer
    ob_end_clean();

    // Create Xlsx object and download the file
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

} catch (Exception $e) {
    // Handle exceptions
    echo 'Error: ' . $e->getMessage();
    ob_end_flush();
}

exit;
?>
