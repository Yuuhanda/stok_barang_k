<?php
include('../database/config.php');

$serial_number = $_POST['serialn'];


//id barang
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE serial_number = '$serial_number'");
$barang = $qunit->fetch_object();
$id_barang = $barang->id_barang;


// id admin for last updated by
$id_admin = $_SESSION['id_user'];

// Check if the provided id_unit exists
$unit_check = $mysqli->query("SELECT * FROM barang_unit WHERE serial_number='$serial_number'");
$unit_data = $unit_check->fetch_object();
$id_unit = $unit_data->id_unit;
if ($unit_check->num_rows == 0) {
    echo "Nomor Seri tidak valid, $serial_number tidak ada. Cek penulisan!";
    header('Location: ../admin/search-update.php?alert=1');
    exit();
} 

if ($unit_check->num_rows != 0) {
    header('Location: ../admin/update-status.php?id='.$id_unit);
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>