<?php  ?>
<?php @$id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Pinjam Unit</title>
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
$query_unit = $mysqli->query("SELECT * FROM barang_unit WHERE id_barang = '$id' AND id_gudang IS NOT NULL");
$barang_unit = $query_unit->fetch_object();
$barang_id = $barang_unit->id_barang;
$query = $mysqli->query("SELECT nama_barang FROM barang WHERE id_barang='$id'");
$nbarang = $query->fetch_object();
$query_unit = $mysqli->query("SELECT * FROM barang_unit WHERE id_barang = '$id' AND id_gudang IS NOT NULL");

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
                  <?php if (isset($id)): ?>
                    <li class="breadcrumb-item active" aria-current="page">Pinjam Barang </li>
                  <?php else: ?>
                    <li class="breadcrumb-item active" aria-current="page">ERR NO ID</li>
                  <?php endif; ?>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="unit-lending.php" class="btn btn-sm btn-neutral">Kembali</a>
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
                    <h3 class="mb-0">Peminjaman <?= $nbarang->nama_barang?></h3>
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
                $employee_q =$mysqli->query("SELECT emp_name, id_employee FROM employee");
                $unit_q = $mysqli->query("SELECT * FROM barang_unit WHERE id_barang = '$id' AND id_gudang IS NOT NULL");
                ?>
              <div class="card-body">
                <form action="../backend/lending-update.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-serial-number">Nomor Seri</label>
                          <select class="form-control" name="id_unit" id="id_unit" required>
                              <option value="">Pilih Unit</option>
                                  <?php while ($unit_data = $unit_q->fetch_object()): ?>
                                    <option value="<?= $unit_data->id_unit; ?>"><?= $unit_data->serial_number; ?></option>
                                  <?php endwhile; ?>
                              
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="empid">Pilih Karyawan</label>
                            <select   class="form-control" name="empid" id="empid" required>
                                <option value="">Pilih Employee</option>
                                <?php while ($emp_data = $employee_q->fetch_object()): ?>
                                    <option value="<?= $emp_data->id_employee; ?>"><?= $emp_data->emp_name; ?></option>
                                <?php endwhile; ?>
                            </select>
                            
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button class="btn btn-primary my-4">UBAH</button>
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
