<?php
include('../database/config.php');

$id_gudang = $_POST['idgudang'];
$id_barang = $_POST['idbarang'];
$id_admin = $_SESSION['id_user'];
$serial_n = $_POST['snunit'];

// Check if the provided id_gudang exists
$gudang_check = $mysqli->query("SELECT * FROM gudang WHERE id_gudang='$id_gudang'");
if ($gudang_check->num_rows == 0) {
    echo "Invalid id_gudang: $id_gudang does not exist in the gudang table.";
    header('Location: ../admin/item-detail.php?id=' . $id_barang); 
    exit();
}

if ($mysqli->query("INSERT INTO barang_unit (id_barang, status, id_employee, id_gudang, id_user, comment, serial_number) VALUES ('$id_barang', '0', NULL, '$id_gudang', '$id_admin', 'New Unit', '$serial_n')")) {
    header('Location: ../admin/item-detail.php?id=' . $id_barang);   
    exit();
} else {
    echo "Query error: " . $mysqli->error; // Display the specific error message
}
?>
