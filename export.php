<?php
include "config/koneksi.php";
$filename = 'Report_Data_'.date('d-m-Y').'.xls';
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");

$start = $_GET['start'];
$end = $_GET['end'];
?>
<table border="1">
    <thead>
        <tr>
            <td colspan="8" style="text-align:center">REPORT DATA <b><?= date('d/m/Y', strtotime($start));?></b> - <b><?= date('d/m/Y', strtotime($end));?></b></td>
        </tr>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Jumlah Masuk</th>
            <th>Tanggal Masuk</th>
            <th>Jumlah Keluar</th>
            <th>Tanggal Keluar</th>
        </tr>
    </thead>
    <?php
    

    $no =1;
    $sql = $koneksi->query("SELECT br.id_barang, br.stok, br.nama_barang, br.satuan_id, st.id_satuan, st.nama_satuan, bk.barang_id, bk.tanggal_keluar, bk.jumlah_keluar, bm.barang_id, bm.tanggal_masuk, bm.jumlah_masuk
    FROM barang as br
    JOIN satuan as st ON st.id_satuan=br.satuan_id
    LEFT JOIN barang_keluar as bk ON bk.barang_id=br.id_barang
    LEFT JOIN barang_masuk as bm ON bm.barang_id=br.id_barang
    WHERE bk.tanggal_keluar BETWEEN '$start' AND '$end' 
    OR bm.tanggal_masuk BETWEEN '$start' AND '$end'
    ");

    while($data = $sql->fetch_assoc()){
        $sqlBK = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah_keluar FROM barang_keluar WHERE tanggal_keluar BETWEEN '$start' AND '$end' ");
        $totBk = $sqlBK->fetch_assoc();

        $sqlBM = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah_masuk FROM barang_masuk WHERE tanggal_masuk BETWEEN '$start' AND '$end' ");
        $totBm = $sqlBM->fetch_assoc();
        ?>
        <tbody>
            <tr>
                <td><?= $no;?></td>
                <td><?= $data['nama_barang'];?></td>
                <td><?= $data['nama_satuan'];?></td>
                <td><?= $data['stok'];?></td>
                <td><?= $data['jumlah_masuk'] != null ? $data['jumlah_masuk'] : '-';?></td>
                <td><?= $data['tanggal_masuk'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_masuk'])) : '-';?></td>
                <td><?= $data['jumlah_keluar'] != null ? $data['jumlah_keluar'] : '-';?></td>
                <td><?= $data['tanggal_keluar'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_keluar'])) : '-';?></td>
            </tr>
        </tbody>
    <?php $no++; } ?>
        <tfoot>
        <td colspan="8"></td>
        <tr>
            <th colspan="2" >Total Barang Masuk : </th>
            <td colspan="6" style="text-align:left" ><?= $totBm['jumlah_masuk'] != null ? $totBm['jumlah_masuk'] : '-'; ?></td>
        </tr>
        <tr>
            <th colspan="2">Total Barang Keluar :</th>
            <td colspan="6" style="text-align:left"><?= $totBk['jumlah_keluar'] != null ? $totBk['jumlah_keluar'] : '-';?></td>
        </tr>
        
    </tfoot>
    
</table>
