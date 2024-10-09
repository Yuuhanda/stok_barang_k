<?php  ?>
<?php @$id = $_GET['id']; ?>
<?php @$alert = $_GET['alert'];?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Log Unit</title>
  <?php include("asset/css.php"); ?>
</head>

<body>
    
    <?php if ($alert==1): ?>
        <script>alert('Nomor Seri Unit Tidak Ada, cek penulisan');</script>
  <?php endif; ?>
  <!-- sidebar -->
  <?php include("asset/sidebar.php"); ?>
  <!-- sidebar end -->

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- navbar -->
    <?php include("asset/navbar.php"); ?>
    <!-- navbar end -->
    <?php


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
                    <li class="breadcrumb-item active" aria-current="page">Log Unit</li>

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
                    <h3 class="mb-0">Cari Barang</h3>
                </div>
              </div>
            </div>
            
              <div class="card-body">
                
                <form action="../backend/log-search.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-serial-number">Nomor Seri Unit</label>
                          <input type="text" id="serialn" name="serialn" class="form-control" placeholder="Nomor Seri Unit" required>
                            
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-primary my-4">Cari</button>
                  </div>
                  
                </form>
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
