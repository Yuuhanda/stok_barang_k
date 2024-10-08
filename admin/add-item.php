

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Inventory</title>
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
    <?php @$id = $_GET['id']; ?>
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
                    <li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
                  <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Barang</li>
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
                    <h3 class="mb-0">Edit Item</h3>
                  <?php else: ?>
                    <h3 class="mb-0">Tambah Item</h3>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php if (isset($id)): ?>
              <?php
              $query = $mysqli->query("SELECT * FROM barang WHERE id_barang='$id'");
              $barang = $query->fetch_object();
              ?>
              <div class="card-body">
                <form action="../backend/change-items.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-nama-barang">Nama Barang</label>
                          <input type="text" id="input-nama-barang" name="nbarang" class="form-control" value="<?= $barang->nama_barang; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-sku">SKU</label>
                          <input type="text" id="input-sku" name="sku" class="form-control" value="<?= $barang->sku; ?>">
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <input type="hidden" name="id" value="<?= $barang->id_barang; ?>">
                  <div class="text-center">
                    <button class="btn btn-primary my-4">UBAH</button>
                  </div>
                </form>
              </div>
            <?php else: ?>
              <div class="card-body">
                <form action="../backend/add-items.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-nama-barang">Nama Barang</label>
                          <input type="text" id="input-nama-barang" name="nbarang" class="form-control" placeholder="Nama Barang" required>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-sku">SKU</label>
                          <input type="text" id="input-sku" name="skuinput" class="form-control" placeholder="SKU" required>
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
