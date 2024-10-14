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
if ($qunit->num_rows == 0) {
    echo "Invalid id_unit: $id_unit does not exist in the gudang table.";
    header('Location: ../admin/unit-lending.php');
    exit();
}

//getting nama_barang and emp_name
$query = $mysqli->query("SELECT 
        (SELECT nama_barang FROM barang WHERE id_barang = '$id_barang' LIMIT 1) AS nama_barang, 
        (SELECT emp_name FROM employee WHERE id_employee = '$id_employee' LIMIT 1) AS emp_name
");

$data = $query->fetch_object();
$nama_barang = $data->nama_barang;
$emp_name = $data->emp_name;

//log content
$log_content = $nama_barang . " Unit ". $barang->serial_number . " dipinjam oleh " . $emp_name;

if ($qunit->num_rows != 0) {
    $mysqli->query("UPDATE barang_unit SET status = '1' , id_employee = $id_employee, id_gudang=NULL, id_user ='$id_admin', comment ='Barang Dipinjam' WHERE id_unit = '$id_unit'");
    $mysqli->query("INSERT INTO `unit_log`(`id_unit`, `content`) VALUES ('$id_unit', '$log_content')");
    header('Location: ../admin/lending-single.php?id='. $barang->id_barang.'&alert=1');   
    exit();
} 
else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>