<?php

##session_start();
include("../database/config.php");
$id_admin = $_SESSION['id_user'];
$query = $mysqli->query("SELECT * FROM user WHERE id_user='$id_admin'");

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
            <a class="nav-link active" href="unit-manage.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Kelola Unit</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="unit-lending.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Peminjaman</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="return-unit.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Pengembalian</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Broken-List.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Barang Kondisi Rusak</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="Repair-List.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Barang-Perbaikan-Servis</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="search-update.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Koreksi Data</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="warehouse.php">
              <i class="ni ni-app text-green"></i>
              <span class="nav-link-text">Gudang</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employee.php">
              <i class="ni ni-circle-08 text-yellow"></i>
              <span class="nav-link-text">Karyawan</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="user_list.php">
              <i class="ni ni-circle-08 text-yellow"></i>
              <span class="nav-link-text">Daftar Admin</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
