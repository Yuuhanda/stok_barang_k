
<?php @$id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Unit</title>
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
    <?php
    $query = $mysqli->query("SELECT * FROM barang WHERE id_barang='$id'");
    $barang = $query->fetch_object();?>
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
                    <li class="breadcrumb-item active" aria-current="page">Tambah Unit <?= $barang->nama_barang;?></li>
                  <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">ERR NO ID</li>
                  <?php endif; ?>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="dashboard.php" class="btn btn-sm btn-neutral">Kembali</a>
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
                    <h3 class="mb-0">Tambah Unit <?= $barang->nama_barang;?></h3>
                  <?php else: ?>
                    <h3 class="mb-0">ERR NO ID</h3>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php if (isset($id)): ?>
              <?php
              $query = $mysqli->query("SELECT * FROM barang WHERE id_barang='$id'");
              $barang = $query->fetch_object();
              $gudang_query = $mysqli->query("SELECT * FROM gudang")
              ?>
              <div class="card-body">
                <form action="../backend/add-unit.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="gudang">Pilih Gudang</label>
                            <select class="form-control" name="idgudang" id="gudang" required>
                                <option value="">Pilih Gudang</option>
                                <?php while ($gudang = $gudang_query->fetch_object()): ?>
                                    <option value="<?= $gudang->id_gudang; ?>"><?= $gudang->Nama_gudang; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                      </div>  
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="serial_number">Serial Number</label>
                          <input type="text" id="input-serial-number" name="snunit" class="form-control" placeholder="Serial Number" required>
                        </div>
                      </div>  
                    </div>
                    
                  </div>
                  <input type="hidden" name="idbarang" value="<?= $barang->id_barang; ?>">
                  <div class="text-center">
                    <button class="btn btn-primary my-4">Tambah Unit</button>
                  </div>
                </form>
              </div>
            <?php else: ?>
              <div class="card-body">
                ERR NO ID
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
