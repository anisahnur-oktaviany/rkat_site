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
$id_id = $_GET["id"];


// MARK: NEW METHOD
// Construct Pengadaan
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.id_pengadaan,
    view_grand_table.nama_pengadaan
  FROM
    view_grand_table
  WHERE
    view_grand_table.id_pengadaan = $id_id
  ;
");
while ($result_pengadaan = $statement->fetch_assoc()) {
  // calculate non inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_reg
    FROM
      view_final_table
    WHERE
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.alokasi_detail = 'Non Inisitif Strategis'
    ;
  ");
  $result_pengadaan += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate inisiatif strategis total
  $sub_statement = $koneksi->query("
    SELECT
      SUM(view_final_table.volume_detail * view_final_table.harga_detail) AS total_str
    FROM
      view_final_table
    WHERE
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_pengadaan += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_pengadaan['total'] = $result_pengadaan['total_reg'] + $result_pengadaan['total_str'];

  $result['Pengadaan'][] = $result_pengadaan;
}
$statement->close();

// Construct Sasaran Strategis
$statement = $koneksi->query("
  SELECT DISTINCT
    view_grand_table.kode_sasaranstrategis,
    view_grand_table.nama_sasaranstrategis
  FROM
    view_grand_table
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_sasaranstrategis = '$result_sasaran_strategis[kode_sasaranstrategis]'
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_sasaranstrategis = '$result_sasaran_strategis[kode_sasaranstrategis]'
        AND view_final_table.alokasi_detail = 'Inisitif Strategis'
    ;
  ");
  $result_sasaran_strategis += $sub_statement->fetch_assoc();
  $sub_statement->close();

  // calculate grand total
  $result_sasaran_strategis['total'] = $result_sasaran_strategis['total_reg'] + $result_sasaran_strategis['total_str'];

  $result['Sasaran Strategis'][] = $result_sasaran_strategis;
}
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_program = '$result_program[kode_program]'
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_program = '$result_program[kode_program]'
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_kegiatan = '$result_kegiatan[kode_kegiatan]'
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_kegiatan = '$result_kegiatan[kode_kegiatan]'
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
  WHERE
    view_grand_table.id_pengadaan = $id_id
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_output = '$result_output[kode_output]'
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_output = '$result_output[kode_output]'
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
      view_final_table.id_pengadaan = $id_id
      AND view_final_table.kode_output = '$result_output[kode_output]'
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
          view_final_table.id_pengadaan = $id_id
          AND view_final_table.kode_output = '$result_output[kode_output]'
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
          view_final_table.id_pengadaan = $id_id
          AND view_final_table.kode_output = '$result_output[kode_output]'
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
        view_final_table.id_pengadaan = $id_id
        AND view_final_table.kode_output = '$result_output[kode_output]'
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
            view_final_table.id_pengadaan = $id_id
            AND view_final_table.kode_output = '$result_output[kode_output]'
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
            view_final_table.id_pengadaan = $id_id
            AND view_final_table.kode_output = '$result_output[kode_output]'
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
          view_final_table.id_pengadaan = $id_id
          AND view_final_table.kode_output = '$result_output[kode_output]'
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
              view_final_table.id_pengadaan = $id_id
              AND view_final_table.kode_output = '$result_output[kode_output]'
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
              view_final_table.id_pengadaan = $id_id
              AND view_final_table.kode_output = '$result_output[kode_output]'
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
            view_final_table.id_pengadaan = $id_id
            AND view_final_table.kode_output = '$result_output[kode_output]'
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
            <button id="downloadexcel" class="btn btn-success"> Download Form C (XLS) </button>
            
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
                      foreach ($result['Pengadaan'] as &$result_pengadaan):          
                      ?>
                      <tr style="empty-cells: hide">
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_pengadaan['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_pengadaan['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_pengadaan['total']) ?> </td>
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
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                  
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total']) ?> </td>
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
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
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
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                  
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total']) ?> </td>
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
                        <td style="border-left: 1px solid black; border-right: 1px solid black"></td>
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
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>
                        <td style="border-right: 1px solid black"></td>                  
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_reg']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total_str']) ?> </td>
                        <td style="border-right: 1px solid black"> <?= number_format($result_sasaran_strategis['total']) ?> </td>
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
                    </tbody>
                  </table>
                  <script>
                    $('[id$=downloadexcel3]').click(function(e) {
                      window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('div[id$=divTableDataHolder3]').html()));
                      e.preventDefault()
                    });
                  </script>
                                    <script type="text/javascript">
                    window.print();
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