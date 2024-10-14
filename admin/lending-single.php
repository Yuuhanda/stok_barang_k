<?php  ?>
<?php @$id = $_GET['id']; ?>
<?php @$alert = $_GET['alert']; ?>
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
    <?php if ($alert==1): ?>
        <script>alert('Peminjaman Sukses ditambahkan');</script>
    <?php endif ?>
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
                            <option value="" style="padding: 0px;">Pilih Unit</option>
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
<!-- Include Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery and Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- Initialize Select2 -->
<script>
  $(document).ready(function() {
    $('#id_unit').select2({
      placeholder: "Pilih Unit",
      allowClear: true,
      dropdownAutoWidth: true,
      width: 'auto'
    });
  });

  $(document).ready(function() {
    $('#empid').select2({
      placeholder: "Pilih Karyawan",
      allowClear: true,
      dropdownAutoWidth: true,
      width: 'auto'
    });
  });
</script>


<style>
  .select2-results__option:first-child {
    padding: 15px;  /* Adjust padding for empty option height */
    height: 50px;   /* Set height for the empty option */
  }

  .select2-selection__rendered {
    padding: 15px;  /* Increase padding for the selected item */
    height: auto;   /* Allow dynamic height based on padding */
    line-height: 2; /* Adjust for proper vertical spacing */
  }
</style>

<style>
  /* Adjusting the height and padding for select input */
  select.form-control {
    height: 50px; /* Increase height */
    padding: 10px; /* Add padding for better spacing */
    font-size: 16px; /* Adjust font size */
    line-height: 1.5; /* Improve line spacing */
  }

  /* For Select2 dropdown (if you're using it) */
  .select2-container .select2-selection--single {
    height: 50px; /* Match the select field height */
    padding: 10px; /* Add padding to match */
    font-size: 16px;
  }

  /* Ensure that the placeholder text is aligned properly */
  .select2-selection__rendered {
    line-height: 2.5 !important; /* Adjust line height for placeholder */
  }
</style>


<!-- Custom styles for Select2 dropdown and option text -->
<style>
  .select2-container .select2-dropdown {
    max-height: 300px; /* Adjust height to fit text */
  }

  .select2-results__options {
    max-height: 300px;
  }

  .select2-results__option {
    line-height: 1.5; /* Increase line height for text clarity */
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    white-space: normal; /* Ensure long text fits */
  }
</style>
</html>
