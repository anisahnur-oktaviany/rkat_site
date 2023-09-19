<?php require 'function.php';
require 'koneksi.php';

$dataoutput = array();
$ambil = $koneksi->query("SELECT * FROM output");
while ($tiap = $ambil->fetch_assoc()) {
    $dataoutput[] = $tiap;
}

$datasasaranstrategis = array();
$ambil = $koneksi->query("SELECT * FROM sasaran_strategis");
while ($tiap = $ambil->fetch_assoc()) {
    $datasasaranstrategis[] = $tiap;
}

$dataindikatorutama = array();
$ambil = $koneksi->query("SELECT * FROM indikator_utama");
while ($tiap = $ambil->fetch_assoc()) {
    $dataindikatorutama[] = $tiap;
}

$datasasaranprogram = array();
$ambil = $koneksi->query("SELECT * FROM sasaran_program");
while ($tiap = $ambil->fetch_assoc()) {
    $datasasaranprogram[] = $tiap;
}

$dataindikatorprogram = array();
$ambil = $koneksi->query("SELECT * FROM indikator_program");
while ($tiap = $ambil->fetch_assoc()) {
    $dataindikatorprogram[] = $tiap;
}

$dataindikatorkegiatan = array();
$ambil = $koneksi->query("SELECT * FROM indikator_kegiatan");
while ($tiap = $ambil->fetch_assoc()) {
    $dataindikatorkegiatan[] = $tiap;
}

$datasasarankegiatan = array();
$ambil = $koneksi->query("SELECT * FROM sasaran_kegiatan");
while ($tiap = $ambil->fetch_assoc()) {
    $datasasarankegiatan[] = $tiap;
}

$dataprogram = array();
$ambil = $koneksi->query("SELECT * FROM program");
while ($tiap = $ambil->fetch_assoc()) {
    $dataprogram[] = $tiap;
}

$datakegiatan = array();
$ambil = $koneksi->query("SELECT * FROM kegiatan");
while ($tiap = $ambil->fetch_assoc()) {
    $datakegiatan[] = $tiap;
}

