<?php
include('../database/config.php');

$username = $_POST['nuser'];
$email = $_POST['email'];
$level = $_POST['level'];
$password = $_POST['password'];

if($mysqli->query("INSERT INTO user(`level`, `nama_user`, `email`, `password`) VALUES ('$level','$username','$email','$password')")) {
  header('Location:../admin/user_list.php');
} else {
  echo "query error";
}
?>