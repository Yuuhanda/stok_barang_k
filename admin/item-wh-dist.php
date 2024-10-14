<?php @$id = $_GET['id']; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lokasi Barang</title>
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

<?php $barangQ= $mysqli->query("SELECT * FROM barang WHERE id_barang = $id");?>
<?php $barangData = $barangQ->fetch_object();?>
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
                  <li class="breadcrumb-item active" aria-current="page">Lokasi Barang <?=$barangData->nama_barang?></li>
                </ol>
              </nav>
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
                  <h3 class="mb-0"></h3>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table id="file" class="table striped">
    <thead>
        <tr>
            <td width="20%"><strong>Nama Gudang</strong></td>
            <td width="5%"><strong>Unit Tersedia</strong></td>
            <td width="5%"><strong>Unit Rusak Total/Hilang</strong></td>
        </tr>
    </thead>
    <tbody>
        <?php
        $whquery = $mysqli->query("SELECT * FROM gudang");  // Fetch all warehouses
        while ($whdata = $whquery->fetch_object()) {
            // For each warehouse, fetch the item count and group by status
            $counterQuery = $mysqli->query("SELECT 
                    COUNT(CASE WHEN TRIM(barang_unit.status) = '0' AND id_barang = $id THEN 1 END) AS available,
                    COUNT(CASE WHEN TRIM(barang_unit.status) = '3' AND id_barang = $id THEN 1 END) AS lost
                FROM barang_unit
                WHERE barang_unit.id_gudang = '$whdata->id_gudang'
            ");
            $counterData = $counterQuery->fetch_object(); ?>
            <tr>
                <td><?= $whdata->Nama_gudang; ?></td> <!-- Display warehouse name -->
                <td><?= $counterData->available; ?></td> <!-- Units available -->
                <td><?= $counterData->lost; ?></td> <!-- Units lost/damaged -->
            </tr>
        <?php } ?>
    </tbody>
</table>

            <!-- end table -->
          </div>
        </div>
      </div>
    </div>
    <?php include("asset/footer.php"); ?>
  </div>
</div>
<?php include("asset/js.php"); ?>
</body>
<!-- Include DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    if ($.fn.DataTable.isDataTable('#file')) {
        // Destroy the existing instance before reinitializing
        $('#file').DataTable().destroy();
    }
    // Initialize DataTables
    var table = $('#file').DataTable({
      "pageLength": 10 // Default value
    });

    // Change page length dynamically
    $('#rowsPerPage').on('change', function () {
      var length = $(this).val();
      table.page.len(length).draw();
    });
  });
</script>
</html>
