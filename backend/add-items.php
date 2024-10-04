<?php
include('../database/config.php');

$nama_brg = $_POST['nbarang'];
$sku_input = $_POST['skuinput'];
if($mysqli->query("INSERT INTO barang(nama_barang, sku) VALUES('$nama_brg', '$sku_input')")) {
  header('Location:../admin/dashboard.php');
} else {
  echo "query error";
}
?>