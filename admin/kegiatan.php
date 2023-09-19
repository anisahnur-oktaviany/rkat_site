<?php require 'function.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Kegiatan</title>

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

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">DIT. TEKNOLOGI INFORMASI</span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
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
                                                        <h4 class="modal-title">Tambah Data Kegiatan</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">

                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Kegiatan</label>
                                                                <input type="text" class="form-control" name="kode_kegiatan" placeholder="Kode Kegiatan">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Kegiatan</label>
                                                                <input type="text" class="form-control" name="nama_kegiatan" placeholder="Nama Kegiatan">
                                                            </div>
                                                        </div>
                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="add_kegiatan">Tambah</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                    <br><br>
                    <div class="card shadow mb-10">

                        <div class="card-body">
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Kegiatan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'koneksi.php';
                                    $no = 1;
                                    $program = mysqli_query($conn, "SELECT * FROM kegiatan");
                                    while ($row = mysqli_fetch_array($program)) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?> </td>
                                            <td><?= $row['kode_kegiatan'] ?> </td>
                                            <td><?= $row['nama_kegiatan'] ?> </td>
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
                                                        <h4 class="modal-title">Ubah Data Kegiatan</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="POST" action="tambah_satker.php">
                                                        <input type="hidden" name="kegiatan" value="<?= $row['id_kegiatan'] ?>">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kode Kegiatan</label>
                                                                <input type="text" class="form-control" name="kode_kegiatan" value="<?= $row['kode_kegiatan'] ?>">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Kegiatan</label>
                                                                <input type="text" class="form-control" name="nama_kegiatan" value="<?= $row['nama_kegiatan'] ?>">
                                                            </div>
                                                        </div>
                                                        <!-- Akhir Modal Ubah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="ubah_kegiatan">Ubah</button>
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
                                                        <input type="hidden" name="kegiatan" value="<?= $row['id_kegiatan'] ?>">
                                                        <div class="modal-body">
                                                            <h5 class="text-center"> Apakah anda yakin akan menghapus data ini?
                                                                <br>
                                                                <span class="text-danger"><?= $row['kode_kegiatan'] ?> - <?= $row['nama_kegiatan'] ?></span>
                                                            </h5>
                                                        </div>
                                                        <!-- Akhir Modal Tambah -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="hapus_kegiatan">Hapus</button>
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
                </div>
                    <!-- /.container-fluid -->

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