<?php
  $host ="localhost"; //host server
  $user ="root"; //user login phpMyAdmin
  $pass =""; //pass login phpMyAdmin
  $db ="rkatsite_tapera"; //nama database
  $koneksi = mysqli_connect($host, $user, $pass, $db) or die ("Koneksi gagal");
?>