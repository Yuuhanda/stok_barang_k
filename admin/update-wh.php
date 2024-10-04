<?php  @$id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Gudang</title>
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
                    <li class="breadcrumb-item active" aria-current="page">Ubah Gudang</li>
                  <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Gudang</li>
                  <?php endif; ?>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="warehouse.php" class="btn btn-sm btn-neutral">Kembali</a>
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
                    <h3 class="mb-0">Ubah Gudang</h3>
                  <?php else: ?>
                    <h3 class="mb-0">Tambah Gudang</h3>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php if (isset($id)): ?>
              <?php
              $query = $mysqli->query("SELECT * FROM gudang WHERE id_gudang='$id'");
              $data = $query->fetch_object();
              ?>
              <div class="card-body">
                <form action="../backend/change-wh.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-gudang">Nama Gudang</label>
                          <input type="text" id="input-gudang" name="ngudang" class="form-control" value="<?= $data->Nama_gudang; ?>">
                        </div>
                      </div>
                      <input type="hidden" name="idwhouse" value="<?= $data->id_gudang; ?>">
                      
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
                <form action="../backend/add-wh.php" method="post">
                  <?php if (isset($_GET['id'])): ?>
                    <h6 class="heading-small text-muted mb-4">Gudang Sudah Ada</h6>
                  <?php else: ?>
                    <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <?php endif; ?>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="form-group">
                          <label class="form-control-label" for="input-gudang">Nama Gudang</label>
                          <input type="text" id="input-gudang" name="ngudang" class="form-control" placeholder="Nama Gudang">
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
