<?php
// QUERY UNTUK PEMANGGILAN DATA DARI TABEL HISTORY,
// YANG DIKIRIM KE FILE SCRIPT.JS
// DAN DITAMPILKAN KEHALAMAN DASHBOARD.PHP 'HISTORY'
include "../../config/koneksi.php";
$sql = $koneksi->query("SELECT * FROM history JOIN barang ON barang.id_barang=history.barang_id");
while($row = mysqli_fetch_array($sql)){
	$data[] = $row;
}
echo json_encode(array("result" => $data));

?>