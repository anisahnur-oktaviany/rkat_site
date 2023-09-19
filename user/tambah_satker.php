<?php
include 'koneksi.php';


//TGJ

if (isset($_POST['add_tgj'])) {
    $simpan = mysqli_query($conn, "INSERT INTO tgj (id_rawtgj) 
    VALUES ('$_POST[rawtgj]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='belanja.php';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='belanja.php';
            </script>";
    }
};

if (isset($_POST['ubah_tgj'])) {
    $ubah = mysqli_query($conn, "UPDATE tgj SET
    id_rawtgj = '$_POST[rawtgj]'
    WHERE id_tgj = '$_POST[tgj]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location='belanja.php';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location='belanja.php';
    </script>";
    }
}

if (isset($_POST['hapus_tgj'])) {
    $hapus = mysqli_query($conn, "DELETE FROM tgj WHERE id_tgj= '$_POST[tgj]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location='belanja.php';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location='belanja.php';
    </script>";
    }
}

//OUTPUT

if (isset($_POST['add_outputuser'])) {
    $simpan = mysqli_query($conn, "INSERT INTO output_user (id_compile, volume_output, satuan_output, id_tgj) 
    VALUES ('$_POST[output]','$_POST[volume_output]','$_POST[satuan_output]','$_POST[tgj]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='input.php?id=".$_POST['user_id']."';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='input.php?id=".$_POST['user_id']."';
            </script>";
    }
};

if (isset($_POST['ubah_outputuser'])) {
    $ubah = mysqli_query($conn, "UPDATE output_user SET
    id_compile = '$_POST[output]',
    volume_output = '$_POST[volumeoutput]',
    satuan_output = '$_POST[satuanoutput]',
    id_tgj = '$_POST[tgj]' 
    WHERE id_output_user = '$_POST[output_user]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

if (isset($_POST['hapus_outputuser'])) {
    $hapus = mysqli_query($conn, "DELETE FROM output_user WHERE id_output_user= '$_POST[outputuser]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

//KOMPONEN

if (isset($_POST['add_komponen'])) {
    $simpan = mysqli_query($conn, "INSERT INTO komponen (id_output_user, kode_komponen, nama_komponen) VALUES 
    ('$_POST[outputuser]',
    '$_POST[kodekomponen]',
    '$_POST[namakomponen]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location='input.php?id=".$_POST['user_id']."';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location='input.php?id=".$_POST['user_id'].";
            </script>";
    }
};

if (isset($_POST['ubah_komponen'])) {
    $ubah = mysqli_query($conn, "UPDATE komponen SET
    id_output_user = '$_POST[output]',
    kode_komponen = '$_POST[kodekomponen]',
    nama_komponen = '$_POST[namakomponen]'
    WHERE id_komponen = '$_POST[komponen]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

if (isset($_POST['hapus_komponen'])) {
    $hapus = mysqli_query($conn, "DELETE FROM komponen WHERE id_komponen= '$_POST[komponen]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

//AKTIVITAS

if (isset($_POST['add_aktivitas'])) {
    $simpan = mysqli_query($conn, "INSERT INTO aktivitas (id_komponen, kode_aktivitas, nama_aktivitas) VALUES 
    ('$_POST[komponen]',
    '$_POST[kodeaktivitas]',
    '$_POST[namaaktivitas]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    }
};

if (isset($_POST['ubah_aktivitas'])) {
    $ubah = mysqli_query($conn, "UPDATE aktivitas SET
    id_komponen = '$_POST[komponen]',
    kode_aktivitas = '$_POST[kodeaktivitas]',
    nama_aktivitas = '$_POST[namaaktivitas]'
    WHERE id_aktivitas = '$_POST[aktivitas]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

if (isset($_POST['hapus_aktivitas'])) {
    $hapus = mysqli_query($conn, "DELETE FROM aktivitas WHERE id_aktivitas= '$_POST[aktivitas]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

//HEADER

if (isset($_POST['add_header'])) {
    $simpan = mysqli_query($conn, "INSERT INTO header (id_aktivitas, id_akun) VALUES 
    ('$_POST[aktivitas]',
    '$_POST[akun]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    }
};

if (isset($_POST['ubah_header'])) {
    $ubah = mysqli_query($conn, "UPDATE header SET
    id_aktivitas = '$_POST[aktivitas]',
    id_akun = '$_POST[akun]'
    WHERE id_header = '$_POST[header]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

if (isset($_POST['hapus_header'])) {
    $hapus = mysqli_query($conn, "DELETE FROM header WHERE id_header= '$_POST[header]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

//DETAIL

if (isset($_POST['add_detail'])) {
    $simpan = mysqli_query($conn, "INSERT INTO detail (id_header, nama_detail, volume_detail, satuan_detail, harga_detail, alokasi_detail) VALUES 
    ('$_POST[header]',
    '$_POST[namadetail]',
    '$_POST[namavolume]',
    '$_POST[namasatuan]',
    '$_POST[namaharga]',
    '$_POST[namaalokasi]')");

    if ($simpan) {
        echo "<script>
                alert('Data Berhasil Disimpan')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    } else {
        echo "<script>
                alert('Penambahan Data Gagal')
                document.location = 'input.php?id=".$_POST['user_id']."';
            </script>";
    }
};

if (isset($_POST['ubah_detail'])) {
    $ubah = mysqli_query($conn, "UPDATE detail SET
    id_header = '$_POST[header]',
    nama_detail = '$_POST[namadetail]',
    volume_detail = '$_POST[namavolume]',
    satuan_detail = '$_POST[namasatuan]',
    harga_detail = '$_POST[namaharga]',
  
    alokasi_detail = '$_POST[namaalokasi]'
    WHERE id_detail = '$_POST[detail]'");

    if ($ubah) {
        echo "<script>
        alert('Data Berhasil Diubah')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Perubahan Data Gagal')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

if (isset($_POST['hapus_detail'])) {
    $hapus = mysqli_query($conn, "DELETE FROM detail WHERE id_detail= '$_POST[detail]'");

    if ($hapus) {
        echo "<script>
        alert('Data Berhasil Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    } else {
        echo "<script>
        alert('Data Gagal Dihapus')
        document.location = 'input.php?id=".$_POST['user_id']."';
    </script>";
    }
}

?>