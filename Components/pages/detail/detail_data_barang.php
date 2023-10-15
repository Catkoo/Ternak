<?php
$id = $_GET['id'];

$sql = $koneksi->query("SELECT * FROM barang JOIN satuan ON satuan.id_satuan=barang.satuan_id WHERE id_barang='$id'");
$res = $sql->fetch_assoc();
?>
<a href="?page=data-barang" class="btn btn-primary btn-sm mb-3">Kembali</a>
<div class="card detail-data-barang">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <img src="assets/img/<?= $res['foto_barang'];?>" alt="">
            </div>
            <div class="col">
                <table class="table">
                    <tr>
                        <td>ID</td>
                        <td>:</td>
                        <td><?= $res['id_barang'];?></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td>:</td>
                        <td><?= $res['nama_barang'];?></td>
                    </tr>
                    <tr>
                        <td>Satuan</td>
                        <td>:</td>
                        <td><?= $res['nama_satuan'];?></td>
                    </tr>
                    <tr>
                        <td>Stok</td>
                        <td>:</td>
                        <td><?= $res['stok'];?></td>
                    </tr>
                    <tr>
                        <td>Latest Update</td>
                        <td>:</td>
                        <td><?= date('d/m/Y H:i', strtotime($res['update_at']));?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
