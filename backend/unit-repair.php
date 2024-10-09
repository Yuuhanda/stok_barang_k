<?php
include('../database/config.php');

$id_unit = $_POST['id_unit'];
$comment_content = $_POST['comment'];

//id barang
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
$barang = $qunit->fetch_object();
// id admin for last updated by
$id_admin = $_SESSION['id_user'];
$query = $mysqli->query("SELECT * FROM user WHERE id_user='$id_admin'");
$admin = $query->fetch_object();

// Check if the provided id_unit exists
$unit_check = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
if ($unit_check->num_rows == 0) {
    echo "Invalid id_unit: $id_unit does not exist in the gudang table.";
    header('Location: ../admin/broken-list.php?alert=1');
    exit();
}

if ($unit_check->num_rows != 0) {
    $mysqli->query("UPDATE barang_unit SET status = '2', id_employee = NULL ,id_gudang=NULL, id_user ='$id_admin', comment ='$comment_content' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/broken-list.php');   
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>