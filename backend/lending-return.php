<?php
include('../database/config.php');

$serial_number = $_POST['serialn'];
$condition = $_POST['condition'];
$id_gudang = $_POST['idgudang'];
$comment = $_POST['comment'];

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
    header('Location: ../admin/return-unit.php?alert=1');
    exit();
} 
$status = $barang->status;
if($status != 1){
    echo "Unit ini tidak sedang dipinjam";
    header('Location: ../admin/return-unit.php?alert=2');
    exit();
}

if ($unit_check->num_rows != 0) {
    if ($condition==0){
        $mysqli->query("UPDATE barang_unit SET status = '0' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi= '0' WHERE id_unit = '$id_unit'");
        header('Location: ../admin/return-unit.php');   
        exit();} elseif($condition==1){
        $mysqli->query("UPDATE barang_unit SET status = '0' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi = '1'  WHERE id_unit = '$id_unit'");
        header('Location: ../admin/return-unit.php');   
        exit();
    } elseif($condition==2){
        $mysqli->query("UPDATE barang_unit SET status = '0' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi= '2'  WHERE id_unit = '$id_unit'");
        header('Location: ../admin/return-unit.php');   
        exit();
    } elseif($condition==3){
        $mysqli->query("UPDATE barang_unit SET status = '0' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi= '3'  WHERE id_unit = '$id_unit'");
        header('Location: ../admin/return-unit.php');   
        exit();
    } elseif($condition==4){
        $mysqli->query("UPDATE barang_unit SET status = '3' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi= '4'  WHERE id_unit = '$id_unit'");
        header('Location: ../admin/return-unit.php');   
        exit();
    } else{

    }
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>