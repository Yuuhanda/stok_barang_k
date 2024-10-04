<?php
include('../database/config.php');

$ngudang = $_POST['ngudang'];


if($mysqli->query("INSERT INTO `gudang`( `Nama_gudang`) VALUES ('$ngudang')")) {
  header('Location:../admin/warehouse.php');
} else {
  echo "query error";
}
?>