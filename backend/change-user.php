<?php
include('../database/config.php');

$id_user = $_POST['iduser'];
$username = $_POST['nuser'];
$email = $_POST['email'];
$level = $_POST['level'];
$password = $_POST['password'];
if($password==''||$password==NULL){
  if($mysqli->query("UPDATE user SET `level`='$level',`nama_user`='$username',`email`='$email' WHERE id_user='$id_user'")) {
    header('Location:../admin/user_list.php');
  } else {
    echo "query error";
  }
} else {
  $hashedPassword = hash('sha256', $password);
  $hashedPassword = substr($hashedPassword, 0, 60);

  if($mysqli->query("UPDATE user SET `level`='$level',`nama_user`='$username',`email`='$email',`password`='$hashedPassword' WHERE id_user='$id_user'    ")) {
    header('Location:../admin/user_list.php');
  } else {
    echo "query error";
  }
}

?>