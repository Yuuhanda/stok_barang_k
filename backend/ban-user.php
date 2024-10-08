<?php
include('../database/config.php');

@$id = $_GET['id'];
$quser = $mysqli->query("SELECT ban_status FROM user WHERE id_user = '$id'");
$user_d = $quser->fetch_object();
$ban_status = $user_d->ban_status;
if($ban_status==0){
if($mysqli->query("UPDATE `user` SET ban_status='1' WHERE id_user='$id'")) {
  header('Location:../admin/user_list.php');
} else {
  echo "query error";
}} elseif($ban_status==1){
    if($mysqli->query("UPDATE `user` SET ban_status='0' WHERE id_user='$id'")) {
        header('Location:../admin/user_list.php');
      } else {
        echo "query error";
      }
}
?>