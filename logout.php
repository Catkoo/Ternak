<?php
session_start();

// Tambahkan pesan ke sesi sebelum menghancurkannya
$_SESSION['logout_message'] = "Logout berhasil. Terima kasih!";

session_destroy();
header("location: login.php");
?>
