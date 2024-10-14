<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Daftar Peminjaman</title>
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
                  <li class="breadcrumb-item active" aria-current="page">Daftar Peminjaman</li>
                </ol>
              </nav>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <a href="../backend/lending-export.php" class="btn btn-sm btn-neutral">Cetak Laporan Peminjaman</a>
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
                    <td width="5%"><strong>Karyawan</strong></td>
                    <td width="5%"><strong>Data diperbarui oleh</strong></td>
                    <td width="5%"><strong>Tanggal</strong></td>
                    <td width="5%"><strong>Kondisi</strong></td>
                    <td width="5%"><strong>Aksi</strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                 
                  $query = $mysqli->query("SELECT bu.kondisi AS kondisi, bu.serial_number AS serial_number, bu.id_unit AS id_unit, bu.status AS status, u.nama_user AS nama_user, g.Nama_gudang AS nama_gudang, e.emp_name AS emp_name, bu.comment AS comment, ul.datetime AS datetime
                    FROM 
                        barang_unit bu
                    LEFT JOIN 
                        barang b ON b.id_barang = bu.id_barang
                    LEFT JOIN 
                        gudang g ON bu.id_gudang = g.id_gudang
                    LEFT JOIN 
                        employee e ON bu.id_employee = e.id_employee
                    LEFT JOIN 
                        user u ON u.id_user = bu.id_user
                    LEFT JOIN 
                        unit_log ul ON ul.id_unit = bu.id_unit
                    INNER JOIN (
                        SELECT 
                            id_unit, MAX(datetime) AS latest_datetime
                        FROM 
                            unit_log
                        GROUP BY 
                            id_unit
                    ) latest_logs ON ul.id_unit = latest_logs.id_unit AND ul.datetime = latest_logs.latest_datetime
                    WHERE 
                        bu.status = '1';
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
                          <td width="5%"><?= $location; ?></td>
                          <td width="5%"><?= $barang->nama_user ?? 'DELETED USER'; ?></td>
                          <td><?= $barang->datetime; ?></td>
                          <td width="5%"><?= $kondisi_text; ?></td>
                          <td><a href="return-select.php?id=<?= $barang->id_unit; ?>" class="btn btn-sm btn-info">Kembalikan Unit Unit</a></td>
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
