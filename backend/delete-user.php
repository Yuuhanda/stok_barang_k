<?php
include('../database/config.php');

@$id = $_GET['id'];
//$quser = $mysqli->query("SELECT * FROM user LEFT JOIN barang_unit ON  WHERE id_user=$id");
if($mysqli->query("DELETE FROM user WHERE id_user=$id")) {
  header('Location:../admin/user_list.php');
} else {
  echo "query error";
}
?>