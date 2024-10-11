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
$id_unit = $barang->id_unit;
if ($qunit->num_rows == 0) {
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
$log_content = $nama_barang . " Unit ". $barang->serial_number . " dikembalikan ke gudang" . $nGudang ;

if ($qunit->num_rows != 0) {
        $mysqli->query("UPDATE barang_unit SET status = '0' , id_employee = NULL, id_gudang='$id_gudang', id_user ='$id_admin', comment ='$comment', kondisi= '$condition' WHERE id_unit = '$id_unit'");
        $mysqli->query("INSERT INTO `unit_log`(`id_unit`, `content`) VALUES ('$id_unit', '$log_content')");
        header('Location: ../admin/return-unit.php');   
        exit();
} else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>