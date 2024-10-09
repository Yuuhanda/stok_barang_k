<?php
     ?>
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
                  $query = $mysqli->query("SELECT barang_unit.kondisi AS kondisi, barang_unit.serial_number AS serial_number ,barang_unit.id_unit AS id_unit, barang_unit.status AS status, user.nama_user AS nama_user, gudang.Nama_gudang AS nama_gudang, employee.emp_name AS emp_name, barang_unit.comment AS comment
                          FROM barang_unit 
                          LEFT JOIN barang 
                            ON barang.id_barang = barang_unit.id_barang
                          LEFT JOIN gudang
                            ON barang_unit.id_gudang = gudang.id_gudang
                          LEFT JOIN employee
                            ON barang_unit.id_employee = employee.id_employee
                          LEFT JOIN user
                            ON user.id_user = barang_unit.id_user
                          WHERE barang_unit.id_barang = $id");
                  while ($barang = $query->fetch_object()) { ?>
                    <tr>
                    <?php $stats_b = $barang->status;
                    $kondisi = $barang->kondisi;?>
                        <td width="5%"><?= $barang->serial_number; ?></td>
                        <?php if ($stats_b == 0): ?>
                            <td width="5%">Tersedia/Disimpan</td>
                        <?php elseif ($stats_b == 1): ?>
                            <td width="5%">Dipinjam/Digunakan</td>
                        <?php elseif ($stats_b == 2): ?>
                            <td width="5%">Dalam Perbaikan</td>
                        <?php elseif ($stats_b == 3): ?>
                            <td width="5%">Rusak Total/Hilang</td>
                        <?php else: ?>
                            <td width="5%">Unknown status</td>
                        <?php endif; ?>                                        
                        <?php                        
                        if ($stats_b == 0): ?>
                            <td width="5%"><?= $barang->nama_gudang; ?></td>
                        <?php elseif ($stats_b == 1): ?>
                            <td width="5%"><?= $barang->emp_name; ?></td>
                        <?php elseif ($stats_b == 2): ?>
                            <td width="5%">Tidak Tersedia</td>
                        <?php elseif ($stats_b == 3): ?>
                            <td width="5%"><?= $barang->nama_gudang; ?></td>
                        <?php else: ?>
                            <td width="5%">Status tidak diketahui</td>
                        <?php endif; ?>
                        <?php if( $barang->nama_user==NULL){?>
                          <td>DELETED USER</td>
                          <?php } else {?>
                        <td><?= $barang->nama_user; ?></td>
                        <?php } ?>
                        <td><?= $barang->comment; ?></td>
                        <?php if ($kondisi == 0): ?>
                            <td width="5%">Tidak ada kerusakan</td>
                        <?php elseif ($kondisi == 1): ?>
                            <td width="5%">Kerusakan Ringan</td>
                        <?php elseif ($kondisi == 2): ?>
                            <td width="5%">kerusakan Sedang. Komponen Hilang</td>
                        <?php elseif ($kondisi == 3): ?>
                            <td width="5%">Kerusakan Berat. Tidak bisa digunakan</td>
                        <?php elseif ($kondisi == 4): ?>
                            <td width="5%">Rusak Total/Hilang</td>
                        <?php else: ?>
                            <td width="5%">Unknown status</td>
                        <?php endif; ?>                            
                    </td>
                  </tr>
                  <?php
                } ?>
              </tbody>
            </table>
            <!-- end table -->
            <div class="col-lg-6 col-5 text-left">
            <!-- Rows per page dropdown 
            <div class="form-group">
                    <label for="rowsPerPage" style="font-size: 12px;">Rows per page:</label>
                    <select id="rowsPerPage" class="form-control" style="width: 50px; font-size: 12px; padding: 2px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </div>-->
            </div>
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