$datacompile = array();
$ambil = $koneksi->query("SELECT * FROM compile_output");
while ($tiap = $ambil->fetch_assoc()) {
    $datacompile[] = $tiap;
}?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Compile Master</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

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

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
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
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
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
                                        Spending Alert: We've noticed unusually high spending for your account.
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
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
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
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Data
                    </button>

                     <!-- Awal Modal Tambah -->
                     <div class="modal" id="myModal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tambah Compile Master</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php" name="id_compile">
                                                    <div class="modal-body" name="id_compile">                                              

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Strategis</label>
                                                                <select class="form-control" name="sasaranstrategis">
                                                                    <option value="">Select Sasaran Strategis</option>
                                                                    <?php foreach ($datasasaranstrategis as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasaranstrategis"] ?>"><?php echo $value["nama_sasaranstrategis"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Utama</label>
                                                                <select class="form-control" name="indikatorutama">
                                                                    <option value="">Select Indikator Utama</option>
                                                                    <?php foreach ($dataindikatorutama as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorutama"] ?>"><?php echo $value["nama_indikatorutama"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="volume_indikatorutama" placeholder="Volume">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorutama" placeholder="Satuan">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Program</label>
                                                                <select class="form-control" name="program">
                                                                    <option value="">Select Program</option>
                                                                    <?php foreach ($dataprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_program"] ?>"><?php echo $value["nama_program"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Program</label>
                                                                <select class="form-control" name="sasaranprogram">
                                                                    <option value="">Select Sasaran Program</option>
                                                                    <?php foreach ($datasasaranprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasaranprogram"] ?>"><?php echo $value["nama_sasaranprogram"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Program</label>
                                                                <select class="form-control" name="indikatorprogram">
                                                                    <option value="">Select Indikator Program</option>
                                                                    <?php foreach ($dataindikatorprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorprogram"] ?>"><?php echo $value["nama_indikatorprogram"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="volume_indikatorprogram" placeholder="Volume">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorprogram" placeholder="Satuan">
                                                            </div>


                                                            <div class="mb-3">
                                                                <label class="form-label">Kegiatan</label>
                                                                <select class="form-control" name="kegiatan">
                                                                    <option value="">Select Kegiatan</option>
                                                                    <?php foreach ($datakegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_kegiatan"] ?>"><?php echo $value["nama_kegiatan"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Kegiatan</label>
                                                                <select class="form-control" name="sasarankegiatan">
                                                                    <option value="">Select Sasaran Kegiatan</option>
                                                                    <?php foreach ($datasasarankegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasarankegiatan"] ?>"><?php echo $value["nama_sasarankegiatan"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Kegiatan</label>
                                                                <select class="form-control" name="indikatorkegiatan">
                                                                    <option value="">Select Indikator Kegiatan</option>
                                                                    <?php foreach ($dataindikatorkegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorkegiatan"] ?>"><?php echo $value["nama_indikatorkegiatan"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                
                                                            <div class="mb-3">
                                                                <label class="form-label">Volume</label>
                                                                <input type="text" class="form-control" name="volume_indikatorkegiatan" placeholder="Volume">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorkegiatan" placeholder="Satuan">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="output">
                                                                    <option value="">Select Output</option>
                                                                    <?php foreach ($dataoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_output"] ?>"><?php echo $value["nama_output"] ?> </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_compile">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                    <br><br>
                    <div class="card shadow mb-10">

                        <div style="overflow-x:auto" class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sasaran Strategis</th>
                                        <th>Indikator Utama</th>
                                        <th>Volume Indikator Utama</th>
                                        <th>Satuan Indikator Utama</th>
                                        <th>Program</th>
                                        <th>Sasaran Program</th>
                                        <th>Indikator Program</th>
                                        <th>Volume Indikator Program</th>
                                        <th>Satuan Indikator Program</th>
                                        <th>Kegiatan</th>
                                        <th>Sasaran Kegiatan</th>
                                        <th>Indikator Kegiatan</th>
                                        <th>Volume Indikator Kegiatan</th>
                                        <th>Satuan Indikator Kegiatan</th>
                                        <th>Output</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $compile_output = mysqli_query($conn, "SELECT * FROM compile_output LEFT JOIN sasaran_strategis ON 
                                    compile_output.id_sasaranstrategis = sasaran_strategis.id_sasaranstrategis LEFT JOIN indikator_utama ON 
                                    compile_output.id_indikatorutama = indikator_utama.id_indikatorutama LEFT JOIN program ON 
                                    compile_output.id_program = program.id_program LEFT JOIN sasaran_program ON 
                                    compile_output.id_sasaranprogram = sasaran_program.id_sasaranprogram LEFT JOIN indikator_program ON 
                                    compile_output.id_indikatorprogram = indikator_program.id_indikatorprogram LEFT JOIN kegiatan ON 
                                    compile_output.id_kegiatan = kegiatan.id_kegiatan LEFT JOIN sasaran_kegiatan ON 
                                    compile_output.id_sasarankegiatan = sasaran_kegiatan.id_sasarankegiatan LEFT JOIN indikator_kegiatan ON 
                                    compile_output.id_indikatorkegiatan = indikator_kegiatan.id_indikatorkegiatan LEFT JOIN output ON 
                                    compile_output.id_output = output.id_output");
                                    while ($row = mysqli_fetch_array($compile_output)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['nama_sasaranstrategis'] ?> </td>
                                            <td><?= $row['nama_indikatorutama'] ?> </td>
                                            <td><?= $row['volume_indikatorutama'] ?> </td>
                                            <td><?= $row['satuan_indikatorutama'] ?> </td>
                                            <td><?= $row['nama_program'] ?> </td>
                                            <td><?= $row['nama_sasaranprogram'] ?> </td>
                                            <td><?= $row['nama_indikatorprogram'] ?> </td>
                                            <td><?= $row['volume_indikatorprogram'] ?> </td>
                                            <td><?= $row['satuan_indikatorprogram'] ?> </td>
                                            <td><?= $row['nama_kegiatan'] ?> </td>
                                            <td><?= $row['nama_sasarankegiatan'] ?> </td>
                                            <td><?= $row['nama_indikatorkegiatan'] ?> </td>
                                            <td><?= $row['volume_indikatorutama'] ?> </td>
                                            <td><?= $row['satuan_indikatorutama'] ?> </td>
                                          
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
                                                        <h4 class="modal-title">Ubah Compile Master</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="compile" value="<?= $row['id_compile'] ?>">
                                                        <div class="modal-body">
                                                        <div class="mb-3">
                                                                <label class="form-label">Sasaran Strategis</label>
                                                                <select class="form-control" name="sasaranstrategis">
                                                                    <option value=""> Sasaran Strategis </option>
                                                                    <?php foreach ($datasasaranstrategis as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasaranstrategis"] ?>" <?php if ($value["id_sasaranstrategis"] == $value["id_sasaranstrategis"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_sasaranstrategis"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Startegis</label>
                                                                <select class="form-control" name="indikatorutama">
                                                                    <option value=""> Indikator Startegis </option>
                                                                    <?php foreach ($dataindikatorutama as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorutama"] ?>" <?php if ($value["id_indikatorutama"] == $value["id_indikatorutama"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_indikatorutama"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume Indikator Utama</label>
                                                                <input type="text" class="form-control" name="volume_indikatorutama" value="<?= $row['volume_indikatorutama'] ?>">
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan Indikator Utama</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorutama" value="<?= $row['satuan_indikatorutama'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Program</label>
                                                            <select class="form-control" name="program">
                                                                    <option value=""> Program </option>
                                                                    <?php foreach ($dataprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_program"] ?>" <?php if ($value["id_program"] == $value["id_program"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_program"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Program</label>
                                                                <select class="form-control" name="sasaranprogram">
                                                                    <option value=""> Sasaran Program </option>
                                                                    <?php foreach ($datasasaranprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasaranprogram"] ?>" <?php if ($value["id_sasaranprogram"] == $value["id_sasaranprogram"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_sasaranprogram"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Program</label>
                                                                <select class="form-control" name="indikatorprogram">
                                                                    <option value=""> Indikator Program </option>
                                                                    <?php foreach ($dataindikatorprogram as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorprogram"] ?>" <?php if ($value["id_indikatorprogram"] == $value["id_indikatorprogram"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_indikatorprogram"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume Indikator Program</label>
                                                                <input type="text" class="form-control" name="volume_indikatorprogram" value="<?= $row['volume_indikatorprogram'] ?>">
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan Indikator Program</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorprogram" value="<?= $row['satuan_indikatorprogram'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Kegiatan</label>
                                                            <select class="form-control" name="kegiatan">
                                                                    <option value=""> Kegiatan </option>
                                                                    <?php foreach ($datakegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_kegiatan"] ?>" <?php if ($value["id_kegiatan"] == $value["id_kegiatan"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_kegiatan"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Sasaran Kegiatan</label>
                                                            <select class="form-control" name="sasarankegiatan">
                                                                    <option value=""> Sasaran Kegiatan </option>
                                                                    <?php foreach ($datasasarankegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_sasarankegiatan"] ?>" <?php if ($value["id_sasarankegiatan"] == $value["id_sasarankegiatan"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_sasarankegiatan"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Indikator Kegiatan</label>
                                                                <select class="form-control" name="indikatorkegiatan">
                                                                    <option value=""> Indikator Kegiatan </option>
                                                                    <?php foreach ($dataindikatorkegiatan as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_indikatorkegiatan"] ?>" <?php if ($value["id_indikatorkegiatan"] == $value["id_indikatorkegiatan"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_indikatorkegiatan"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Volume Indikator Kegiatan</label>
                                                                <input type="text" class="form-control" name="volume_indikatorkegiatan" value="<?= $row['volume_indikatorkegiatan'] ?>">
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Satuan Indikator Kegiatan</label>
                                                                <input type="text" class="form-control" name="satuan_indikatorkegiatan" value="<?= $row['satuan_indikatorkegiatan'] ?>">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Output</label>
                                                                <select class="form-control" name="output">
                                                                    <option value=""> Output </option>
                                                                    <?php foreach ($dataoutput as $key => $value) : ?>
                                                                        <option value="<?php echo $value["id_output"] ?>" <?php if ($value["id_output"] == $value["id_output"]) {
                                                                            echo "selected";
                                                                        } ?>>
                                                                            <?php echo $value["nama_output"] ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </select>
                                                            </div>

                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_compile">Ubah</button>
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
                                                        <input type="hidden" name="compile" value="<?= $row['id_compile'] ?>">
                                                        <div class="modal-body">
                                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                                <br>
                                                                <span class="text-danger"><?= $row['nama_output'] ?> - <?= $row['nama_program'] ?></span>
                                                            </h5>
                                                        </div>
                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapus_compile">Hapus</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                </tbody>
                            </table>

                            <script>
                                $(document).ready(function() {
                                    $('#example').DataTable();
                                });
                            </script>
                        </div>

                    </div>
                    </dic>
                    <!-- /.container-fluid -->
                    </div>
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