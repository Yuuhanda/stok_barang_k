<?php
include('../database/config.php');

$id_unit = $_POST['id_unit'];
$comment_content = $_POST['comment'];
$status_val = $_POST['status'];
$id_gudang = $_POST['idgudang'];
$id_employee = $_POST['empid'];
$kondisi = $_POST['condition'];

//id barang
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
$barang = $qunit->fetch_object();
$id_barang = $barang->id_barang;


// id admin for last updated by
$id_admin = $_SESSION['id_user'];
$query = $mysqli->query("SELECT * FROM user WHERE id_user='$id_admin'");
$admin = $query->fetch_object();
$id_admin = $admin->id_user; 

// Check if the provided id_unit exists
$unit_check = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit='$id_unit'");
if ($unit_check->num_rows == 0) {
    echo "Invalid id_unit: $id_unit does not exist in the gudang table.";
    header('Location: ../admin/search-update.php?alert=1?');
    exit();
}

if ($status_val==0) {
    if($mysqli->query("UPDATE barang_unit SET status = '$status_val', id_employee = NULL ,id_gudang='$id_gudang',id_user ='$id_admin', comment ='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'")){
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();} else{}
} elseif($status_val==1){
    $mysqli->query("UPDATE barang_unit SET status = '$status_val',id_employee='$id_employee',id_gudang=NULL ,id_user='$id_admin',comment='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();
} elseif($status_val==2){
    $mysqli->query("UPDATE barang_unit SET status ='$status_val',id_employee= NULL ,id_gudang= NULL ,id_user='$id_admin',comment='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();
} elseif($status_val==3){
    $mysqli->query("UPDATE barang_unit SET status ='$status_val',id_employee= NULL, id_gudang= $id_gudang,id_user='$id_admin',comment='$comment_content', kondisi='$kondisi' WHERE id_unit = '$id_unit'");
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();
}
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>