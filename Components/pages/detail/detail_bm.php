<?php
    $id = $_GET['id'];
    $sql = $koneksi->query("SELECT * FROM barang as b
    JOIN barang_masuk as bm ON bm.barang_id=b.id_barang
    JOIN supplier as sp ON sp.id_sup=bm.supplier_id
    JOIN satuan as st ON st.id_satuan=b.satuan_id
    WHERE bm.id_bm='$id'");
    $res = $sql->fetch_assoc();
?>

<a href="?page=barang-masuk" class="btn btn-primary btn-sm mb-2">Kembali</a>
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
                        <th>Supplier</th>
                        <td>:</td>
                        <td><?= $res['nama_sup'];?></td>
                    </tr>
                    <tr>
                        <th>Stok Barang</th>
                        <td>:</td>
                        <td><?= $res['stok'];?> <?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Masuk</th>
                        <td>:</td>
                        <td><?= $res['jumlah_masuk'];?> <?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>:</td>
                        <td><?= $res['tanggal_masuk'];?></td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <img src="assets/img/<?= $res['foto_barang'];?>" alt="">
            </div>
        </div>
    </div>
</div>