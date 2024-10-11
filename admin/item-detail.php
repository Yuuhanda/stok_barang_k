
<?php @$id = $_GET['id']; ?>

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



<?php
$query = $mysqli->query("SELECT nama_barang FROM barang WHERE id_barang='$id'");
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $nbarang->nama_barang; ?></li>
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
                    <td width="5%"><strong>Nomor Seri</strong></td>
                    <td width="5%"><strong>Status</strong></td>
                    <td width="5%"><strong>Gudang/User</strong></td>
                    <td width="5%"><strong>Data diperbarui oleh</strong></td>
                    <td width="5%"><strong>Komentar</strong></td>
                    <td width="5%"><strong>Kondisi</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                 
                  $query = $mysqli->query("SELECT barang_unit.kondisi AS kondisi, barang_unit.serial_number AS serial_number, barang_unit.id_unit AS id_unit, barang_unit.status AS status,
                             user.nama_user AS nama_user, gudang.Nama_gudang AS nama_gudang, employee.emp_name AS emp_name, barang_unit.comment AS comment
                      FROM barang_unit
                      LEFT JOIN barang ON barang.id_barang = barang_unit.id_barang
                      LEFT JOIN gudang ON barang_unit.id_gudang = gudang.id_gudang
                      LEFT JOIN employee ON barang_unit.id_employee = employee.id_employee
                      LEFT JOIN user ON user.id_user = barang_unit.id_user
                      WHERE barang_unit.id_barang = $id
                      
                  ");
                
                  while ($barang = $query->fetch_object()) {
                      $status_text = '';
                      $location = '';
                  
                      switch ($barang->status) {
                          case 0:
                              $status_text = "Tersedia/Disimpan";
                              $location = $barang->nama_gudang;
                              break;
                          case 1:
                              $status_text = "Dipinjam/Digunakan";
                              $location = $barang->emp_name;
                              break;
                          case 2:
                              $status_text = "Dalam Perbaikan";
                              $location = "Tidak Tersedia";
                              break;
                          case 3:
                              $status_text = "Rusak Total/Hilang";
                              $location = $barang->nama_gudang;
                              break;
                          default:
                              $status_text = "Unknown status";
                              $location = "Status tidak diketahui";
                              break;
                      }
                    
                      switch ($barang->kondisi) {
                          case 0:
                              $kondisi_text = "Tidak ada kerusakan";
                              break;
                          case 1:
                              $kondisi_text = "Kerusakan Ringan";
                              break;
                          case 2:
                              $kondisi_text = "Kerusakan Sedang. Komponen Hilang";
                              break;
                          case 3:
                              $kondisi_text = "Kerusakan Berat. Tidak bisa digunakan";
                              break;
                          case 4:
                              $kondisi_text = "Rusak Total/Hilang";
                              break;
                          default:
                              $kondisi_text = "Unknown status";
                              break;
                      }
                      ?>
                      <tr>
                          <td width="5%"><?= $barang->serial_number; ?></td>
                          <td width="5%"><?= $status_text; ?></td>
                          <td width="5%"><?= $location; ?></td>
                          <td width="5%"><?= $barang->nama_user ?? 'DELETED USER'; ?></td>
                          <td><?= $barang->comment; ?></td>
                          <td width="5%"><?= $kondisi_text; ?></td>
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
