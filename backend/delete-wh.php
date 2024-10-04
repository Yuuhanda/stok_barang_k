<?php
include('../database/config.php');

@$id = $_GET['id'];
$qwarehouse = $mysqli->query("SELECT * FROM gudang LEFT JOIN barang_unit ON gudang.id_gudang=barang_unit.id_gudang WHERE gudang.id_gudang=$id");
$wh_data = $qwarehouse->fetch_object();
$check_wh = $wh_data->id_gudang;
if($check_wh!=NULL){
    header('Location:../admin/warehouse.php?alert=1'); 
} else {
if($mysqli->query("DELETE FROM gudang WHERE id_gudang=$id")) {
  header('Location:../admin/warehouse.php');
} else {
  echo "query error";
}
}
?>