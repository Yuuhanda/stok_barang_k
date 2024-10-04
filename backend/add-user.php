<?php
include('../database/config.php');

$username = $_POST['nuser'];
$email = $_POST['email'];
$level = $_POST['level'];
$password = $_POST['password'];
//$hashedPassword = hash('sha256', $password);
//$hashedPassword = substr($hashedPassword, 0, 60);

//if($mysqli->query("INSERT INTO user(`level`, `nama_user`, `email`, `password`) VALUES ('$level','$username','$email','$hashedPassword')")) {
//  header('Location:../admin/user_list.php');
//} else {
//  echo "query error";
//}

if($mysqli->query("INSERT INTO user(`level`, `nama_user`, `email`, `password`) VALUES ('$level','$username','$email','$hashedPassword')")) {
  header('Location:../admin/user_list.php');
} else {
  echo "query error";
}
?>