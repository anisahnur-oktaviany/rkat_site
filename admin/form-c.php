<?php
session_start();
$koneksi= new mysqli("localhost", "root", "", "rkatsite_tapera") or die ("Koneksi gagal");
 //echo "<pre>"; 
 //print_r($_SESSION);
 //echo "</pre>";
 //session masuk paksa
    if (!isset($_SESSION['User'])) {
    echo "<script> alert('Anda harus login') </script>";
    echo "<script> location='../login.php' </script>";
    exit();
}

require 'koneksi.php';
require 'function.php';

$datatest = array();


foreach ($datatest as &$value0) {
  $value0['output'] = array();
  $value0['total'] = 0;
  $value0['total_non'] = 0;
  $ambil1 = $koneksi->query("
    SELECT
      *
    FROM
      output_user
      LEFT JOIN compile_output
        ON output_user.id_compile = compile_output.id_compile
      LEFT JOIN sasaran_strategis
        ON compile_output.id_sasaranstrategis = sasaran_strategis.id_sasaranstrategis
      LEFT JOIN indikator_utama
        ON compile_output.id_indikatorutama = indikator_utama.id_indikatorutama
      LEFT JOIN sasaran_program
        ON compile_output.id_sasaranprogram = sasaran_program.id_sasaranprogram
      LEFT JOIN indikator_program
        ON compile_output.id_indikatorprogram = indikator_program.id_indikatorprogram
      LEFT JOIN indikator_kegiatan
        ON compile_output.id_indikatorkegiatan = indikator_kegiatan.id_indikatorkegiatan
      LEFT JOIN sasaran_kegiatan
        ON compile_output.id_sasarankegiatan = sasaran_kegiatan.id_sasarankegiatan
      LEFT JOIN output
        ON compile_output.id_output = output.id_output
      LEFT JOIN program
        ON compile_output.id_program = program.id_program
      LEFT JOIN kegiatan
        ON compile_output.id_kegiatan = kegiatan.id_kegiatan
    WHERE
      output_user.id_pengadaan = $id_id
  ");

  while ($tiap1 = $ambil1->fetch_assoc()) {
    $value0['output'][] = $tiap1;
  }
  $ambil1->close();
  
  foreach ($value0['output'] as &$value1) {
    $value1['komponen'] = array();
    $value1['total'] = 0;
    $value1['total_non'] = 0;
    $idOutput = $value1['id_output_user'];
    $ambil2 = $koneksi->query("SELECT * FROM komponen where id_output_user = $idOutput");

    while ($tiap2 = $ambil2->fetch_assoc()) {
      $value1['komponen'][] = $tiap2;
    }

    foreach ($value1['komponen'] as &$value2) {
      $value2['aktivitas'] = array();
      $value2['total'] = 0;
      $value2['total_non'] = 0;
      $idKomponen = $value2['id_komponen'];
      $ambil3 = $koneksi->query("SELECT * FROM aktivitas where id_komponen = $idKomponen");

      while ($tiap3 = $ambil3->fetch_assoc()) {
        $value2['aktivitas'][] = $tiap3;
      }

      foreach ($value2['aktivitas'] as &$value3) {
        $value3['header'] = array();
        $value3['total'] = 0;
        $value3['total_non'] = 0;
        $idAktivitas = $value3['id_aktivitas'];
        $ambil4 = $koneksi->query("
          SELECT
            *
          FROM
            header
            LEFT JOIN akun
              ON header.id_akun = akun.id_akun 
            LEFT JOIN aktivitas
              ON header.id_aktivitas = aktivitas.id_aktivitas 
          WHERE
            aktivitas.id_aktivitas = $idAktivitas
        ");

        while ($tiap4 = $ambil4->fetch_assoc()) {
          $value3['header'][] = $tiap4;
        }
        $ambil4->close();

        foreach ($value3['header'] as &$value4) {
          $value4['detail'] = array();
          $value4['total'] = 0;
          $value4['total_non'] = 0;
          $idAkun = $value4['id_header'];
          $ambil5 = $koneksi->query("SELECT * FROM detail WHERE detail.id_header = $idAkun");

          while ($tiap5 = $ambil5->fetch_assoc()) {
            $value4['detail'][] = $tiap5;
          }

          foreach ($value4['detail'] as &$value5) {
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

// MARK: NEW METHOD
// Construct Sasaran Strategis
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_sasaranstrategis,
    view_grand_table.nama_sasaranstrategis
  FROM
    view_grand_table
  
  ;
");
$result['Sasaran Strategis'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();

// Construct IKU
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_indikatorutama,
    view_grand_table.nama_indikatorutama,
    view_grand_table.volume_indikatorutama,
    view_grand_table.satuan_indikatorutama
  FROM
    view_grand_table
 
  ;
");
$result['IKU'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();

// Construct Program
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_program,
    view_grand_table.nama_program
  FROM
    view_grand_table
  
  ;
");
while ($result_program = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.kode_program = '$result_program[kode_program]'
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_program += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.kode_program = '$result_program[kode_program]'
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_program += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_program['total'] = $result_program['total_reg'] + $result_program['total_str'];

  $result['Program'][] = $result_program;
}
$statement->close();

// Construct Sasaran Program
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_sasaranprogram,
    view_grand_table.nama_sasaranprogram
  FROM
    view_grand_table
  ;
");
$result['Sasaran Program'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();

// Construct IKP
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_indikatorprogram,
    view_grand_table.nama_indikatorprogram,
    view_grand_table.volume_indikatorprogram,
    view_grand_table.satuan_indikatorprogram
  FROM
    view_grand_table
  ;
");
$result['IKP'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();

// Construct Kegiatan
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_kegiatan,
    view_grand_table.nama_kegiatan
  FROM
    view_grand_table
  ;
");
while ($result_kegiatan = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.kode_kegiatan = '$result_kegiatan[kode_kegiatan]'
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_kegiatan += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.kode_kegiatan = '$result_kegiatan[kode_kegiatan]'
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_kegiatan += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_kegiatan['total'] = $result_kegiatan['total_reg'] + $result_kegiatan['total_str'];

  $result['Kegiatan'][] = $result_kegiatan;
}
$statement->close();

// Construct Sasaran Kegiatan
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_sasarankegiatan,
    view_grand_table.nama_sasarankegiatan
  FROM
    view_grand_table
  ;
");
$result['Sasaran Kegiatan'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();

// Construct IKK
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_indikatorkegiatan,
    view_grand_table.nama_indikatorkegiatan,
    view_grand_table.volume_indikatorkegiatan,
    view_grand_table.satuan_indikatorkegiatan
  FROM
    view_grand_table
  ;
");
$result['IKK'] = $statement->fetch_all(MYSQLI_ASSOC);
$statement->close();


// Construct Output
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_output,
    view_grand_table.nama_output,
    view_grand_table.volume_output,
    view_grand_table.satuan_output
  FROM
    view_grand_table
  ;
");
while ($result_output = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.kode_output = '$result_output[kode_output]'
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_output += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.kode_output = '$result_output[kode_output]'
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_output += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_output['total'] = $result_output['total_reg'] + $result_output['total_str'];

  // Construct Komponen
  $sub_statement = $koneksi->query("
    SELECT DISTINCT
      view_final_table.kode_komponen,
      view_final_table.nama_komponen
    FROM
      view_final_table
    WHERE
      view_final_table.kode_output = '$result_output[kode_output]'
    ;
  ");
  while ($result_komponen = $sub_statement->fetch_assoc()) {
    // // handle empty
    // if (!isset($result_komponen['kode_komponen'])) { continue; }

    // calculate non inisiatif strategis total
    $sub_sub_statement = $koneksi->query("
      SELECT
        SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
      FROM
        view_final_table
      WHERE
          view_final_table.kode_output = '$result_output[kode_output]'
          AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
          AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
      ;
    ");
    $result_komponen += $sub_sub_statement->fetch_assoc();
    $sub_sub_statement->close();
  
    // calculate inisiatif strategis total
    $sub_sub_statement = $koneksi->query("
      SELECT
        SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
      FROM
        view_final_table
      WHERE
          view_final_table.kode_output = '$result_output[kode_output]'
          AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
          AND view_final_table.alokasi_detail = 'Inisitif Strategis'
      ;
    ");
    $result_komponen += $sub_sub_statement->fetch_assoc();
    $sub_sub_statement->close();
  
    // calculate grand total
    $result_komponen['total'] = $result_komponen['total_reg'] + $result_komponen['total_str'];
  
    // Construct Aktivitas
    $sub_sub_statement = $koneksi->query("
      SELECT DISTINCT
        view_final_table.kode_aktivitas,
        view_final_table.nama_aktivitas
      FROM
        view_final_table
      WHERE
        view_final_table.kode_output = '$result_output[kode_output]'
        AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
      ;
    ");
    while ($result_aktivitas = $sub_sub_statement->fetch_assoc()) {
      // calculate non inisiatif strategis total
      $sub_sub_sub_statement = $koneksi->query("
        SELECT
          SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
        FROM
          view_final_table
        WHERE
            view_final_table.kode_output = '$result_output[kode_output]'
            AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
            AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
            AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
        ;
      ");
      $result_aktivitas += $sub_sub_sub_statement->fetch_assoc();
      $sub_sub_sub_statement->close();
    
      // calculate inisiatif strategis total
      $sub_sub_sub_statement = $koneksi->query("
        SELECT
          SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
        FROM
          view_final_table
        WHERE
            view_final_table.kode_output = '$result_output[kode_output]'
            AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
            AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
            AND view_final_table.alokasi_detail = 'Inisitif Strategis'
        ;
      ");
      $result_aktivitas += $sub_sub_sub_statement->fetch_assoc();
      $sub_sub_sub_statement->close();
    
      // calculate grand total
      $result_aktivitas['total'] = $result_aktivitas['total_reg'] + $result_aktivitas['total_str'];
    
      // Construct Akun
      $sub_sub_sub_statement = $koneksi->query("
        SELECT DISTINCT
          view_final_table.kode_akun,
          view_final_table.nama_akun
        FROM
          view_final_table
        WHERE
          view_final_table.kode_output = '$result_output[kode_output]'
          AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
          AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
        ;
      ");
      while ($result_akun = $sub_sub_sub_statement->fetch_assoc()) {
        // calculate non inisiatif strategis total
        $sub_sub_sub_sub_statement = $koneksi->query("
          SELECT
            SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
          FROM
            view_final_table
          WHERE
              view_final_table.kode_output = '$result_output[kode_output]'
              AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
              AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
              AND view_final_table.kode_akun = '$result_akun[kode_akun]'
              AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
          ;
        ");
        $result_akun += $sub_sub_sub_sub_statement->fetch_assoc();
        $sub_sub_sub_sub_statement->close();
      
        // calculate inisiatif strategis total
        $sub_sub_sub_sub_statement = $koneksi->query("
          SELECT
            SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
          FROM
            view_final_table
          WHERE
              view_final_table.kode_output = '$result_output[kode_output]'
              AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
              AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
              AND view_final_table.kode_akun = '$result_akun[kode_akun]'
              AND view_final_table.alokasi_detail = 'Inisitif Strategis'
          ;
        ");
        $result_akun += $sub_sub_sub_sub_statement->fetch_assoc();
        $sub_sub_sub_sub_statement->close();
      
        // calculate grand total
        $result_akun['total'] = $result_akun['total_reg'] + $result_akun['total_str'];
      
        // Construct Detail
        $sub_sub_sub_sub_statement = $koneksi->query("
          SELECT
            view_final_table.nama_detail,
            view_final_table.volume_detail,
            view_final_table.satuan_detail,
            view_final_table.harga_detail,
            IF(
              view_final_table.alokasi_detail = 'Non Inisitif Strategis',
              view_final_table.volume_detail * view_final_table.harga_detail,
              0
            ) AS total_reg,
            IF(
              view_final_table.alokasi_detail = 'Inisitif Strategis',
              view_final_table.volume_detail * view_final_table.harga_detail,
              0
            ) AS total_str
          FROM
            view_final_table
          WHERE
            view_final_table.kode_output = '$result_output[kode_output]'
            AND view_final_table.kode_komponen = '$result_komponen[kode_komponen]'
            AND view_final_table.kode_aktivitas = '$result_aktivitas[kode_aktivitas]'
            AND view_final_table.kode_akun = '$result_akun[kode_akun]'
          ;
        ");
        while ($result_detail = $sub_sub_sub_sub_statement->fetch_assoc()) {
          // calculate grand total
          $result_detail['total'] = $result_detail['total_reg'] + $result_detail['total_str'];

          $result_akun['Detail'][] = $result_detail;
        }
        $sub_sub_sub_sub_statement->close();
      
        $result_aktivitas['Akun'][] = $result_akun;
      }
      $sub_sub_sub_statement->close();
    
      $result_komponen['Aktivitas'][] = $result_aktivitas;
    }
    $sub_sub_statement->close();
  
    $result_output['Komponen'][] = $result_komponen;
  }
  $sub_statement->close();

  $result['Output'][] = $result_output;
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
                    <?php
                      $noSasgis = 1;
                      foreach ($result['Sasaran Strategis'] as &$result_sasaran_strategis):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>    
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      <?php       
                    endforeach;
                      ?>
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
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>    
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        
                      <?php
                    endforeach;
                      ?>
                      <?php
                      $noIKU = 1;
                      foreach ($result['IKU'] as &$result_iku):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_iku['kode_indikatorutama'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKU <?= $noIKU++ ?>:</b>
                          <br> <?= $result_iku['nama_indikatorutama'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_iku['volume_indikatorutama']) ?> </td>
                        <td style="border-right: 1px solid black"><?= $result_iku['satuan_indikatorutama'] ?></td>
                        <td style="border-right: 1px solid black"></td>
                       
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>
                      <?php
                      endforeach;
                      ?>
                      <?php
                      $noProgram = 1;
                      foreach ($result['Program'] as &$result_program):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_program['kode_program'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Program <?= $noProgram++ ?>:</b>
                          <br> <?= $result_program['nama_program'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                    
                        <td style="border-right: 1px solid black"> <?= number_format($result_program['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_program['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_program['total']) ?> </td>
                      </tr>
                      <?php
                      endforeach;
                      ?>
                      <?php
                      $noSaspro = 1;
                      foreach ($result['Sasaran Program'] as &$result_sasaran_program):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_sasaran_program['kode_sasaranprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Program <?= $noSaspro++ ?>:</b>
                          <br> <?= $result_sasaran_program['nama_sasaranprogram'] ?>
                        </td>
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
                      <?php
                      $noIKP = 1;
                      foreach ($result['IKP'] as &$result_ikp):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_ikp['kode_indikatorprogram'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKP <?= $noIKP++ ?>:</b>
                          <br> <?= $result_ikp['nama_indikatorprogram'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_ikp['volume_indikatorprogram']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $result_ikp['satuan_indikatorprogram'] ?> </td>
                        <td style="border-right: 1px solid black"></td>
                        
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>
                      <?php
                      endforeach;
                      ?>
                      <?php
                      $noKegiatan = 1;
                      foreach ($result['Kegiatan'] as &$result_kegiatan):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_kegiatan['kode_kegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Kegiatan <?= $noKegiatan++ ?>:</b>
                          <br> <?= $result_kegiatan['nama_kegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                       
                        <td style="border-right: 1px solid black"> <?= number_format($result_kegiatan['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_kegiatan['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_kegiatan['total']) ?> </td>
                      </tr>
                      <?php
                      endforeach;
                      ?>
                      <?php
                      $noSasgik = 1;
                      foreach ($result['Sasaran Kegiatan'] as &$result_sasaran_kegiatan):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_sasaran_kegiatan['kode_sasarankegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Sasaran Kegiatan <?= $noSasgik++ ?>:</b>
                          <br> <?= $result_sasaran_kegiatan['nama_sasarankegiatan'] ?>
                        </td>
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
                      <?php
                      $noIndgik = 1;
                      foreach ($result['IKK'] as &$result_ikk):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_ikk['kode_indikatorkegiatan'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>IKK <?= $noIndgik++ ?>:</b>
                          <br> <?= $result_ikk['nama_indikatorkegiatan'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_ikk['volume_indikatorkegiatan']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $result_ikk['satuan_indikatorkegiatan'] ?> </td>
                        <td style="border-right: 1px solid black"></td>
                      
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                      </tr>
                      <?php
                      endforeach;
                      ?>

                      <?php
                      $noOutput = 1;
                      foreach ($result['Output'] as &$result_output):
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_output['kode_output'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>Output <?= $noOutput++ ?>: </b>
                          <br> <?= $result_output['nama_output'] ?>
                        </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_output['volume_output']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= $result_output['satuan_output'] ?> </td>
                        <td style="border-right: 1px solid black"></td>                  
                        <td style="border-right: 1px solid black"> <?= number_format($result_output['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_output['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_output['total']) ?> </td>
                      </tr>
                        <?php
                        $noKomponen = 1;
                        foreach (($result_output['Komponen'] ?? array()) as &$result_komponen):
                        ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_komponen['kode_komponen'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>&nbsp;&nbsp;Komponen <?= $noKomponen++ ?>: </b>
                          <br>&nbsp;&nbsp;<?= $result_komponen['nama_komponen'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                       
                        <td style="border-right: 1px solid black"> <?= number_format($result_komponen['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_komponen['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_komponen['total'])?> </td>
                      </tr> 
                          <?php
                          $noAktivitas = 1;
                          foreach (($result_komponen['Aktivitas'] ?? array()) as &$result_aktivitas):
                          ?> 
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"> <?= $result_aktivitas['kode_aktivitas'] ?> </td>
                        <td style="border-right: 1px solid black">
                          <b>&nbsp;&nbsp;&nbsp;&nbsp;Aktifitas <?= $noAktivitas++ ?>: </b>
                          <br>&nbsp;&nbsp;&nbsp;&nbsp;<?= $result_aktivitas['nama_aktivitas'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                       
                        <td style="border-right: 1px solid black"> <?= number_format($result_aktivitas['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_aktivitas['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_aktivitas['total'])?> </td>
                      </tr> 
                            <?php
                            $noAkun = 1;
                            foreach (($result_aktivitas['Akun']?? array()) as &$result_akun):
                            ?> 
                      <tr style="empty-cells: hide">
                        <td style="border-bottom: 1px dashed black; border-left: 1px solid black; border-right: 1px solid black"> <?= $result_akun['kode_akun'] ?> </td>
                        <td style="border-bottom: 1px dashed black; border-right: 1px solid black">
                          <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Akun <?= $noAkun++ ?>: </b>
                          <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $result_akun['nama_akun'] ?>
                        </td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        
                        <td style="border-right: 1px solid black"> <?= number_format($result_akun['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_akun['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_akun['total']) ?> </td>
                      </tr> 
                              <?php
                              foreach (($result_akun['Detail'] ?? array()) as &$result_detail):
                              ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $result_detail['nama_detail'] ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_detail['volume_detail']) ?> </td>
                     
                        <td style="border-right: 1px solid black"> <?= $result_detail['satuan_detail'] ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_detail['harga_detail']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_detail['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_detail['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_detail['total']) ?> </td>
                      </tr>
                      <?php
                              endforeach;
                            endforeach;
                          endforeach;
                        endforeach;
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