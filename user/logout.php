<?php
session_start();
session_destroy();

echo "<script>alert('You have logged out')</script>";
echo "<script>location='login.php'</script>";