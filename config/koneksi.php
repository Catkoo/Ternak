<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inv";
$koneksi = mysqli_connect($servername, $username, $password);

if(!$koneksi){
    die("Connection failed: " . mysqli_connect_error());
}
$db_selected = mysqli_select_db($koneksi, $dbname);
if (!$db_selected) {
echo "Database not available";
}
?>