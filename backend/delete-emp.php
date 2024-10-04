<?php
include('../database/config.php');

@$id = $_GET['id'];
$qemp = $mysqli->query(" SELECT employee.id_employee 
  FROM employee 
  LEFT JOIN barang_unit ON barang_unit.id_employee = employee.id_employee 
  WHERE employee.id_employee = '$id'");
$emp_data = $qemp->fetch_object();
$emp_check = $emp_data->id_employee;
if($emp_check!=NULL){
  header('Location:../admin/employee.php?alert=1'); 
} else {
  if ($mysqli->query("DELETE FROM employee WHERE id_employee = '$id'")) {
    header('Location: ../admin/employee.php');
  } else {
    echo "Query error: " . $mysqli->error;
  }
}
?>