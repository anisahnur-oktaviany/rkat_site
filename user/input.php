<?php
session_start();
//echo "<pre>"; 
//print_r($_SESSION);
//echo "</pre>";
require 'koneksi.php';
require 'function.php';
$id_id = $_GET["id"];


$datacompiletgj = array();
$ambil = $koneksi->query("SELECT * FROM tgj LEFT JOIN raw_tgj
ON tgj.id_rawtgj = raw_tgj.id_rawtgj");
while ($tiap = $ambil->fetch_assoc()) {
    $datacompiletgj[] = $tiap;
}

$datacompileoutput = array();
$ambil = $koneksi->query("SELECT * FROM compile_output LEFT JOIN output
ON compile_output.id_output=output.id_output LEFT JOIN indikator_utama ON compile_output.id_indikatorutama = indikator_utama.id_indikatorutama");
while ($tiap = $ambil->fetch_assoc()) {
    $datacompileoutput[] = $tiap;
}

$dataoutput = array();
$ambil = $koneksi->query("SELECT * FROM output_user LEFT JOIN compile_output
ON output_user.id_compile=compile_output.id_compile LEFT JOIN output
ON compile_output.id_output=output.id_output LEFT JOIN pengadaan
ON output_user.id_pengadaan=pengadaan.id_pengadaan WHERE pengadaan.id_pengadaan= $id_id AND pengadaan.id_rawtgj = ".$_SESSION['User']['id_rawtgj']);
while ($tiap = $ambil->fetch_assoc()) {
    $dataoutput[] = $tiap;
}

$dataaktivitas = array();
$ambil = $koneksi->query("SELECT * FROM komponen LEFT JOIN output_user
ON komponen.id_output_user=output_user.id_output_user LEFT JOIN compile_output
ON output_user.id_compile=compile_output.id_compile LEFT JOIN output
ON compile_output.id_output=output.id_output WHERE id_pengadaan = $id_id");
while ($tiap = $ambil->fetch_assoc()) {
    $dataaktivitas[] = $tiap;
}

$dataheader = array();
$ambil = $koneksi->query("SELECT * FROM aktivitas LEFT JOIN komponen
ON aktivitas.id_komponen=komponen.id_komponen LEFT JOIN output_user
ON komponen.id_output_user=output_user.id_output_user LEFT JOIN compile_output
ON output_user.id_compile=compile_output.id_compile LEFT JOIN output
ON compile_output.id_output=output.id_output WHERE id_pengadaan = $id_id");
while ($tiap = $ambil->fetch_assoc()) {
    $dataheader[] = $tiap;
}

$datadetail = array();
$ambil = $koneksi->query("SELECT * FROM header LEFT JOIN aktivitas
ON header.id_aktivitas=aktivitas.id_aktivitas LEFT JOIN akun
ON header.id_akun=akun.id_akun LEFT JOIN komponen
ON aktivitas.id_komponen=komponen.id_komponen LEFT JOIN output_user
ON komponen.id_output_user=output_user.id_output_user WHERE id_pengadaan = $id_id");
while ($tiap = $ambil->fetch_assoc()) {
    $datadetail[] = $tiap;
}

$dataakun = array();
$ambil = $koneksi->query("SELECT * FROM detail LEFT JOIN header
ON detail.id_header=header.id_header LEFT JOIN akun
ON header.id_akun=akun.id_akun");
while ($tiap = $ambil->fetch_assoc()) {
    $dataakun[] = $tiap;
}

$akun = array();
$ambil = $koneksi->query("SELECT * FROM akun");
while ($tiap = $ambil->fetch_assoc()) {
    $akun[] = $tiap;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Satker</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="DataTables/DataTables-1.13.4/css/dataTables.bootstrap4.min.css">
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Output
                    </button>

                           <!-- Awal Modal Tambah -->
                           <div class="modal" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="staticBackdropLabel">Tambah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="id_pengadaan" value="<?= $id_id ?>" />
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="output">
                                                                    <option value=""> Choose Output </option>
                                                                    <?php foreach ($datacompileoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_compile"] ?>"><?php echo $value["nama_output"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                         
                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="volume_output" placeholder="Volume Output">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="satuan_output" placeholder="Satuan Output">
                                                            </div>
                                                        </div>
                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_outputuser">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>  
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                    <br><br>
                    <div class="card shadow mb-10">

                        <div class="card-body" style="overflow-x:auto">
                            <table class="table table-striped table-bordered" style="width:100%">
                            <h5>Table Output </h5>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Output</th>
                                        <th>Nama Output</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $ib = mysqli_query($conn, "SELECT * FROM output_user LEFT JOIN compile_output
                                    ON output_user.id_compile=compile_output.id_compile LEFT JOIN sasaran_strategis
                                    ON compile_output.id_sasaranstrategis=sasaran_strategis.id_sasaranstrategis LEFT JOIN indikator_utama
                                    ON compile_output.id_indikatorutama=indikator_utama.id_indikatorutama LEFT JOIN sasaran_program
                                    ON compile_output.id_sasaranprogram=sasaran_program.id_sasaranprogram LEFT JOIN indikator_program
                                    ON compile_output.id_indikatorprogram=indikator_program.id_indikatorprogram LEFT JOIN indikator_kegiatan
                                    ON compile_output.id_indikatorkegiatan=indikator_kegiatan.id_indikatorkegiatan LEFT JOIN output
                                    ON compile_output.id_output=output.id_output LEFT JOIN program
                                    ON compile_output.id_program=program.id_program LEFT JOIN kegiatan
                                    ON compile_output.id_kegiatan=kegiatan.id_kegiatan LEFT JOIN pengadaan
                                    ON output_user.id_pengadaan=pengadaan.id_pengadaan LEFT JOIN raw_tgj
                                    ON pengadaan.id_rawtgj=raw_tgj.id_rawtgj WHERE pengadaan.id_pengadaan = $id_id");
                                    while ($row = mysqli_fetch_array($ib)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['kode_output'] ?> </td>
                                            <td><?= $row['nama_output'] ?> </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalUbah<?= $no ?>"> Ubah </a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus<?= $no ?>"> Hapus</a>
                                                
                                            </td>
                                        </tr>

                                        <!-- Awal Modal Ubah-->
                                        <div class="modal" id="modalUbah<?= $no ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                               
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="id_pengadaan" value="<?php echo $id_id ?>" />
                                                        <input type="hidden" name="output_user" value="<?= $row['id_output_user'] ?>">
                                                        <div class="modal-body">
                                                             <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="output">
                                                                    <option value="<?= $row['id_compile'] ?>"> <?= $row['nama_output'] ?> </option>
                                                                    <?php foreach ($datacompileoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_compile"] ?>"><?php echo $value["nama_output"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="volumeoutput" value="<?= $row['volume_output'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="satuanoutput" value="<?= $row['satuan_output'] ?>">
                                                            </div>
                               
                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Strategis</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_sasaranstrategis"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Utama</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_indikatorutama"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Program</label>
                                                                <input type="text" id="program" readonly value="<?php echo $row["nama_program"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Program</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_sasaranprogram"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Program</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_indikatorprogram"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kegiatan</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_kegiatan"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Kegiatan</label>
                                                                <input type="text" readonly value="<?php echo $row["nama_indikatorkegiatan"]; ?>" class="form-control"> </input>                                                          
                                                            </div>

                                                            
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_outputuser">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                 
                        <!-- Awal Modal Hapus -->
                        <div class="modal" id="modalHapus<?= $no ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="POST" action="tambah_satker.php">
                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                        <input type="hidden" name="outputuser" value="<?= $row['id_output_user'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                <br>
                                                <span class="text-danger"><?= $row['nama_output'] ?> - <?= $row['volume_output'] ?></span>
                                            </h5>
                                        </div>
                                        <!-- Akhir Modal Tambah -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapus_outputuser">Hapus</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                    </table>
                    </div>
                    </div>                    
                    <br> <br>

                    <!-- Page Heading -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal0">
                        Tambah Komponen
                    </button>

                       <!-- Awal Modal Tambah -->
                       <div class="modal" id="myModal0">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="outputuser">
                                                                    <option value=""> Choose Output </option>
                                                                    <?php foreach ($dataoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_output_user"] ?>"><?php echo $value["nama_output"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Komponen</label>
                                                                <input type="text" class="form-control" name="kodekomponen" placeholder="Kode Komponen">
                                                            </div>  

                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Komponen</label>
                                                                <input type="text" class="form-control" name="namakomponen" placeholder="Nama Komponen">
                                                            </div>                                     

                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_komponen">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                </div>
                                                </form>

                                            </div>
                                        </div>
                        </div>

                    <br><br>
                    <div class="card shadow mb-10">
                        <div class="card-body" style="overflow-x:auto">
                        <h5> Table Komponen </h5>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Komponen</th>
                                        <th>Nama Komponen</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $ib = mysqli_query($conn, "SELECT * FROM komponen LEFT JOIN output_user 
                                    ON komponen.id_output_user=output_user.id_output_user LEFT JOIN compile_output
                                    ON output_user.id_compile=compile_output.id_compile LEFT JOIN output
                                    ON compile_output.id_output=output.id_output LEFT JOIN pengadaan
                                    ON output_user.id_pengadaan=pengadaan.id_pengadaan WHERE pengadaan.id_pengadaan = $id_id");
                                    while ($row = mysqli_fetch_array($ib)) :

                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['kode_komponen'] ?></td>
                                            <td><?= $row['nama_komponen'] ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalUbahkomponen<?= $no ?>"> Ubah </a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapuskomponen<?= $no ?>"> Hapus</a>                                  
                                            </td>
                                        </tr>

                                        <!-- Awal Modal Ubah-->
                                        <div class="modal" id="modalUbahkomponen<?= $no ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                               
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <input type="hidden" name="komponen" value="<?= $row['id_komponen'] ?>">
                                                        <div class="modal-body">                                                 

                                                            <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="output">
                                                                    <option value="<?= $row['id_output_user'] ?>"> <?= $row['nama_output'] ?> </option>
                                                                    <?php foreach ($dataoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_output_user"] ?>"><?php echo $value["nama_output"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Komponen</label>
                                                                <input type="text" class="form-control" name="kodekomponen" value="<?= $row['kode_komponen'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Komponen</label>
                                                                <input type="text" class="form-control" name="namakomponen" value="<?= $row['nama_komponen'] ?>">
                                                            </div>

                                                            
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_komponen">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                     
                        <!-- Awal Modal Hapus -->
                        <div class="modal" id="modalHapuskomponen<?= $no ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="POST" action="tambah_satker.php">
                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                        <input type="hidden" name="komponen" value="<?= $row['id_komponen'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                <br>
                                                <span class="text-danger"><?= $row['nama_komponen'] ?></span>
                                            </h5>
                                        </div>
                                        <!-- Akhir Modal Tambah -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapus_komponen">Hapus</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                    </table>
                    
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
                    <script type="text/javascript">
                        $('#output').change(function() { 
                            var fakultas = $(this).val(); 
                            $.ajax({
                                type: 'POST', 
                                url: 'ajax_jurusan.php', 
                                data: 'id_output=' + fakultas, 
                                success: function(response) { 
                                    $('#program').html(response); 
                                }
                            });
                        });
                
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });
                    </script>
                    </div>

                </div>

                <br> 
                    <!-- Page Heading -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal1">
                        Tambah Aktivitas
                    </button>

                    
                                        <!-- Awal Modal Tambah -->
                                        <div class="modal" id="myModal1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label class="form-label">Komponen</label>
                                                                <select class="form-control" name="komponen">
                                                                    <option value=""> Choose Komponen </option>
                                                                    <?php foreach ($dataaktivitas as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_komponen"] ?>"><?php echo $value["nama_komponen"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Aktivitas</label>
                                                                <input type="text" class="form-control" name="kodeaktivitas" placeholder="Kode Aktivitas">
                                                            </div>  

                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Aktivitas</label>
                                                                <input type="text" class="form-control" name="namaaktivitas" placeholder="Nama Aktivitas">
                                                            </div>                                     

                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_aktivitas">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                </div>
                                                </form>

                                            </div>
                                        </div>
                        </div>
                    <br><br>
                    <div class="card shadow mb-10">
                        <div class="card-body" style="overflow-x:auto">
                        <h5> Table Aktivitas </h5>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Aktivitas</th>
                                        <th>Nama Aktivitas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $ib = mysqli_query($conn, "SELECT * FROM aktivitas LEFT JOIN komponen
                                    ON aktivitas.id_komponen=komponen.id_komponen LEFT JOIN output_user ON
                                    komponen.id_output_user = output_user.id_output_user WHERE id_pengadaan = $id_id");
                                    while ($row = mysqli_fetch_array($ib)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['kode_aktivitas'] ?> </td>
                                            <td><?= $row['nama_aktivitas'] ?> </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalUbahaktivitas<?= $no ?>"> Ubah </a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusaktivitas<?= $no ?>"> Hapus</a>                                  
                                            </td>
                                        </tr>

                                        <!-- Awal Modal Ubah-->
                                        <div class="modal" id="modalUbahaktivitas<?= $no ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data </h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                               
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <input type="hidden" name="aktivitas" value="<?= $row['id_aktivitas'] ?>">
                                                        <div class="modal-body">                                                 

                                                            <div class="mb-3">
                                                                <label class="form-label">Komponen</label>
                                                                <select class="form-control" name="komponen">
                                                                    <option value="<?= $row['id_komponen'] ?>"> <?= $row['nama_komponen'] ?> </option>
                                                                    <?php foreach ($dataaktivitas as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_komponen"] ?>"><?php echo $value["nama_komponen"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Aktivitas</label>
                                                                <input type="text" class="form-control" name="kodeaktivitas" value="<?= $row['kode_aktivitas'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Aktivitas</label>
                                                                <input type="text" class="form-control" name="namaaktivitas" value="<?= $row['nama_aktivitas'] ?>">
                                                            </div>

                                                            
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_aktivitas">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>

                        <!-- Awal Modal Hapus -->
                        <div class="modal" id="modalHapusaktivitas<?= $no ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="POST" action="tambah_satker.php">
                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                        <input type="hidden" name="aktivitas" value="<?= $row['id_aktivitas'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                <br>
                                                <span class="text-danger"><?= $row['nama_aktivitas'] ?></span>
                                            </h5>
                                        </div>
                                        <!-- Akhir Modal Tambah -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapus_aktivitas">Hapus</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                    </table>
                    
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
                    <script type="text/javascript">
                        $('#output').change(function() { 
                            var fakultas = $(this).val(); 
                            $.ajax({
                                type: 'POST', 
                                url: 'ajax_jurusan.php', 
                                data: 'id_output=' + fakultas, 
                                success: function(response) { 
                                    $('#program').html(response); 
                                }
                            });
                        });
                
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });
                    </script>
                    </div>

                </div>

                <br> 
                    <!-- Page Heading -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2">
                        Tambah Akun
                    </button>

                           <!-- Awal Modal Tambah -->
                           <div class="modal" id="myModal2">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label class="form-label">Aktivitas</label>
                                                                <select class="form-control" name="aktivitas">
                                                                    <option value=""> Choose Aktivitas </option>
                                                                    <?php foreach ($dataheader as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_aktivitas"] ?>"><?php echo $value["nama_aktivitas"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Akun</label>
                                                                <select class="form-control" name="akun">
                                                                    <option value=""> Choose Akun </option>
                                                                    <?php foreach ($akun as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_akun"] ?>"><?php echo $value["nama_akun"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>                          

                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_header">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                </div>
                                                </form>

                                            </div>
                                        </div>
                        </div>

                    <br><br>
                    <div class="card shadow mb-10">
                        <div class="card-body" style="overflow-x:auto">
                        <h5> Table Akun </h5>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $ib = mysqli_query($conn, "SELECT * FROM header LEFT JOIN aktivitas
                                    ON header.id_aktivitas=aktivitas.id_aktivitas LEFT JOIN akun
                                    ON header.id_akun=akun.id_akun LEFT JOIN komponen
                                    ON aktivitas.id_komponen=komponen.id_komponen LEFT JOIN output_user ON
                                    komponen.id_output_user = output_user.id_output_user WHERE id_pengadaan = $id_id");
                                    while ($row = mysqli_fetch_array($ib)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['kode_akun'] ?> </td>
                                   
                                            <td><?= $row['nama_akun'] ?> </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalUbahheader<?= $no ?>"> Ubah </a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusheader<?= $no ?>"> Hapus</a>                                  
                                            </td>
                                        </tr>

                                        <!-- Awal Modal Ubah-->
                                        <div class="modal" id="modalUbahheader<?= $no ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                               
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <input type="hidden" name="header" value="<?= $row['id_header'] ?>">
                                                        <div class="modal-body">                                                 

                                                            <div class="mb-3">
                                                                <label class="form-label">Aktivitas</label>
                                                                <select class="form-control" name="aktivitas">
                                                                    <option value="<?= $row['id_aktivitas'] ?>"> <?= $row['nama_aktivitas'] ?> </option>
                                                                    <?php foreach ($dataheader as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_aktivitas"] ?>"><?php echo $value["nama_aktivitas"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Akun</label>
                                                                <select class="form-control" name="akun">
                                                                    <option value="<?= $row['id_akun'] ?>"> <?= $row['nama_akun'] ?> </option>
                                                                    <?php foreach ($akun as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_akun"] ?>"><?php echo $value["nama_akun"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_header">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                 
                        <!-- Awal Modal Hapus -->
                        <div class="modal" id="modalHapusheader<?= $no ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="POST" action="tambah_satker.php">
                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                        <input type="hidden" name="header" value="<?= $row['id_header'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                <br>
                                                <span class="text-danger"><?= $row['nama_akun'] ?></span>
                                            </h5>
                                        </div>
                                        <!-- Akhir Modal Tambah -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapus_header">Hapus</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                    </table>
                    
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
                    <script type="text/javascript">
                        $('#output').change(function() { 
                            var fakultas = $(this).val(); 
                            $.ajax({
                                type: 'POST', 
                                url: 'ajax_jurusan.php', 
                                data: 'id_output=' + fakultas, 
                                success: function(response) { 
                                    $('#program').html(response); 
                                }
                            });
                        });
                
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });
                    </script>
                    </div>

                </div>
                
                <br> 
                    <!-- Page Heading -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">
                        Tambah Detail
                    </button>

                             <!-- Awal Modal Tambah -->
                             <div class="modal" id="myModal3">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label class="form-label">Akun</label>
                                                                <select class="form-control" name="header">
                                                                    <option value=""> Choose Akun </option>
                                                                    <?php foreach ($datadetail as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_header"] ?>"><?php echo $value["nama_aktivitas"]." - ".$value["nama_akun"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Detail</label>
                                                                <input type="text" class="form-control" name="namadetail" placeholder="Detail">
                                                            </div>  
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="namavolume" placeholder="Volume">
                                                            </div>  

                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="namasatuan" placeholder="Satuan">
                                                            </div>
                                                            
                                                             

                                                            <div class="mb-3">
                                                                <label class="form-label">Harga</label>
                                                                <input type="text" class="form-control" name="namaharga" placeholder="Harga">
                                                            </div>  

                                                            <div class="mb-3">
                                                            <label> Alokasi </label>
                                                            <select class="form-control" name="namaalokasi">
                                                                <option value=""> Choose Alokasi</option>
                                                                <option value="Non Inisitif Strategis"> Non Inisitif Strategis </option>
                                                                <option value="Inisitif Strategis"> Inisitif Strategis </option>
                                                            </select>
                                                            </div>

                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_detail">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                </div>
                                                </form>

                                            </div>
                                        </div>
                        </div>

                    <br><br>
                    <div class="card shadow mb-10">
                        <div class="card-body" style="overflow-x:auto">
                        <h5> Table Detail </h5>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                       
                                        <th>Nama Detail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $ib = mysqli_query($conn, "SELECT * FROM detail LEFT JOIN header 
                                    ON detail.id_header=header.id_header LEFT JOIN akun
                                    ON header.id_akun=akun.id_akun LEFT JOIN aktivitas
                                    ON header.id_aktivitas=aktivitas.id_aktivitas LEFT JOIN komponen
                                    ON aktivitas.id_komponen=komponen.id_komponen LEFT JOIN output_user ON
                                    komponen.id_output_user = output_user.id_output_user WHERE id_pengadaan = $id_id");
                                    while ($row = mysqli_fetch_array($ib)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                                                           
                                            <td><?= $row['nama_detail'] ?> </td>
                                            <td>
                                                <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#modalUbahdetail<?= $no ?>"> Ubah </a>
                                                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#modalHapusdetail<?= $no ?>"> Hapus</a>                                  
                                            </td>
                                        </tr>

                                        <!-- Awal Modal Ubah-->
                                        <div class="modal" id="modalUbahdetail<?= $no ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                               
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                                        <input type="hidden" name="detail" value="<?= $row['id_detail'] ?>">
                                                        <div class="modal-body">                                                 

                                                            <div class="mb-3">
                                                                <label class="form-label">Akun</label>
                                                                <select class="form-control" name="header">
                                                                    <option value="<?= $row['id_header'] ?>"> <?= $row['nama_akun'] ?> </option>
                                                                    <?php foreach ($datadetail as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_header"] ?>"><?php echo $value["nama_akun"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Detail</label>
                                                                <input type="text" class="form-control" name="namadetail" value="<?= $row['nama_detail'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="namavolume" value="<?= $row['volume_detail'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="namasatuan" value="<?= $row['satuan_detail'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Harga</label>
                                                                <input type="text" class="form-control" name="namaharga" value="<?= $row['harga_detail'] ?>">
                                                            </div>

                                                          

                                                            <div class="mb-3">
                                                            <label> Alokasi </label>
                                                            <select class="form-control" name="namaalokasi">
                                                                <option value="<?= $row['alokasi_detail'] ?>"><?= $row['alokasi_detail'] ?> </option>
                                                                <option value="Non Inisitif Strategis"> Non Inisitif Strategis </option>
                                                                <option value="Inisitif Strategis"> Inisitif Strategis </option>
                                                            </select>
                                                            </div>

                                                            
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_detail">Ubah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                    
                                                </div>
                                            </div>
                                        </div>

                               
                        <!-- Awal Modal Hapus -->
                        <div class="modal" id="modalHapusdetail<?= $no ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <form method="POST" action="tambah_satker.php">
                                        <input type="hidden" name="user_id" value="<?php echo $id_id ?>" />
                                        <input type="hidden" name="detail" value="<?= $row['id_detail'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                <br>
                                                <span class="text-danger"><?= $row['nama_detail'] ?></span>
                                            </h5>
                                        </div>
                                        <!-- Akhir Modal Tambah -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="hapus_detail">Hapus</button>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                    </tbody>
                    </table>
                  
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	
                    <script type="text/javascript">
                        $('#output').change(function() { 
                            var fakultas = $(this).val(); 
                            $.ajax({
                                type: 'POST', 
                                url: 'ajax_jurusan.php', 
                                data: 'id_output=' + fakultas, 
                                success: function(response) { 
                                    $('#program').html(response); 
                                }
                            });
                        });
                
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#example').DataTable();
                        });
                    </script>
                    </div>

                </div>
                    
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; BP Tapera 2023</span>
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
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
    <script src="DataTables/DataTables-1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="DataTables/DataTables-1.13.4/js/dataTables.bootstrap4.min.css"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>


</html>