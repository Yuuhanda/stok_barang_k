<?php
include('../database/config.php');

$nkaryawan = $_POST['nkaryawan'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

if($mysqli->query("INSERT INTO `employee`(`emp_name`, `phone`, `email`, `address`) VALUES ('$nkaryawan','$phone','$email','$address')")) {
  header('Location:../admin/employee.php');
} else {
  echo "query error";
}
?>