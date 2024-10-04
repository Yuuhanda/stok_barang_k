<?php
session_start(); 
include('../database/config.php');

$email = $_POST['email'];
$password = $_POST['password'];

$query_admin = $mysqli->query("SELECT * FROM user WHERE email='$email' AND password='$password'");
$admin = $query_admin->num_rows;


echo $admin;
if ($admin==1) {
    $data = $query_admin->fetch_object();
    $_SESSION['id_user'] = $data->id_user;
    $_SESSION['level'] = $data->level;
    
    header('Location:../admin/dashboard.php');
  } else {
    echo"fail";
  }

if ($admin==0) {
  header("Location:../index.php?id=1");
} else {
    echo"fail";
}
?>