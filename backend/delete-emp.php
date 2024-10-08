<?php
include('../database/config.php');

@$id = $_GET['id'];
$qemp = $mysqli->query(" SELECT barang_unit.id_unit AS id_unit
  FROM employee 
  LEFT JOIN barang_unit ON barang_unit.id_employee = employee.id_employee 
  WHERE employee.id_employee = '$id'");
$check_data = $qemp->fetch_object();
$id_check = $check_data->id_unit;
if($id_check !=NULL){
  header('Location:../admin/employee.php?alert=1'); 
} elseif($id_check == NULL) {
  if ($mysqli->query("DELETE FROM employee WHERE id_employee = '$id'")) {
    header('Location: ../admin/employee.php');
  } else {
    echo "Query error: " . $mysqli->error;
  }
} else {
  echo "Query error: " . $mysqli->error;
}
?>