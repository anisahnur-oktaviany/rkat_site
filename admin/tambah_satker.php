<?php
include 'koneksi.php';

//SASARAN STRATEGIS

if (isset($_POST['add_sasaranstrategis'])) {
    $simpan = mysqli_query($conn, "INSERT INTO sasaran_strategis (kode_sasaranstrategis, nama_sasaranstrategis) VALUES ('$_POST[kode_sasaranstrategis]','$_POST[nama_sasaranstrategis]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='sasaran-strategis.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='sasaran-strategis.php';
            </script>";
    }
};

if (isset($_POST['ubah_sasaranstrategis'])) {
    $ubah = mysqli_query($conn, "UPDATE sasaran_strategis SET
    kode_sasaranstrategis = '$_POST[kode_sasaranstrategis]',
    nama_sasaranstrategis = '$_POST[nama_sasaranstrategis]'
    WHERE id_sasaranstrategis = '$_POST[sasaranstrategis]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'sasaran-strategis.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'sasaran-strategis.php';
    </script>";
    }
}

if (isset($_POST['hapus_sasaranstrategis'])) {
    $hapus = mysqli_query($conn, "DELETE FROM sasaran_strategis WHERE id_sasaranstrategis = '$_POST[sasaranstrategis]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'sasaran-strategis.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'sasaran-strategis.php';
    </script>";
    }
}

//INDIKATOR UTAMA

if (isset($_POST['add_indikatorutama'])) {
    $simpan = mysqli_query($conn, "INSERT INTO indikator_utama (kode_indikatorutama, nama_indikatorutama) VALUES ('$_POST[kode_indikatorutama]','$_POST[nama_indikatorutama]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='indikator-utama.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='indikator-utama.php';
            </script>";
    }
};

if (isset($_POST['ubah_indikatorutama'])) {
    $ubah = mysqli_query($conn, "UPDATE indikator_utama SET
    kode_indikatorutama = '$_POST[kode_indikatorutama]',
    nama_indikatorutama = '$_POST[nama_indikatorutama]'
    WHERE id_indikatorutama = '$_POST[indikatorutama]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'indikator-utama.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'indikator-utama.php';
    </script>";
    }
}

if (isset($_POST['hapus_indikatorutama'])) {
    $hapus = mysqli_query($conn, "DELETE FROM indikator_utama WHERE id_indikatorutama = '$_POST[indikatorutama]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'indikator-utama.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'indikator-utama.php';
    </script>";
    }
}

//PROGRAM

include 'koneksi.php';

if (isset($_POST['add_program'])) {
    $simpan = mysqli_query($conn, "INSERT INTO program (kode_program, nama_program) VALUES ('$_POST[kode_program]','$_POST[nama_program]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='program.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='program.php';
            </script>";
    }
};

if (isset($_POST['ubah_program'])) {
    $ubah = mysqli_query($conn, "UPDATE program SET
    kode_program = '$_POST[kode_program]',
    nama_program = '$_POST[nama_program]'
    WHERE id_program = '$_POST[program]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'program.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'program.php';
    </script>";
    }
}

if (isset($_POST['hapus_program'])) {
    $hapus = mysqli_query($conn, "DELETE FROM program WHERE id_program = '$_POST[program]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'program.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'program.php';
    </script>";
    }
}

//SASARAN PROGRAM

if (isset($_POST['add_sasaranprogram'])) {
    $simpan = mysqli_query($conn, "INSERT INTO sasaran_program (kode_sasaranprogram, nama_sasaranprogram) VALUES ('$_POST[kode_sasaranprogram]','$_POST[nama_sasaranprogram]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='sasaran-program.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='sasaran-program.php';
            </script>";
    }
};

if (isset($_POST['ubah_sasaranprogram'])) {
    $ubah = mysqli_query($conn, "UPDATE sasaran_program SET
    kode_sasaranprogram = '$_POST[kode_sasaranprogram]',
    nama_sasaranprogram = '$_POST[nama_sasaranprogram]'
    WHERE id_sasaranprogram = '$_POST[sasaranprogram]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'sasaran-program.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'sasaran-program.php';
    </script>";
    }
}

if (isset($_POST['hapus_sasaranprogram'])) {
    $hapus = mysqli_query($conn, "DELETE FROM sasaran_program WHERE id_sasaranprogram = '$_POST[sasaranprogram]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'sasaran-program.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'sasaran-program.php';
    </script>";
    }
}

//INDIKATOR PROGRAM

if (isset($_POST['add_indikatorprogram'])) {
    $simpan = mysqli_query($conn, "INSERT INTO indikator_program (kode_indikatorprogram, nama_indikatorprogram) VALUES ('$_POST[kode_indikatorprogram]','$_POST[nama_indikatorprogram]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='indikator-program.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='indikator-program.php';
            </script>";
    }
};

