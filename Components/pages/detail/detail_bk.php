<?php
    $id = $_GET['id'];
    $sql = $koneksi->query("SELECT * FROM barang as b
    JOIN barang_keluar as bk ON bk.barang_id=b.id_barang
    JOIN satuan as st ON st.id_satuan=b.satuan_id
    WHERE bk.id_bk='$id'");
    $res = $sql->fetch_assoc();
?>

<a href="?page=barang-keluar" class="btn btn-primary btn-sm mb-2">Kembali</a>
<div class="card card-detail">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <table class="table">
                    <tr>
                        <th>KODE</th>
                        <td>:</td>
                        <td><?= $res['id_barang'];?></td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>:</td>
                        <td><?= $res['nama_barang'];?></td>
                    </tr>
                    <tr>
                        <th>Satuan Barang</th>
                        <td>:</td>
                        <td><?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <th>Stok Barang</th>
                        <td>:</td>
                        <td><?= $res['stok'];?> <?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Keluar</th>
                        <td>:</td>
                        <td><?= $res['jumlah_keluar'];?> <?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Keluar</th>
                        <td>:</td>
                        <td><?= $res['tanggal_keluar'];?></td>
                    </tr>
                    <tr>
                        <th>Tujuan</th>
                        <td>:</td>
                        <td><?= $res['tujuan'];?></td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <img src="assets/img/<?= $res['foto_barang'];?>" alt="" >
            </div>
        </div>
    </div>
</div>