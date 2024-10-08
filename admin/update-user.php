<?php  @$id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add User</title>
  <?php include("asset/css.php"); ?>
</head>

<body>
  <!-- sidebar -->
  <?php include("asset/sidebar.php"); ?>
  <!-- sidebar end -->

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- navbar -->
    <?php include("asset/navbar.php"); ?>
    <!-- navbar end -->

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
                  <?php if (isset($id)): ?>
                    <li class="breadcrumb-item active" aria-current="page">Ubah User</li>
                  <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Tambah User</li>
                  <?php endif; ?>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="user_list.php" class="btn btn-sm btn-neutral">Kembali</a>
              <!-- <a href="#" class="btn btn-sm btn-neutral">Filters</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-12 order-xl-1">
          <div class="card">
            <div class="card-header">
              <div class="row align-items-center">
                <div class="col-8">
                  <?php if (isset($id)): ?>
                    <h3 class="mb-0">Ubah User</h3>
                  <?php else: ?>
                    <h3 class="mb-0">Tambah User</h3>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php if (isset($id)): ?>
              <?php
              $query = $mysqli->query("SELECT * FROM user WHERE id_user='$id'");
              $data = $query->fetch_object();
              ?>
              <div class="card-body">
                <form action="../backend/change-user.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Nama User</label>
                          <input type="text" id="input-username" name="nuser" class="form-control" value="<?= $data->nama_user; ?>">
                        </div>
                      </div>
                      <input type="hidden" name="iduser" value="<?= $data->id_user; ?>">
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Email</label>
                          <input type="email" id="input-first-name" name="email" class="form-control" value="<?= $data->email; ?>">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Admin level</label>
                          <select class="form-control" name="level" id="level">
                            <option value ="<?=$data->level?>">Level Admin</option>
                            <option value="0">Super Admin</option>
                            <option value="1">Admin</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-last-name">Password</label>
                          <input type="password" id="input-last-name" name="password" class="form-control" >
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-primary my-4">UBAH</button>
                  </div>
                </form>
              </div>
              <!-- endif -->
            <?php else: ?>
              <div class="card-body">
                <form action="../backend/add-user.php" method="post">
                  <?php if (isset($_GET['id'])): ?>
                    <h6 class="heading-small text-muted mb-4">Username Sudah Ada!</h6>
                  <?php else: ?>
                    <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <?php endif; ?>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">Nama User</label>
                          <input type="text" id="input-username" name="nuser" class="form-control" placeholder="Nama User" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Email</label>
                          <input type="email" id="input-first-name" name="email" class="form-control" placeholder="Email" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-first-name">Admin Level</label>
                          <select class="form-control" name="level" id="level" required>
                            <option value="0">Super Admin</option>
                            <option value="1">Admin</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-last-name">Password</label>
                          <input type="password" id="input-last-name" name="password" class="form-control" placeholder="password" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-primary my-4">TAMBAH</button>
                  </div>
                </form>
              </div>
            <?php endif; ?>

          </div>
        </div>
      </div>
      <?php include("asset/footer.php"); ?>
    </div>
  </div>

  <?php include("asset/js.php"); ?>
</body>

</html>
