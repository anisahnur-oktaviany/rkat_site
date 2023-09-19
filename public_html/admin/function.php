
<?php
  $host ="localhost"; //host server
  $user ="root"; //user login phpMyAdmin
  $pass =""; //pass login phpMyAdmin
  $db ="rkatsite_tapera"; //nama database
  $koneksi = mysqli_connect($host, $user, $pass, $db) or die ("Koneksi gagal");


if (isset($_POST['login'])) {
    $email = $_POST['mail'];
    $password = $_POST['pass'];

    $check = mysqli_query($koneksi, "SELECT * FROM user where email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($check);
    if ($hitung > 0) {
        $ambilrole =  mysqli_fetch_array($check);
        $role = $ambilrole['role'];

        if ($role == 'admin') {
            $_SESSION['log'] = 'Logged';
            $_SESSION['role_user'] = 'Admin';
            header('location:admin');
        } else {
            $_SESSION['log'] = 'Logged';
            $_SESSION['role_user'] = 'User';
            header('location:user');
        }
    } else {
        echo 'Akun tidak ditemukan';
    }
};

