<?php
session_start();
$koneksi= new mysqli("localhost", "root", "", "rkatsite_tapera") or die ("Koneksi gagal");
 //echo "<pre>"; 
 //print_r($_SESSION);
 //echo "</pre>";
 //session masuk paksa
    if (!isset($_SESSION['Admin'])) {
    echo "<script> alert('Anda harus login') </script>";
    echo "<script> location='../login.php' </script>";
    exit();
}

require 'koneksi.php';
require 'function.php';



// MARK: NEW METHOD
// Construct Pengadaan
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.id_pengadaan,
    view_grand_table.nama_pengadaan
  FROM
    view_grand_table
  ;
");
$grand_result_pengadaan = [
  "total_reg"=>0,
  "total_str"=>0,
  "total"=>0
];
while ($result_pengadaan = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.id_pengadaan = $result_pengadaan[id_pengadaan]
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_pengadaan += $sub_statement->fetch_assoc();
  $grand_result_pengadaan['total_reg'] += $result_pengadaan['total_reg'];
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.id_pengadaan = $result_pengadaan[id_pengadaan]
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_pengadaan += $sub_statement->fetch_assoc();
  $grand_result_pengadaan['total_str'] += $result_pengadaan['total_str'];
  $sub_statement->close();

  // calculate total
  $grand_result_pengadaan['total'] += $result_pengadaan['total_reg'] + $result_pengadaan['total_str'];
}
$statement->close();

// Construct Sasaran Strategis
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_sasaranstrategis,
    view_grand_table.nama_sasaranstrategis
  FROM
    view_grand_table
  ;
");
while ($result_sasaran_strategis = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.kode_sasaranstrategis = '$result_sasaran_strategis[kode_sasaranstrategis]'
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_sasaran_strategis += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.kode_sasaranstrategis = '$result_sasaran_strategis[kode_sasaranstrategis]'
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_sasaran_strategis += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_sasaran_strategis['total'] = $result_sasaran_strategis['total_reg'] + $result_sasaran_strategis['total_str'];


  // Construct IKU
  $statement_iku = $koneksi->query("
    SELECT DISTINCT
      view_grand_table.kode_indikatorutama,
      view_grand_table.nama_indikatorutama,
      view_grand_table.volume_indikatorutama,
      view_grand_table.satuan_indikatorutama
    FROM
      view_grand_table
    WHERE
      view_grand_table.kode_sasaranstrategis = '$result_sasaran_strategis[kode_sasaranstrategis]'
    ;
  ");
  $result_sasaran_strategis['IKU'] = $statement_iku->fetch_all(MYSQLI_ASSOC);
  $statement_iku->close();

  $result['Sasaran Strategis'][] = $result_sasaran_strategis;
}
$statement->close();
// MARK END: NEW METHOD

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin | Satker</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" />
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $("#example tr td").each(function() {
          var emptyrows = $.trim($(this).text());
          if (emptyrows.length == 0) {
            $(this).hide();
          }
        });
      });
    </script>
    <script src="table2excel.js"></script>
  </head>
  <body id=" page-top">
    <!-- Page Wrapper -->
    <div id="wrapper"> <?php include 'sidebar.php'; ?>
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
            </button>
            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- Nav Item - User Information -->
              <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["User"]["nama_rawtgj"]?></span>
                  <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout </a>
                </div>
              </li>
            </ul>
          </nav>
          <!-- End of Topbar -->
          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- Page Heading -->
           
            <button id="downloadexcel3" class="btn btn-success"> Download Form A </button>    
            <br>
            <br>
            <div class="card shadow mb-10">
              <div class="card-body" style="overflow-x: auto">
                <div id="divTableDataHolder">
                  <table id="example-table" class="table table-bordered" style="width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2" style="text-align: center; border: 1px solid black">FORMULIR A</th>
                        <th colspan="3" style="text-align: center; border: 1px solid black">RENCANA KERJA DAN ANGARAN <br> BP TAPERA <br> TA 2023 </th>
                        <td colspan="3" style="text-align: center; border: 1px solid black">
                          <img src="https://rkat.site/user/img/login.jpg" width="50" height="50">
                        </td>
                      </tr>
                      <tr>
                        <th rowspan="2" style="text-align: center; border: 1px solid black">Kode</th>
                        <th rowspan="2" style="text-align: center; border: 1px solid black">Uraian</th>
                        <th rowspan="2" style="text-align: center; border: 1px solid black">Volume</th>
                       
                        <th rowspan="2" style="text-align: center; border: 1px solid black">Satuan</th>
                        <th rowspan="2" style="text-align: center; border: 1px solid black">Total Biaya</th>
                        <th colspan="3" style="text-align: center; border: 1px solid black">Alokasi</th>
                      </tr>
                      <tr>
                        <th style="text-align: center; border: 1px solid black">OPEX</th>
                        <th style="text-align: center; border: 1px solid black">CAPEX</th>
                        <th style="text-align: center; border: 1px solid black">Jumlah</th>
                      </tr>
                      <tr>
                        <td style="text-align: center; border: 1px solid black">[1]</td>
                        <td style="text-align: center; border: 1px solid black">[2]</td>
                        <td style="text-align: center; border: 1px solid black">[3]</td>
                       
                        <td style="text-align: center; border: 1px solid black">[5]</td>
                        <td style="text-align: center; border: 1px solid black">[6]</td>
                        <td style="text-align: center; border: 1px solid black">[7]</td>
                        <td style="text-align: center; border: 1px solid black">[8]</td>
                        <td style="text-align: center; border: 1px solid black">[9]</td>
                      </tr>
                    </thead>
                    <tbody>
                    
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= number_format($grand_result_pengadaan['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($grand_result_pengadaan['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($grand_result_pengadaan['total']) ?> </td>

                      <?php
                      $noSasgis = 1;
                      foreach ($result['Sasaran Strategis'] as &$result_sasaran_strategis):                
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_sasaran_strategis['kode_sasaranstrategis'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Strategis <?= $noSasgis++ ?>: </b>
                          <br> <?= $result_sasaran_strategis['nama_sasaranstrategis'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                  
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total']) ?> </td>

                      <?php
                        $noIKU = 1;
                        foreach($result_sasaran_strategis['IKU'] as $result_iku):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_iku['kode_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKU <?= $noIKU++ ?>:</b>
                          <br> <?= $result_iku['nama_indikatorutama'] ?>
                        </td>
                        <td style="border-right: 1px solid black"><?= number_format($result_iku['volume_indikatorutama']) ?></td>
                        <td style="border-right: 1px solid black"><?= $result_iku['satuan_indikatorutama'] ?></td>
                        <td style="border-right: 1px solid black"></td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>   
                      <?php
                        endforeach;
                      ?>

                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>
                      <?php
                      endforeach;
                      ?>
                      
                    </tbody>
                  </table>
                  <script>
                    $('[id$=downloadexcel]').click(function(e) {
                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('div[id$=divTableDataHolder]').html()));
                      e.preventDefault()
                    });
                  </script>

              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <footer class="sticky-footer bg-white">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright &copy; Your Website 2020</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body"> Select "Logout" below if you are ready to end your current session. </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"> Cancel </button>
            <a class="btn btn-primary" href="login.html">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
  </body>
</html>