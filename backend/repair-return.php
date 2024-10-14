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

//gettiing nama_barang and nama_gudang
$query = $mysqli->query("SELECT b.nama_barang, g.Nama_gudang 
    FROM barang_unit bu
    JOIN barang b ON bu.id_barang = b.id_barang
    JOIN gudang g ON bu.id_gudang = g.id_gudang
    WHERE bu.id_unit = '$id_unit' 
    LIMIT 1
");
$data = $query->fetch_object();
$nama_barang = $data->nama_barang;
$nGudang = $data->Nama_gudang;

// Log content
$log_content = $nama_barang . " Unit ". $barang->serial_number . " selesai diperbaiki";


if ($kondisi == 4) {
    $mysqli->query("UPDATE barang_unit SET status = '4', id_employee = NULL ,id_gudang='$id_gudang',id_user ='$id_admin', comment ='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    $mysqli->query("INSERT INTO `unit_log`(`id_unit`, `content`) VALUES ('$id_unit', 'Unit Rusak Total')");
    header('Location: ../admin/repair-list.php');   
    exit();
} elseif ($kondisi != 4) {
    $mysqli->query("UPDATE barang_unit SET status = '0', id_employee = NULL ,id_gudang='$id_gudang',id_user ='$id_admin', comment ='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    $mysqli->query("INSERT INTO `unit_log`(`id_unit`, `content`) VALUES ('$id_unit', '$log_content')");
    header('Location: ../admin/repair-list.php');   
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>