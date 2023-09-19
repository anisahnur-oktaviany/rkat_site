<?php
include "koneksi.php";
$name = $_REQUEST["username"];
$email = $_REQUEST["email"];
$pass = $_REQUEST["pass"];
$role = $_REQUEST["role"];

$mysqli  = "INSERT INTO raw_tgj (nama_rawtgj, user_email, user_password, user_role) VALUES ('$name','$email','$pass','$role')";
$result  = mysqli_query($koneksi, $mysqli);
if ($result) {
    echo "<script> alert('Registrations success, please login') </script>";
    echo "<script> location='login.php' </script>";;
} else {
    echo "<script> alert('Registrations failed, try again') </script>";
    echo "<script> location='register.php' </script>";;
}
mysqli_close($koneksi);
