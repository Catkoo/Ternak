<?php
// costume id data barang
$qryIdBarang = $koneksi->query("SELECT MAX(id_barang) FROM barang");
$resltBarang = $qryIdBarang->fetch_array();
$empty = $resltBarang[0];
$num = (int) substr($empty, 4);
$num++;
$car = "BRG-";
$idBarang = sprintf("%s%04s", $car, $num);

// costume id satuan
$qryIdSatuan = $koneksi->query("SELECT MAX(id_satuan) FROM satuan");
$resltSatuan = $qryIdSatuan->fetch_array();
$empty = $resltSatuan[0];
$num = (int) substr($empty, 4);
$num++;
$car = "STN-";
$idSatuan = sprintf("%s%04s", $car, $num);

// costume id Supplier
$qryIdSupp = $koneksi->query("SELECT MAX(id_sup) FROM supplier");
$resltSupp = $qryIdSupp->fetch_array();
$empty = $resltSupp[0];
$num = (int) substr($empty, 4);
$num++;
$car = "SUP-";
$idSupp = sprintf("%s%04s", $car, $num);

// costume id Barang Masuk
$qryIdBM = $koneksi->query("SELECT MAX(id_bm) FROM barang_masuk");
$resltBM = $qryIdBM->fetch_array();
$empty = $resltBM[0];
$num = (int) substr($empty, 3);
$num++;
$car = "BM-";
$idBM = sprintf("%s%04s", $car, $num);

// costume id Barang Keluar
$qryIdBK = $koneksi->query("SELECT MAX(id_bk) FROM barang_keluar");
$resltBK = $qryIdBK->fetch_array();
$empty = $resltBK[0];
$num = (int) substr($empty, 3);
$num++;
$car = "BK-";
$idBK = sprintf("%s%04s", $car, $num);