if (isset($_POST['ubah_indikatorprogram'])) {
    $ubah = mysqli_query($conn, "UPDATE indikator_program SET
    kode_indikatorprogram = '$_POST[kode_indikatorprogram]',
    nama_indikatorprogram = '$_POST[nama_indikatorprogram]'
    WHERE id_indikatorprogram = '$_POST[indikatorprogram]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'indikator-program.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'indikator-program.php';
    </script>";
    }
}

if (isset($_POST['hapus_indikatorprogram'])) {
    $hapus = mysqli_query($conn, "DELETE FROM indikator_program WHERE id_indikatorprogram = '$_POST[indikatorprogram]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'indikator-program.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'indikator-program.php';
    </script>";
    }
}


//KEGIATAN

include 'koneksi.php';

if (isset($_POST['add_kegiatan'])) {
    $simpan = mysqli_query($conn, "INSERT INTO kegiatan (kode_kegiatan, nama_kegiatan) VALUES ('$_POST[kode_kegiatan]','$_POST[nama_kegiatan]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='kegiatan.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='kegiatan.php';
            </script>";
    }
};

if (isset($_POST['ubah_kegiatan'])) {
    $ubah = mysqli_query($conn, "UPDATE kegiatan SET
    kode_kegiatan = '$_POST[kode_kegiatan]',
    nama_kegiatan = '$_POST[nama_kegiatan]'
    WHERE id_kegiatan = '$_POST[kegiatan]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'kegiatan.php';
    </script>";
    }
}

if (isset($_POST['hapus_kegiatan'])) {
    $hapus = mysqli_query($conn, "DELETE FROM kegiatan WHERE id_program = '$_POST[kegiatan]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'kegiatan.php';
    </script>";
    }
}

//SASARAN KEGIATAN

