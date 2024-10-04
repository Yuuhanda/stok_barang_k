<?php
##session_start();
include("../database/config.php");
$id_admin = $_SESSION['id_user'];
$query = $mysqli->query("SELECT * FROM user WHERE id_user='$id_user'");

$admin = $query->fetch_object();

if ($_SESSION['id_user'] == '') {
  header("Location:../index.php");
}
?>
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="../vendor/images/main_icon.png" class="navbar-brand-img" alt="...">
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" href="dashboard.php">
              <i class="ni ni-tv-2 text-primary"></i>
              <span class="nav-link-text">Master Inventory</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="user_list.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">User</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employee.php">
              <i class="ni ni-circle-08 text-yellow"></i>
              <span class="nav-link-text">employee</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="warehouse.php">
              <i class="ni ni-circle-08 text-yellow"></i>
              <span class="nav-link-text">employee</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
