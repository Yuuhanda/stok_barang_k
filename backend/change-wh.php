<?php
include('../database/config.php');

$id_gudang = $_POST['idwhouse'];
$ngudang = $_POST['ngudang'];


if($mysqli->query("UPDATE `gudang` SET `Nama_gudang`='$ngudang' WHERE id_gudang='$id_gudang'")) {
  header('Location:../admin/warehouse.php');
} else {
  echo "query error";
}
?>