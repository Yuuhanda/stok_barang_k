<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Riwayat Penggunaan Unit</title>
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
<?php @$id = $_GET['id']; 
@$start_date = $_GET['start_date'];
@$end_date = $_GET['end_date'];?>
<?php
// Sanitize $id to prevent SQL injection
$id = isset($id) ? (int)$id : NULL;
$start_date = isset($start_date) ? (int)$start_date : NULL;
$end_date = isset($end_date) ? (int)$end_date : NULL;

if($id != NULL){
$qunit = $mysqli->query("SELECT * FROM barang_unit WHERE id_unit = $id");
$unit_data = $qunit->fetch_object();
$id_barang = $unit_data->id_barang;
$query = $mysqli->query("SELECT nama_barang FROM barang WHERE id_barang='$id_barang'");
$nbarang = $query->fetch_object();}
else{}?>

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
                  <?php if(isset($id)):?>
                  <li class="breadcrumb-item active" aria-current="page">Log Riwayat <?php echo $nbarang->nama_barang; ?> UNIT <?=$unit_data->serial_number?></li>
                  <?php else:?>
                  <li class="breadcrumb-item active" aria-current="page">Log Semua Unit</li>
                  <?php endif?>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
            <?php if ($id != NULL && isset($_GET['start_date']) && isset($_GET['end_date'])): ?>
                <a href="../backend/log-export.php?id=<?= $id; ?>&start_date=<?= $_GET['start_date']; ?>&end_date=<?= $_GET['end_date']; ?>" class="btn btn-sm btn-neutral">Cetak Laporan</a>
            <?php elseif ($id == NULL && isset($_GET['start_date']) && isset($_GET['end_date'])): ?>
                <a href="../backend/log-export.php?start_date=<?= $_GET['start_date']; ?>&end_date=<?= $_GET['end_date']; ?>" class="btn btn-sm btn-neutral">Cetak Laporan</a>
            <?php elseif ($id != NULL && !isset($_GET['start_date']) && !isset($_GET['end_date'])): ?>
                <a href="../backend/log-export.php?id=<?= $id; ?>" class="btn btn-sm btn-neutral">Cetak Laporan</a>
            <?php else: ?>
                <a href="../backend/log-export.php" class="btn btn-sm btn-neutral">Cetak Laporan</a>
            <?php endif; ?>

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
              <!-- Date filter form -->
            <form method="GET" action="">
              <div class="row">
                <div class="col-md-1">
                  <label for="start_date">Start Date</label>
                  <input type="hidden" name="id" id="id" class="form-control small-input" value="<?= isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                  <input type="date" name="start_date" id="start_date" class="form-control small-input" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                </div>
                <div class="col-md-1">
                  <label for="end_date">End Date</label>
                  <input type="date" name="end_date" id="end_date" class="form-control small-input" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                </div>
                <div class="col-md-1">
                  <label>&nbsp;</label>
                  <button type="submit" class=" btn-primary btn-block small-btn">Filter</button>
                </div>
              </div>
            </form>
            <!-- End of Date filter form -->

            
            
            </div>
            <div class="table-responsive">
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
                  // Initialize the query
                  $query_str = "SELECT * FROM unit_log";
                  $where_conditions = [];

                  // Check for ID filtering
                  if ($id !== NULL) {
                    $where_conditions[] = "id_unit = " . (int)$id;
                  }
                
                  // Check if date filters are set
                  if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                    $start_date = $_GET['start_date'];
                    $end_date = $_GET['end_date'];

                    // Validate that both dates are set
                    if (!empty($start_date) && !empty($end_date)) {
                      // Add the date range to the where conditions
                      $where_conditions[] = "DATE(datetime) BETWEEN '$start_date' AND '$end_date'";
                    }
                  }
                
                  // Combine all conditions into the query string
                  if (!empty($where_conditions)) {
                    $query_str .= " WHERE " . implode(" AND ", $where_conditions);
                  }
                
                  // Order by date
                  $query_str .= " ORDER BY datetime DESC";
                
                  // Execute the query
                  $query = $mysqli->query($query_str);
                
                  // Fetch and display the log data
                  while ($log = $query->fetch_object()) { ?>
                    <tr>
                      <td width="5%"><?= $log->content; ?></td>
                      <td width="5%"><?= $log->datetime; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <!-- End of Projects table -->   
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <?php include("asset/footer.php"); ?>
  </div>
</div>
<?php include("asset/js.php"); ?>

<style>
  .small-input {
  height: 30px; /* Set a smaller height for the input fields */
  font-size: 0.9rem; /* Smaller font size */
}

.small-btn {
  height: 30px; /* Match the button height to the input fields */
  font-size: 0.8rem; /* Smaller font size for the button */
}

</style>
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

    if ($.fn.DataTable.isDataTable('#file')) {
        // Destroy the existing instance before reinitializing
        $('#file').DataTable().destroy();
    }

    $('#file').DataTable({
        "order": [[1, "desc"]] 
    });

  });
</script>
</body>

</html>
