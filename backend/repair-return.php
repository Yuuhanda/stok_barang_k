<?php
include('../database/config.php');

$id_unit = $_POST['id_unit'];
$comment_content = $_POST['comment'];
$id_gudang = $_POST['idgudang'];
$kondisi = $_POST['condition'];

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
    header('Location: ../admin/repair-list.php?alert=1');
    exit();
}

if ($kondisi == 4) {
    $mysqli->query("UPDATE barang_unit SET status = '4', id_employee = NULL ,id_gudang='$id_gudang',id_user ='$id_admin', comment ='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/repair-list.php');   
    exit();
} elseif ($kondisi != 4) {
    $mysqli->query("UPDATE barang_unit SET status = '0', id_employee = NULL ,id_gudang='$id_gudang',id_user ='$id_admin', comment ='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/repair-list.php');   
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>