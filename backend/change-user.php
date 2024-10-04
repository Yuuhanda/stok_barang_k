<?php
include('../database/config.php');

$id_user = $_POST['iduser'];
$username = $_POST['nuser'];
$email = $_POST['email'];
$level = $_POST['level'];
$password = $_POST['password'];

if($mysqli->query("UPDATE user SET `level`='$level',`nama_user`='$username',`email`='$email',`password`='$password' WHERE id_user='$id_user'    ")) {
  header('Location:../admin/user_list.php');
} else {
  echo "query error";
}
?>