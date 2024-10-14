<?php
require('../vendor/fpdf/fpdf.php');
include('../database/config.php');

// Query to fetch the data
$query = $mysqli->query("SELECT barang.nama_barang AS nama_barang, barang_unit.kondisi AS kondisi, barang_unit.serial_number AS serial_number ,barang_unit.id_unit AS id_unit, barang_unit.status AS status, user.nama_user AS nama_user, gudang.Nama_gudang AS nama_gudang, employee.emp_name AS emp_name, barang_unit.comment AS comment
FROM barang_unit 
LEFT JOIN barang 
  ON barang.id_barang = barang_unit.id_barang
LEFT JOIN gudang
  ON barang_unit.id_gudang = gudang.id_gudang
LEFT JOIN employee
  ON barang_unit.id_employee = employee.id_employee
LEFT JOIN user
  ON user.id_user = barang_unit.id_user
WHERE barang_unit.kondisi = '1' OR barang_unit.kondisi = '2' OR barang_unit.kondisi = '3'");

// Create FPDF instance
$pdf = new FPDF('L', 'mm', 'A4'); // Landscape orientation, A4 size
$pdf->AddPage();

// Set title
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Barang Repair Report', 0, 1, 'C');
$pdf->Ln(5);

// Set table header
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 9, 'Nama Barang', 1);
$pdf->Cell(38, 9, 'Nomor Seri', 1);
$pdf->Cell(130, 9, 'Komentar', 1);
$pdf->Cell(56, 9, 'Kondisi', 1);
$pdf->Ln();

// Set font for table rows
$pdf->SetFont('Arial', '', 9);

// Fetch data and display in the table
while ($barang = $query->fetch_object()) {
    // Determine condition text
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

    // Fill data in the table
    $pdf->Cell(50, 9, $barang->nama_barang, 1);
    $pdf->Cell(38, 9, $barang->serial_number, 1);
    $pdf->Cell(130, 9, $barang->comment, 1);
    $pdf->Cell(56, 9, $kondisi_text, 1);
    $pdf->Ln();
}

// Output the PDF
$pdf->Output('D', 'laporan_barang_rusak' . time() . '.pdf'); // Display PDF in browser

?>
