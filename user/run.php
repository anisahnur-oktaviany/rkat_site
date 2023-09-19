<?php
session_start();
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
  $value0['total'] = 0;
  $value0['total_non'] = 0;
  $ambil1 = $koneksi->query("SELECT * FROM output_user LEFT JOIN compile_output
  ON output_user.id_compile=compile_output.id_compile LEFT JOIN sasaran_strategis
  ON compile_output.id_sasaranstrategis=sasaran_strategis.id_sasaranstrategis LEFT JOIN indikator_utama
  ON compile_output.id_indikatorutama=indikator_utama.id_indikatorutama LEFT JOIN sasaran_program
  ON compile_output.id_sasaranprogram=sasaran_program.id_sasaranprogram LEFT JOIN indikator_program
  ON compile_output.id_indikatorprogram=indikator_program.id_indikatorprogram LEFT JOIN indikator_kegiatan
  ON compile_output.id_indikatorkegiatan=indikator_kegiatan.id_indikatorkegiatan LEFT JOIN sasaran_kegiatan
  ON compile_output.id_sasarankegiatan=sasaran_kegiatan.id_sasarankegiatan LEFT JOIN output
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
    $value1['total'] = 0;
    $value1['total_non'] = 0;
    $idOutput = $value1['id_output_user'];
    $ambil2 = $koneksi->query("SELECT * FROM komponen where id_output_user = $idOutput");
    while ($tiap2 = $ambil2->fetch_assoc()) {
    $value1['komponen'][] = $tiap2;
  }
  foreach ($value1['komponen']
    as &$value2) {
    $value2['aktivitas'] = array();
    $value2['total'] = 0;
    $value2['total_non'] = 0;
    $idKomponen = $value2['id_komponen'];
    $ambil3 = $koneksi->query("SELECT * FROM aktivitas where id_komponen = $idKomponen");
    while ($tiap3 = $ambil3->fetch_assoc()) {
      $value2['aktivitas'][] = $tiap3;
    }
    foreach ($value2['aktivitas'] as
      &$value3) {
      $value3['header'] = array();
      $value3['total'] = 0;
      $value3['total_non'] = 0;
      $idAktivitas = $value3['id_aktivitas'];
      $ambil4 = $koneksi->query("SELECT * FROM header left join akun on header.id_akun = akun.id_akun 
      left join aktivitas on header.id_aktivitas = aktivitas.id_aktivitas 
      where aktivitas.id_aktivitas = $idAktivitas");
      while ($tiap4 = $ambil4->fetch_assoc()) {
        $value3['header'][] = $tiap4;
      }
      foreach ($value3['header'] as
        &$value4) {
        $value4['detail'] = array();
        $value4['total'] = 0;
        $value4['total_non'] = 0;
        $idAkun = $value4['id_header'];
        $ambil5 = $koneksi->query("SELECT * FROM detail 
        where detail.id_header = $idAkun");
        while ($tiap5 = $ambil5->fetch_assoc()) {
          $value4['detail'][] = $tiap5;
        }
        foreach ($value4['detail'] as
        &$value5) {
        if ($value5['alokasi_detail'] == "Non Inisitif Strategis") {
          $value4['total_non'] += $value5['harga_detail'] * $value5['volume_detail'];
        } else if ($value5['alokasi_detail'] == "Inisitif Strategis") {
          $value4['total'] +=  $value5['harga_detail'] * $value5['volume_detail'];
        }
      }
      $value3['total'] += $value4['total'];
      $value3['total_non'] += $value4['total_non'];
      }
      $value2['total'] += $value3['total'];
      $value2['total_non'] += $value3['total_non'];
    }
    $value1['total'] += $value2['total'];
    $value1['total_non'] += $value2['total_non'];
  }
  $value0['total'] += $value1['total'];
  $value0['total_non'] += $value1['total_non'];
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
                      <div class="small text-gray-500">December 7, 2019</div> $290.29 has been deposited into your account!
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                    </div>
                    <div>
                      <div class="small text-gray-500">December 2, 2019</div> Spending Alert: We've noticed unusually high spending for your account.
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
                      <div class="text-truncate"> Hi there! I am wondering if you can help me with a problem I've been having. </div>
                      <div class="small text-gray-500">Emily Fowler · 58m</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="..." />
                      <div class="status-indicator"></div>
                    </div>
                    <div>
                      <div class="text-truncate"> I have the photos that you ordered last month, how would you like them sent to you? </div>
                      <div class="small text-gray-500">Jae Chun · 1d</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="..." />
                      <div class="status-indicator bg-warning"></div>
                    </div>
                    <div>
                      <div class="text-truncate"> Last month's report looks great, I am very happy with the progress so far, keep up the good work! </div>
                      <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                    </div>
                  </a>
                  <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="dropdown-list-image mr-3">
                      <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="..." />
                      <div class="status-indicator bg-success"></div>
                    </div>
                    <div>
                      <div class="text-truncate"> Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good... </div>
                      <div class="small text-gray-500"> Chicken the Dog · 2w </div>
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
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings </a>
                  <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log </a>
                  <div class="dropdown-divider"></div>
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
            <button id="downloadexcel" class="btn btn-success"> Download Form C </button>
            <button id="downloadexcel2" class="btn btn-success"> Download Form B </button>
            <button id="downloadexcel3" class="btn btn-success"> Download Form A </button>
            <br>
            <br>
            <div class="card shadow mb-10">
              <div class="card-body" style="overflow-x: auto">
                <div id="divTableDataHolder">
                  <table id="example-table" class="table table-bordered" style="width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2" style="text-align: center; border: 1px solid black">FORMULIR C</th>
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
                        <th style="text-align: center; border: 1px solid black">Regular</th>
                        <th style="text-align: center; border: 1px solid black">Inisiatif Strategis</th>
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
                    <tbody> <?php
                      $noSasgis = 1;
                      foreach ($value0['output'] as &$output) :
                        $suboutput = $output['total'] + $output['total_non'];
                      ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranstrategis'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Strategis <?= $noSasgis++ ?>: </b>
                          <br> <?= $output['nama_sasaranstrategis'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                        
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noIKU = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKU  </b>
                          <br> <?= $output['nama_indikatorutama'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorutama']) ?> </td>
                        <td style="border-right: 1px solid black"><?= $output['satuan_indikatorutama'] ?></td>
                        <td style="border-right: 1px solid black"></td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noProgram = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_program'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Program  </b>
                          <br> <?= $output['nama_program'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                    
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php $noSaspro = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Program  </b>
                          <br> <?= $output['nama_sasaranprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                     
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noOutput = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKP  </b>
                          <br> <?= $output['nama_indikatorprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorprogram']) ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorprogram'] ?> </td>                        
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noKegiatan = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_kegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Kegiatan  </b>
                          <br> <?= $output['nama_kegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                       
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php $noSasgik = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasarankegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Kegiatan </b>
                          <br> <?= $output['nama_sasarankegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                       
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noIndgik = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorkegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKK </b>
                          <br> <?= $output['nama_indikatorkegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorkegiatan']) ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorkegiatan'] ?> </td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noOutput = 1; ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_output'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Output <?= $noOutput++ ?>: </b>
                          <br> <?= $output['nama_output'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_output']) ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_output'] ?> </td>                     
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php
                      $noKomponen = 1;
                      foreach ($output['komponen'] as &$komponen) :
                      $subkomponen = $komponen['total'] + $komponen['total_non'];?> 
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $komponen['kode_komponen'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>&nbsp;&nbsp;Komponen <?= $noKomponen++ ?>: </b>
                          <br>&nbsp;&nbsp;<?= $komponen['nama_komponen'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                      
                        <td style="border-right: 1px solid black"> <?= number_format($komponen['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($komponen['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($subkomponen)?> </td>
                      </tr> 
                      <?php
                      $noAktivitas = 1;
                      foreach ($komponen['aktivitas'] as $key3 =>$aktivitas):
                        $subaktivitas= $aktivitas['total'] + $aktivitas['total_non'];
                      ?> 
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $aktivitas['kode_aktivitas'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>&nbsp;&nbsp;&nbsp;&nbsp;Aktifitas <?= $noAktivitas++ ?>: </b>
                          <br>&nbsp;&nbsp;&nbsp;&nbsp;<?= $aktivitas['nama_aktivitas'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                       
                        <td style="border-right: 1px solid black"> <?= number_format($aktivitas['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($aktivitas['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($subaktivitas)?> </td>
                      </tr> 
                      <?php $noAkun = 1;
                      foreach ($aktivitas['header'] as &$akun) :
                          $total = 0;
                          $subakun= $akun['total'] + $akun['total_non'];
                      ?> 
                      <tr style="empty-cells: hide">
                        <td style="border-bottom: 1px dashed black; border-left: 1px solid black; border-right: 1px solid black"> <?= $akun['kode_akun'] ?> </td>
                        <td style="border-bottom: 1px dashed black; border-right: 1px solid black">
                          <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Akun <?= $noAkun++ ?>: </b>
                          <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $akun['nama_akun'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                        
                        <td style="border-right: 1px solid black"> <?= number_format($akun['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($akun['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($subakun) ?> </td>
                      </tr>                       
                        <?php foreach ($akun['detail'] as &$detail) :
                          $subharga =  $detail['harga_detail'] * $detail['volume_detail'];
                        ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $detail['nama_detail'] ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($detail['volume_detail']) ?> </td>                    
                        <td style="border-right: 1px solid black"> <?= $detail['satuan_detail'] ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($detail['harga_detail']) ?> </td>
                        <td style="border-right: 1px solid black"> <?php echo $detail['alokasi_detail'] == "Non Inisitif Strategis" ? number_format($subharga) : 0; ?> </td>
                        <td style="border-right: 1px solid black"> <?php echo $detail['alokasi_detail'] == "Inisitif Strategis" ? number_format($subharga) :0; ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($subharga) ?> </td>
                      </tr>
                        <?php endforeach;
                        endforeach;
                      endforeach;
                    endforeach;
                  endforeach ?>
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
            <br>
            <br>
            <div class="card shadow mb-10">
              <div class="card-body" style="overflow-x: auto">
                <div id="divTableDataHolder2">
                  <table id="example-table" class="table table-bordered" style="width: 100%">
                    <thead>
                      <tr>
                        <th colspan="2" style="text-align: center; border: 1px solid black">FORMULIR B</th>
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
                        <th style="text-align: center; border: 1px solid black ">Regular</th>
                        <th style="text-align: center; border: 1px solid black ">Inisiatif Strategis</th>
                        <th style="text-align: center; border: 1px solid black ">Jumlah</th>
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
                    <tbody> <?php
                      $no = 1;
                      foreach ($value0['output'] as &$output) :
                        $suboutput = $output['total'] + $output['total_non'];
                      ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranstrategis'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Strategis <?= $no++ ?>: </b>
                          <br> <?= $output['nama_sasaranstrategis'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                        
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKU <?= $no++ ?>: </b>
                          <br> <?= $output['nama_indikatorutama'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorutama']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black"></td>                       
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_program'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Program <?= $no++ ?>: </b>
                          <br> <?= $output['nama_program'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Program <?= $no++ ?>: </b>
                          <br> <?= $output['nama_sasaranprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKP <?= $no++ ?>: </b>
                          <br> <?= $output['nama_indikatorprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorprogram']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorprogram'] ?></td>
                        <td style="border-right: 1px solid black"> </td>    
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php 
                      endforeach;
                      ?>
                  </tbody>
                </table>
                <script>
                    $('[id$=downloadexcel2]').click(function(e) {
                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('div[id$=divTableDataHolder2]').html()));
                      e.preventDefault()
                    });
                  </script>
              </div>
            </div>
            <br>
            <br>
            <div class="card shadow mb-10">
              <div class="card-body" style="overflow-x: auto">
                <div id="divTableDataHolder3">
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
                        <th style="text-align: center; border: 1px solid black ">Regular</th>
                        <th style="text-align: center; border: 1px solid black ">Inisiatif Strategis</th>
                        <th style="text-align: center; border: 1px solid black ">Jumlah</th>
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
                   <tbody> <?php
                      $no = 1;
                      foreach ($value0['output'] as &$output) :
                        $suboutput = $output['total'] + $output['total_non'];
                      ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranstrategis'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Strategis <?= $no++ ?>: </b>
                          <br> <?= $output['nama_sasaranstrategis'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKU <?= $no++ ?>: </b>
                          <br> <?= $output['nama_indikatorutama'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorutama']) ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorutama'] ?> </td>                     
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_program'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Program <?= $no++ ?>: </b>
                          <br> <?= $output['nama_program'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                   
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasaranprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Program <?= $no++ ?>: </b>
                          <br> <?= $output['nama_sasaranprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKP <?= $no++ ?>: </b>
                          <br> <?= $output['nama_indikatorprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorprogram']) ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorprogram'] ?> </td>                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_kegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Kegiatan <?= $no++ ?>: </b>
                          <br> <?= $output['nama_kegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total_non']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['total']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($suboutput) ?> </td>
                      </tr> <?php $no = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_sasarankegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Kegiatan <?= $no++ ?>: </b>
                          <br> <?= $output['nama_sasarankegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                       
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr> <?php $noIndgik = 1; ?> <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $output['kode_indikatorkegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKK </b>
                          <br> <?= $output['nama_indikatorkegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($output['volume_indikatorkegiatan']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $output['satuan_indikatorkegiatan'] ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <script>
                    $('[id$=downloadexcel3]').click(function(e) {
                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('div[id$=divTableDataHolder3]').html()));
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