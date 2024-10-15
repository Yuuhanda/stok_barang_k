<?php
// Include FPDF library
require('../vendor/fpdf/fpdf.php');

if(isset($_GET['start_date'])){
    //Get id if exist
    $start_date = $_GET['start_date'];}

if(isset($_GET['end_date'])){
    //Get id if exist
    $end_date = $_GET['end_date'];}

if(isset($_GET['id'])){
//Get id if exist
$id = $_GET['id'];}

if (!empty($start_date) && !empty($end_date)) {
    // Adjust start date to the beginning of the day and end date to the end of the day
    $start_date .= ' 00:00:00';
    $end_date .= ' 23:59:59';

}

// Create a new instance of the FPDF class
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();

// Set font for the document
$pdf->SetFont('Arial', 'B', 12);

// Title
$pdf->Cell(0, 10, 'Log Riwayat Unit', 0, 1, 'C');

// Add some space
$pdf->Ln(10);

// Set font for table header
$pdf->SetFont('Arial', 'B', 10);

// Table header
$pdf->Cell(200, 10, 'Log', 1);
$pdf->Cell(40, 10, 'Tanggal', 1);
$pdf->Ln();

// Connect to your database
$mysqli = new mysqli("localhost", "root", "", "stok_barang_k");

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if(isset($id) && isset($start_date)){
// Fetch the unit log data
$query = $mysqli->query("SELECT content, datetime FROM unit_log WHERE id_unit = $id  AND datetime BETWEEN '$start_date' AND '$end_date' ORDER BY datetime DESC");
} elseif(!isset($id) && isset($start_date)){
    $query = $mysqli->query("SELECT content, datetime FROM unit_log WHERE datetime BETWEEN '$start_date' AND '$end_date' ORDER BY datetime DESC");
}  
elseif(isset($id) && !isset($start_date)){
    $query = $mysqli->query("SELECT content, datetime FROM unit_log WHERE id_unit = $id ORDER BY datetime DESC");
} 
else {
    $query = $mysqli->query("SELECT content, datetime FROM unit_log ORDER BY datetime DESC");
}
// Set font for table rows
$pdf->SetFont('Arial', '', 10);

// Fetch each row and print it to the PDF
while ($log = $query->fetch_object()) {
    $pdf->Cell(200, 10, $log->content, 1);
    $pdf->Cell(40, 10, $log->datetime, 1);
    $pdf->Ln();
}

// Data Counter
$counter = $query->num_rows;

$pdf->Cell(200, 10, 'Total Data', 1);
$pdf->Cell(40, 10, $counter, 1, 1, 'R');

// Output the PDF
$pdf->Output('D', 'log_riwayat_unit' . time() . '.pdf');


?>
