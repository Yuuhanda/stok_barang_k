<?php
     ?>
<?php @$id = $_GET['id']; ?>
<?php @$alert = $_GET['alert'];?>
<?php if ($alert==1): ?>
        <script>alert('Nomor Seri Unit Tidak Ada');</script>
    <?php elseif($alert==2): ?>
        <script>alert('Unit dengan nomor seri ini tidak ada');</script>
  <?php endif; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Barang Dalam Perbaikan</title>
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
                  <li class="breadcrumb-item active" aria-current="page">Barang Dalam Perbaikan</li>
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
                    <td width="5%"><strong>Nama Barang</strong></td>
                    <td width="5%"><strong>Nomor Seri</strong></td>
                    <td width="5%"><strong>Gudang/User</strong></td>
                    <td width="5%"><strong>Data diperbarui oleh</strong></td>
                    <td width="5%"><strong>Komentar</strong></td>
                    <td width="5%"><strong>Kondisi</strong></td>
                    <td width="5%"><strong>Aksi</strong></td>
                  </tr>
                </thead>
               <tbody>
                  <?php
                  $query = $mysqli->query("SELECT barang.nama_barang AS nama_barang, barang_unit.kondisi AS kondisi, barang_unit.serial_number AS serial_number ,barang_unit.id_unit AS id_unit, barang_unit.status AS status, user.nama_user AS nama_user, gudang.Nama_gudang AS nama_gudang, employee.emp_name AS emp_name, barang_unit.comment AS comment
FROM barang_unit 
LEFT JOIN barang 
  ON barang.id_barang = barang_unit.id_barang
LEFT JOIN gudang
  ON barang_unit.id_gudang = gudang.id_gudang
LEFT JOIN employee
  ON barang_unit.id_employee = employee.id_employee
LEFT JOIN user
  ON user.id_user = barang_unit.id_user
WHERE barang_unit.status= '2'");
                  while ($barang = $query->fetch_object()) { ?>
                    <tr>
                    <?php $stats_b = $barang->status;
                    $kondisi = $barang->kondisi;?>
                        <td width="5%"><?= $barang->nama_barang; ?></td>
                        <td width="5%"><?= $barang->serial_number; ?></td>
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
                        <td>
                            <a href="return-repair.php?id=<?= $barang->id_unit ?>" class="btn btn-sm btn-info">Selesaikan Perbaikan</a>
                        </td>                           
                    </td>
                  </tr>
                  <?php
                } ?>
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
