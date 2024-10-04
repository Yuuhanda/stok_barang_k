<?php
include('../database/config.php');

$nkaryawan = $_POST['nkaryawan'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$id_emp = $_POST['idemp'];

if($mysqli->query("UPDATE `employee` SET `emp_name`='$nkaryawan',`phone`='$phone',`email`='$email',`address`='$address' WHERE id_employee='$id_emp'")) {
  header('Location:../admin/employee.php');
} else {
  echo "query error";
}
?>