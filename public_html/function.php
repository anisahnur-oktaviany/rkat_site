<?php  
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
if (isset($_POST['login'])) {

$email = $_POST['mail'];
$password = $_POST['pass'];
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"SELECT * FROM raw_tgj WHERE user_email='$email' and user_password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);

	// cek jika user login sebagai admin
	if($data['user_role']=="Admin"){
 
// buat session login dan username
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = "Admin";
// alihkan ke halaman dashboard admin
header('location:admin');

// cek jika user login sebagai pengurus
}else if($data['user_role']=="User"){
// buat session login dan username
$_SESSION['user_email'] = $email;
$_SESSION['user_role'] = "User";
// alihkan ke halaman dashboard pengurus
header('location:user');

}else{
// alihkan ke halaman login kembali
echo 'Akun tidak ditemukan';
header("location:login.php");
}	
}
}
?>