if (isset($_POST['add_sasarankegiatan'])) {
    $simpan = mysqli_query($conn, "INSERT INTO sasaran_kegiatan 
    (kode_sasarankegiatan, nama_sasarankegiatan) 
    VALUES ('$_POST[kode_sasarankegiatan]',
    '$_POST[nama_sasarankegiatan]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='sasaran-kegiatan.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='sasaran-kegiatan.php';
            </script>";
    }
};

if (isset($_POST['ubah_sasarankegiatan'])) {
    $ubah = mysqli_query($conn, "UPDATE sasaran_kegiatan SET
    kode_sasarankegiatan = '$_POST[kode_sasarankegiatan]',
    nama_sasarankegiatan = '$_POST[nama_sasarankegiatan]'
    WHERE id_sasarankegiatan = '$_POST[sasarankegiatan]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'sasaran-kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'sasaran-kegiatan.php';
    </script>";
    }
}

if (isset($_POST['hapus_sasarankegiatan'])) {
    $hapus = mysqli_query($conn, "DELETE FROM sasaran_kegiatan WHERE id_sasarankegiatan = '$_POST[sasarankegiatan]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'sasaran-kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'sasaran-kegiatan.php';
    </script>";
    }
}

//INDIKATOR KEGIATAN

include 'koneksi.php';

if (isset($_POST['add_indikatorkegiatan'])) {
    $simpan = mysqli_query($conn, "INSERT INTO indikator_kegiatan (kode_indikatorkegiatan, nama_indikatorkegiatan) VALUES ('$_POST[kode_indikatorkegiatan]','$_POST[nama_indikatorkegiatan]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='indikator-kegiatan.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='indikator-kegiatan.php';
            </script>";
    }
};

if (isset($_POST['ubah_indikatorkegiatan'])) {
    $ubah = mysqli_query($conn, "UPDATE indikator_kegiatan SET
    kode_indikatorkegiatan = '$_POST[kode_indikatorkegiatan]',
    nama_indikatorkegiatan = '$_POST[nama_indikatorkegiatan]'
    WHERE id_indikatorkegiatan = '$_POST[indikatorkegiatan]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'indikator-kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'indikator-kegiatan.php';
    </script>";
    }
}

if (isset($_POST['hapus_indikatorkegiatan'])) {
    $hapus = mysqli_query($conn, "DELETE FROM indikator_kegiatan WHERE id_indikatorkegiatan = '$_POST[indikatorkegiatan]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'indikator-kegiatan.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'indikator-kegiatan.php';
    </script>";
    }
}


//OUTPUT


include 'koneksi.php';

if (isset($_POST['add_output'])) {
    $simpan = mysqli_query($conn, "INSERT INTO output (kode_output, nama_output) VALUES ('$_POST[kode_output]','$_POST[nama_output]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='output.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='output.php';
            </script>";
    }
};

if (isset($_POST['ubah_output'])) {
    $ubah = mysqli_query($conn, "UPDATE output SET
    kode_output = '$_POST[kode_output]',
    nama_output = '$_POST[nama_output]'
    WHERE id_output = '$_POST[output]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'output.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'output.php';
    </script>";
    }
}

if (isset($_POST['hapus_output'])) {
    $hapus = mysqli_query($conn, "DELETE FROM output WHERE id_output = '$_POST[output]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'output.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'output.php';
    </script>";
    }
}


//COMPILE OUTPUT


include 'koneksi.php';


if (isset($_POST['add_compile'])) {

    $simpan = mysqli_query($conn, "INSERT INTO compile_output (id_sasaranstrategis, id_indikatorutama, volume_indikatorutama, satuan_indikatorutama, id_program, id_sasaranprogram, id_indikatorprogram, volume_indikatorprogram, satuan_indikatorprogram, id_kegiatan, id_sasarankegiatan, id_indikatorkegiatan, volume_indikatorkegiatan, satuan_indikatorkegiatan, id_output)
    VALUES ('$_POST[sasaranstrategis]','$_POST[indikatorutama]','$_POST[volume_indikatorutama]','$_POST[satuan_indikatorutama]','$_POST[program]','$_POST[sasaranprogram]','$_POST[indikatorprogram]','$_POST[volume_indikatorprogram]','$_POST[satuan_indikatorprogram]','$_POST[kegiatan]','$_POST[sasarankegiatan]','$_POST[indikatorkegiatan]','$_POST[volume_indikatorkegiatan]','$_POST[satuan_indikatorkegiatan]','$_POST[output]')");
    
    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='compile_output.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='compile_output.php';
            </script>";
    }
};

if (isset($_POST['ubah_compile'])) {
    $ubah = mysqli_query($conn, "UPDATE compile_output SET
    id_sasaranstrategis = '$_POST[sasaranstrategis]',
    id_indikatorutama = '$_POST[indikatorutama]',
    volume_indikatorutama = '$_POST[volume_indikatorutama]',
    satuan_indikatorutama = '$_POST[satuan_indikatorutama]',
    id_program = '$_POST[program]',
    id_sasaranprogram = '$_POST[sasaranprogram]',
    id_indikatorprogram = '$_POST[indikatorprogram]',
    volume_indikatorprogram = '$_POST[volume_indikatorprogram]',
    satuan_indikatorprogram = '$_POST[satuan_indikatorprogram]',
    id_kegiatan = '$_POST[kegiatan]',
    id_sasarankegiatan = '$_POST[sasarankegiatan]',
    id_indikatorkegiatan = '$_POST[indikatorkegiatan]',
    volume_indikatorkegiatan = '$_POST[volume_indikatorkegiatan]',
    satuan_indikatorkegiatan = '$_POST[satuan_indikatorkegiatan]',
    id_output = '$_POST[output]'
    WHERE id_compile = '$_POST[compile]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'compile_output.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'compile_output.php';
    </script>";
    }
}

if (isset($_POST['hapus_compile'])) {
    $hapus = mysqli_query($conn, "DELETE FROM compile_output WHERE id_compile = '$_POST[compile]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'compile_output.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'compile_output.php';
    </script>";
    }
}

//AKUN


include 'koneksi.php';

if (isset($_POST['add_akun'])) {
    $simpan = mysqli_query($conn, "INSERT INTO akun (kode_akun, nama_akun) VALUES ('$_POST[kode_akun]','$_POST[nama_akun]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='akun.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='akun.php';
            </script>";
    }
};

if (isset($_POST['ubah_akun'])) {
    $ubah = mysqli_query($conn, "UPDATE akun SET
    kode_akun = '$_POST[kode_akun]',
    nama_akun = '$_POST[nama_akun]'
    WHERE id_akun = '$_POST[akun]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'akun.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'akun.php';
    </script>";
    }
}

if (isset($_POST['hapus_akun'])) {
    $hapus = mysqli_query($conn, "DELETE FROM akun WHERE id_akun = '$_POST[akun]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'akun.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'akun.php';
    </script>";
    }
}

//USER

if (isset($_POST['add_user'])) {
    $simpan = mysqli_query($conn, "INSERT INTO raw_tgj (nama_rawtgj, user_email, user_password, user_role) VALUES ('$_POST[username]','$_POST[email]', '$_POST[pass]', '$_POST[role]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='user.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='user.php';
            </script>";
    }
};

if (isset($_POST['ubah_user'])) {
    $ubah = mysqli_query($conn, "UPDATE raw_tgj SET
    nama_rawtgj = '$_POST[username]',
    user_email = '$_POST[email]',
    user_password = '$_POST[password]',
    user_role = '$_POST[role]'
    WHERE id_rawtgj = '$_POST[user]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'user.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'user.php';
    </script>";
    }
}

if (isset($_POST['hapus_user'])) {
    $hapus = mysqli_query($conn, "DELETE FROM raw_tgj WHERE id_rawtgj = '$_POST[user]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'user.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'user.php';
    </script>";
    }
}