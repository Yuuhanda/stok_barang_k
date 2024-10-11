<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Barang Detail</title>
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
<?php
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit = $id");
$unit_data = $qunit->fetch_object();
$id_barang = $unit_data->id_barang;
$query = $mysqli->query("SELECT nama_barang FROM barang WHERE id_barang='$id_barang'");
$nbarang = $query->fetch_object();?>

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
                  <li class="breadcrumb-item active" aria-current="page">Log Riwayat <?php echo $nbarang->nama_barang; ?> UNIT <?=$unit_data->serial_number?></li>
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
              
              </div> 
              <!-- Projects table -->
              <table id="file" class="table striped">
                <thead>
                  <tr>
                    <td width="5%"><strong>Log</strong></td>
                    <td width="5%"><strong>Tanggal</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $mysqli->query("SELECT * FROM unit_log WHERE id_unit = $id");
                  while ($log = $query->fetch_object()) {?>
                      <tr>
                          <td width="5%"><?= $log->content; ?></td>
                          <td width="5%">TBD</td>
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
</body>

</html>
