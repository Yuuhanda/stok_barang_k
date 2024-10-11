<?php
include('../database/config.php');

$serial_number = $_POST['serialn'];


//id barang
$qunit = $mysqli->query("SELECT id_unit FROM barang_unit WHERE serial_number = '$serial_number'");
$barang = $qunit->fetch_object();
$id = $barang->id_unit;
$id_barang = $barang->id_barang;

// Check if the provided id_unit exists
if ($qunit->num_rows == 0) {
    echo "Nomor Seri tidak valid, $serial_number tidak ada. Cek penulisan!";
    header('Location: ../admin/log-search.php?alert=1');
    exit();
} 


if ($qunit->num_rows != 0) {
    header('Location: ../admin/log-unit.php?id='.$id);
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>