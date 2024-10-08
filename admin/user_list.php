<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Master User</title>
  <?php include("asset/css.php"); ?>
</head>

<body>

  <?php if (isset($_GET['alert'])): ?>
    <script>alert('Tidak bisa melakukan penghapusan, karena ada relasi');</script>
  <?php endif; ?>
  <!-- sidebar -->
  <?php include("asset/sidebar.php"); ?>
  <!-- sidebar end -->

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- navbar -->
    <?php include("asset/navbar.php"); ?>
    <!-- navbar end -->
    <?php $id_admin = $_SESSION['id_user'];
    $adquery = $mysqli->query("SELECT * FROM user WHERE id_user='$id_admin'");
    $admindata = $adquery->fetch_object();
    $admin_level = $admindata->level;
    ?>

    
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Master Admin</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="update-user.php" class="btn btn-sm btn-neutral">Tambah Admin</a>
              <!-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Master User</h3>
                </div>
                <!-- <div class="col text-right">
                <a href="#!" class="btn btn-sm btn-primary">See all</a>
              </div> -->
            </div>
          </div>
          <div class="table-responsive">
            <!-- Projects table -->
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Nama User</th>
                  <th scope="col">Email</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $data = $mysqli->query("SELECT * FROM user");
                if ($admin_level == 0) {
                    while ($user_data = $data->fetch_object()) {
                  $ban_status = $user_data->ban_status;?>
                    <tr>
                      <th scope="row"><?= $user_data->nama_user; ?></th>
                      <td><?= $user_data->email; ?></td>
                      <td>
                        <?php if($ban_status==0): ?>
                        <a href="../backend/ban-user.php?id=<?= $user_data->id_user; ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Apakah anda yakin ingin menon-aktifkan admin ini?');">
                           Non-Aktifkan
                        </a>
                        <?php else : ?>
                          <a href="../backend/ban-user.php?id=<?= $user_data->id_user; ?>" 
                           class="btn btn-sm btn-info" 
                           onclick="return confirm('Apakah anda yakin ingin mengaktifkan admin ini?');">
                           Aktifkan
                        </a>
                        <?php endif ?>
                        <a href="update-user.php?id=<?= $user_data->id_user; ?>" class="btn btn-sm btn-info">Ubah</a>
                      </td>
                    </tr>
                  <?php
                    }
                  } elseif($admin_level==1) {
                    while ($user_data = $data->fetch_object()) {
                  ?>
                    <tr>
                      <th scope="row"><?= $user_data->nama_user; ?></th>
                      <td><?= $user_data->email; ?></td>
                      <td>Hanya Super Admin!</td>
                    </tr>
                  <?php
                    }
                  }
                  ?>
                    
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php include("asset/footer.php"); ?>
  </div>
</div>


<?php include("asset/js.php"); ?>
</body>


</html>
