<?php  ?>
<?php @$id = $_GET['id']; ?>
<?php @$alert = $_GET['alert'];?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Inventory</title>
  <?php include("asset/css.php"); ?>
</head>
    <?php if ($alert==1): ?>
        <script>alert('Nomor Seri Unit Tidak Ada, cek penulisan');</script>
    <?php elseif($alert==2): ?>
        <script>alert('Unit dengan nomor seri ini sedang tidak dipinjam');</script>
  <?php endif; ?>
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
$query_unit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit = '$id'");
$barang_unit = $query_unit->fetch_object();
$barang_id = $barang_unit->id_barang;
$query = $mysqli->query("SELECT nama_barang FROM barang WHERE id_barang='$barang_id'");
$nbarang = $query->fetch_object();

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
                    <li class="breadcrumb-item active" aria-current="page">Koreksi Data </li>
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
                    <h3 class="mb-0">Koreksi Data <?= $nbarang->nama_barang?> Unit <?= $barang_unit->serial_number?></h3>
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
                $gudang_query = $mysqli->query("SELECT * FROM gudang");
                $employee_q =$mysqli->query("SELECT emp_name, id_employee FROM employee")
                ?>
              <div class="card-body">
                <form action="../backend/update-units.php" method="post">
                  <h6 class="heading-small text-muted mb-4">Lengkapi Data Dibawah</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-nama-comment">Comment on unit</label>
                          <input type="text" id="input-nama-comment" name="comment" class="form-control" value="<?= $barang_unit->comment; ?>">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-sku">Status</label>
                          <select class="form-control" name="status" id="status" required>
                                <option value="">Pilih Status</option>
                                <option value="0">Tersedia</option>
                                <option value="1">Dipinjam/Digunakan</option>
                                <option value="2">Dalam Perbaikan</option>
                                <option value="3">Rusak Total/Hilang</option>
                            </select>
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="gudang">Pilih Gudang </label>
                            <select   class="form-control" name="idgudang" id="gudang">
                                <option value="">Pilih Gudang</option>
                                <?php while ($gudang = $gudang_query->fetch_object()): ?>
                                    <option value="<?= $gudang->id_gudang; ?>"><?= $gudang->Nama_gudang; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                      </div>  
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="empid">Pilih Karyawan </label>
                            <select   class="form-control" name="empid" id="empid">
                                <option value="">Pilih Karyawan</option>
                                <?php while ($emp_data = $employee_q->fetch_object()): ?>
                                    <option value="<?= $emp_data->id_employee; ?>"><?= $emp_data->emp_name; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="condition-input">Pilih Kondisi</label>
                            <select   class="form-control" name="condition" id="condition" required>
                                <option value="">Kondisi Barang</option>
                                    <option value="0">Tidak Ada Kerusakan</option>
                                    <option value="1">Kerusakan Ringan</option>
                                    <option value="2">Kerusakan Sedang. Komponen hilang, masih fungsional</option>
                                    <option value="3">Kerusakan Berat. Butuh perbaikan</option>
                                    <option value="4">Rusak Total</option>
                            </select>
                            
                        </div>
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="id_unit" value="<?= $barang_unit->id_unit; ?>">
                  <div class="text-center">
                    <button class="btn btn-primary my-4">Koreksi Data</button>
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
<script>
document.getElementById('status').addEventListener('change', function() {
    var status = this.value;
    var gudang = document.getElementById('gudang');
    var empid = document.getElementById('empid');

    if (status == "0" || status == "3") {
        // Gudang is required if status is 0 (Tersedia) or 3 (Rusak Total/Hilang)
        gudang.required = true;
    } else {
        gudang.required = false;
    }

    if (status == "1") {
        // Employee is required if status is 1 (Dipinjam/Digunakan)
        empid.required = true;
    } else {
        empid.required = false;
    }
});
</script>
</html>
