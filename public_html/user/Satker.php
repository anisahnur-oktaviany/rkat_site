<?php
require 'koneksi.php';
require 'function.php';
$id_id = $_GET["id"];
$datatest = array();

$ambil = $koneksi->query("SELECT * FROM tgj WHERE id_tgj = $id_id");
while ($tiap = $ambil->fetch_assoc()) {
  $datatest[] = $tiap;
}

  foreach ($datatest as
  &$value0) {
    
  $value0['output'] = array();
  $ambil1 = $koneksi->query("SELECT * FROM output_user LEFT JOIN compile_output
  ON output_user.id_compile=compile_output.id_compile LEFT JOIN sasaran_strategis
  ON compile_output.id_sasaranstrategis=sasaran_strategis.id_sasaranstrategis LEFT JOIN indikator_utama
  ON compile_output.id_indikatorutama=indikator_utama.id_indikatorutama LEFT JOIN sasaran_program
  ON compile_output.id_sasaranprogram=sasaran_program.id_sasaranprogram LEFT JOIN indikator_program
  ON compile_output.id_indikatorprogram=indikator_program.id_indikatorprogram LEFT JOIN indikator_kegiatan
  ON compile_output.id_indikatorkegiatan=indikator_kegiatan.id_indikatorkegiatan LEFT JOIN output
  ON compile_output.id_output=output.id_output LEFT JOIN program
  ON compile_output.id_program=program.id_program LEFT JOIN kegiatan
  ON compile_output.id_kegiatan=kegiatan.id_kegiatan LEFT JOIN tgj 
  ON output_user.id_tgj=tgj.id_tgj
  WHERE output_user.id_tgj = $id_id");
  while ($tiap1 = $ambil1->fetch_assoc()) {
    $value0['output'][] = $tiap1;
  }

  foreach ($value0['output']
    as  &$value1) {
      
    $value1['komponen'] = array();
    $idOutput = $value1['id_output_user'];
    $ambil2 = $koneksi->query("SELECT * FROM komponen where id_output_user = $idOutput");
    while ($tiap2 = $ambil2->fetch_assoc()) {
    $value1['komponen'][] = $tiap2;
  }

  foreach ($value1['komponen']
    as &$value2) {
    $value2['aktivitas'] = array();
    $idKomponen = $value2['id_komponen'];
    $ambil3 = $koneksi->query("SELECT * FROM aktivitas where id_komponen = $idKomponen");
    while ($tiap3 = $ambil3->fetch_assoc()) {
      $value2['aktivitas'][] = $tiap3;
    }
    foreach ($value2['aktivitas'] as
      &$value3) {
      $value3['header'] = array();
      $idAktivitas = $value3['id_aktivitas'];
      $ambil4 = $koneksi->query("SELECT * FROM header left join akun on header.id_akun = akun.id_akun where id_aktivitas = $idAktivitas");
      while ($tiap4 = $ambil4->fetch_assoc()) {
        $value3['header'][] = $tiap4;
      }
      foreach ($value3['header'] as
        &$value4) {
        $value4['detail'] = array();
        $idAkun = $value4['id_header'];
        $ambil5 = $koneksi->query("SELECT * FROM detail 
        where detail.id_header = $idAkun");
        while ($tiap5 = $ambil5->fetch_assoc()) {
          $value4['detail'][] = $tiap5;
        }
        }
      }
    }
  }
}





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
  <script src="table2excel.js"> </script>
</head>

<body id=" page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'sidebar.php'; ?>
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
          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for
                    your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>
            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Message Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="..." />
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">
                      Hi there! I am wondering if you can help me with a
                      problem I've been having.
                    </div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="..." />
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">
                      I have the photos that you ordered last month, how would
                      you like them sent to you?
                    </div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="..." />
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">
                      Last month's report looks great, I am very happy with
                      the progress so far, keep up the good work!
                    </div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="..." />
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">
                      Am I a good boy? The reason I ask is because someone
                      told me that people say this to all dogs, even if they
                      aren't good...
                    </div>
                    <div class="small text-gray-500">
                      Chicken the Dog · 2w
                    </div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg" />
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <button id="downloadexcel" class="btn btn-success"> Download Form A </button>
          <button id="downloadexcel2" class="btn btn-success"> Download Form B </button>
          <button id="downloadexcel3" class="btn btn-success"> Download Form C </button> <br> <br>
          <div class="card shadow mb-10">

            <div class="card-body" style="overflow-x: auto">

              <table id="example-table" class="table table-bordered" style="width: 100%">
                <center>
                  <h5> Form A</h5>
                </center>
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center">Kode</th>
                    <th rowspan="2" style="text-align: center">Program</th>
                    <th rowspan="2" style="text-align: center">Target</th>
                    <th rowspan="2" style="text-align: center">Satuan</th>
                    <th colspan="3" style="text-align: center">Alokasi</th>
                  </tr>
                  <tr>
                    <td>Non Insentif</td>
                    <td>Insentif</td>
                    <td>Jumlah</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($value0['output'] as &$output) :
                    ?>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranstrategis'] ?></td>
                      <td><?= $output['nama_sasaranstrategis'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorutama'] ?></td>
                      <td><?= $output['nama_indikatorutama'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_program'] ?></td>
                      <td><?= $output['nama_program'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranprogram'] ?></td>
                      <td><?= $output['nama_sasaranprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorprogram'] ?></td>
                      <td><?= $output['nama_indikatorprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_kegiatan'] ?></td>
                      <td><?= $output['nama_kegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorkegiatan'] ?></td>
                      <td><?= $output['nama_indikatorkegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_output'] ?></td>
                      <td><?= $output['nama_output'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <?php
                    foreach ($output['komponen'] as &$komponen) :
                    ?>
                      <tr style="empty-cells: hide">
                        <td></td>
                        <td><?= $komponen['nama_komponen'] ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php
                      foreach ($komponen['aktivitas'] as &$aktivitas) :
                      
                      ?>
                        <tr style="empty-cells: hide">
                          <td></td>
                          <td><?= $aktivitas['nama_aktivitas'] ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                        <?php foreach ($aktivitas['header'] as &$akun)   :
                        $ambil1 = $koneksi->query("SELECT * FROM detail join header on detail.id_header = header.id_header join akun where header.id_akun = akun.id_akun");
                        
                        while ($tiap = mysqli_fetch_array($ambil1)) {
                          $volume[] = $tiap['volume_detail'] ;
                          $harga[] = $tiap['harga_detail'] ;
                          $total = $tiap['volume_detail'] * $tiap['harga_detail'] ;
                          $totalharga =+ $total;
                          
                        }
                        ?>
                          <tr style="empty-cells: hide">
                            <td><?= $akun['kode_akun'] ?></td>
                            <td><?= $akun['nama_akun'] ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?= $totalharga ?></td>
                          </tr>
                          <?php foreach ($akun['detail'] as &$detail) :
                            $subharga = $detail['harga_detail'] * $detail['volume_detail'];
                          ?>
                            <tr style="empty-cells: hide">
                              <td></td>
                              <td><?= $detail['nama_detail'] ?></td>
                              <td><?= $detail['volume_detail'] ?></td>
                              <td><?= $detail['satuan_detail'] ?></td>
                              <td><?php echo $detail['alokasi_detail'] == "Non Inisitif Strategis" ? $subharga : ""; ?></td>
                              <td><?php echo $detail['alokasi_detail'] == "Inisitif Strategis" ? $subharga : ""; ?></td>
                              <td><?= $subharga ?></td>
                            </tr>
                  <?php endforeach;
                        endforeach; 
                      endforeach;
                    endforeach;
                  endforeach ?>
                </tbody>
              </table>

              <script>
                document.getElementById('downloadexcel').addEventListener('click', function() {
                  var table2excel = new Table2Excel();
                  table2excel.export(document.querySelectorAll("#example-table"));
                });
              </script>
            </div>
          </div>
          <br> <br>
          <div class="card shadow mb-10">

            <div class="card-body" style="overflow-x: auto">

              <table id="example-table2" class="table table-bordered" style="width: 100%">
                <center>
                  <h5> Form B</h5>
                </center>
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center">Kode</th>
                    <th rowspan="2" style="text-align: center">Program</th>
                    <th rowspan="2" style="text-align: center">Target</th>
                    <th rowspan="2" style="text-align: center">Satuan</th>
                    <th colspan="3" style="text-align: center">Alokasi</th>
                  </tr>
                  <tr>
                    <td>Non Insentif</td>
                    <td>Insentif</td>
                    <td>Jumlah</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($value0['output'] as &$output) :
                    ?>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranstrategis'] ?></td>
                      <td><?= $output['nama_sasaranstrategis'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorutama'] ?></td>
                      <td><?= $output['nama_indikatorutama'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_program'] ?></td>
                      <td><?= $output['nama_program'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranprogram'] ?></td>
                      <td><?= $output['nama_sasaranprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorprogram'] ?></td>
                      <td><?= $output['nama_indikatorprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_kegiatan'] ?></td>
                      <td><?= $output['nama_kegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorkegiatan'] ?></td>
                      <td><?= $output['nama_indikatorkegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_output'] ?></td>
                      <td><?= $output['nama_output'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <?php
                    foreach ($output['komponen'] as &$komponen) :
                    ?>
                      <tr style="empty-cells: hide">
                        <td></td>
                        <td><?= $komponen['nama_komponen'] ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php
                      foreach ($komponen['aktivitas'] as &$aktivitas) :

                      ?>
                        <tr style="empty-cells: hide">
                          <td></td>
                          <td><?= $aktivitas['nama_aktivitas'] ?></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                  <?php endforeach;
                        endforeach;
                  endforeach ?>
                </tbody>
              </table>

              <script>
                document.getElementById('downloadexcel2').addEventListener('click', function() {
                  var table2excel = new Table2Excel();
                  table2excel.export(document.querySelectorAll("#example-table2"));
                });
              </script>
            </div>
          </div>
          <br> <br>
          <div class="card shadow mb-10">

            <div class="card-body" style="overflow-x: auto">

              <table id="example-table3" class="table table-bordered" style="width: 100%">
                <center>
                  <h5> Form C</h5>
                </center>
                <thead>
                  <tr>
                    <th rowspan="2" style="text-align: center">Kode</th>
                    <th rowspan="2" style="text-align: center">Program</th>
                    <th rowspan="2" style="text-align: center">Target</th>
                    <th rowspan="2" style="text-align: center">Satuan</th>
                    <th colspan="3" style="text-align: center">Alokasi</th>
                  </tr>
                  <tr>
                    <td>Non Insentif</td>
                    <td>Insentif</td>
                    <td>Jumlah</td>
                  </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($value0['output'] as &$output) :
                    ?>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranstrategis'] ?></td>
                      <td><?= $output['nama_sasaranstrategis'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorutama'] ?></td>
                      <td><?= $output['nama_indikatorutama'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_program'] ?></td>
                      <td><?= $output['nama_program'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_sasaranprogram'] ?></td>
                      <td><?= $output['nama_sasaranprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorprogram'] ?></td>
                      <td><?= $output['nama_indikatorprogram'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_kegiatan'] ?></td>
                      <td><?= $output['nama_kegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_indikatorkegiatan'] ?></td>
                      <td><?= $output['nama_indikatorkegiatan'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr style="empty-cells: hide">
                      <td><?= $output['kode_output'] ?></td>
                      <td><?= $output['nama_output'] ?></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <?php 
                  endforeach ?>
                </tbody>
              </table>
                </tbody>
              </table>

              <script>
                document.getElementById('downloadexcel3').addEventListener('click', function() {
                  var table2excel = new Table2Excel();
                  table2excel.export(document.querySelectorAll("#example-table3"));
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
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">
            Cancel
          </button>
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