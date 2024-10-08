<?php
include('../database/config.php');

$id_unit = $_POST['id_unit'];

$id_employee = $_POST['empid'];

//id barang
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
$barang = $qunit->fetch_object();
$id_barang = $barang->id_barang;


// id admin for last updated by
$id_admin = $_SESSION['id_user'];

// Check if the provided id_unit exists
$unit_check = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
if ($unit_check->num_rows == 0) {
    echo "Invalid id_unit: $id_unit does not exist in the gudang table.";
    header('Location: ../admin/item-detail.php?id=' . $id_barang);
    exit();
} 

if ($unit_check->num_rows != 0) {
    $mysqli->query("UPDATE barang_unit SET status = '1' , id_employee = $id_employee, id_gudang=NULL, id_user ='$id_admin', comment ='Barang Dipinjam' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>