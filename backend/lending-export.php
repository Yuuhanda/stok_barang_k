<?php
// Include FPDF library and db config
require('../vendor/fpdf/fpdf.php');
include('../database/config.php');

// Create a new instance of FPDF with landscape orientation
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Set font for the document
$pdf->SetFont('Arial', 'B', 12);

// Title
$pdf->Cell(0, 10, 'Unit Log Report', 0, 1, 'C');

// Add some space
$pdf->Ln(10);

// Set font for table header
$pdf->SetFont('Arial', 'B', 10);

// Table headers
$pdf->Cell(45, 10, 'Nomor Seri', 1);
$pdf->Cell(60, 10, 'Karyawan', 1);
$pdf->Cell(60, 10, 'Data diperbarui oleh', 1);
$pdf->Cell(38, 10, 'Tanggal', 1);
$pdf->Cell(70, 10, 'Kondisi', 1);
$pdf->Ln();

// Set font for table rows
$pdf->SetFont('Arial', '', 10);

// Fetch the data
$query = $mysqli->query("SELECT bu.kondisi AS kondisi, bu.serial_number AS serial_number, bu.id_unit AS id_unit, bu.status AS status, u.nama_user AS nama_user, g.Nama_gudang AS nama_gudang, e.emp_name AS emp_name, bu.comment AS comment, ul.datetime AS datetime
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
        bu.status = '1';");

// Loop through the records and output them to the PDF
while ($barang = $query->fetch_object()) {
    $status_text = '';
    $location = '';

    switch ($barang->status) {
        case 0:
            $status_text = "Tersedia/Disimpan";
            $location = $barang->nama_gudang;
            break;
        case 1:
            $status_text = "Dipinjam/Digunakan";
            $location = $barang->emp_name;
            break;
        case 2:
            $status_text = "Dalam Perbaikan";
            $location = "Tidak Tersedia";
            break;
        case 3:
            $status_text = "Rusak Total/Hilang";
            $location = $barang->nama_gudang;
            break;
        default:
            $status_text = "Unknown status";
            $location = "Status tidak diketahui";
            break;
    }

    switch ($barang->kondisi) {
        case 0:
            $kondisi_text = "Tidak ada kerusakan";
            break;
        case 1:
            $kondisi_text = "Kerusakan Ringan";
            break;
        case 2:
            $kondisi_text = "Kerusakan Sedang. Komponen Hilang";
            break;
        case 3:
            $kondisi_text = "Kerusakan Berat. Tidak bisa digunakan";
            break;
        case 4:
            $kondisi_text = "Rusak Total/Hilang";
            break;
        default:
            $kondisi_text = "Unknown status";
            break;
    }

    // Print each row
    $pdf->Cell(45, 10, $barang->serial_number, 1);
    $pdf->Cell(60, 10, $location, 1);
    $pdf->Cell(60, 10, $barang->nama_user ?? 'DELETED USER', 1);
    $pdf->Cell(38, 10, $barang->datetime, 1);
    $pdf->Cell(70, 10, $kondisi_text, 1);
    $pdf->Ln();
}
 //data counter
$counter = $query->num_rows;

$pdf->Cell(45, 10, 'Total Data', 1);
$pdf->Cell(60, 10, $counter, 1, 1, 'R');
// Output the PDF file
$pdf->Output('D', 'laporan_peminjaman' . time() . '.pdf');
?>
