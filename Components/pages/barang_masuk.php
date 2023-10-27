<?php
if(isset($_POST['delete'])){
    if(deleteBarangMsk($_POST) > 0){
        echo "<script>alert('Data Berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=barang-masuk'>";
    }
}
$filterStart = '';
$filterEnd = '';

if (isset($_POST['filter'])) {
    // Ambil tanggal awal dan tanggal akhir dari form
    $filterStart = $_POST['start'];
    $filterEnd = $_POST['end'];
}

?>


<a href="?page=add_bm" class="btn btn-primary btn-sm mb-3">+ Tambah Data</a>



<form method="post" class="form-report" style="">
    <input type="date" class="form-control" name="start" required>
    <input type="date" class="form-control" name="end" required>
    <button class="btn btn-primary" name="filter" type="submit" style="width:120px;">Filter</button>
    <a href="cetak_laporan.php?start=<?= $filterStart ?>&end=<?= $filterEnd ?>" class="btn btn-primary btn-sm mb-3">Cetak Laporan</a>
</form>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no =1;
                    if (empty($filterStart) && empty($filterEnd)) {
                     $sql = $koneksi->query("SELECT * FROM barang_masuk as bm JOIN barang as b ON bm.barang_id=b.id_barang JOIN supplier as sp ON bm.supplier_id=sp.id_sup JOIN history as h ON h.bmk_id=bm.id_bm WHERE role='BM' group by id_bm");
                    } else {
                     $sql = $koneksi->query("SELECT * FROM barang_masuk as bm JOIN barang as b ON bm.barang_id=b.id_barang JOIN supplier as sp ON bm.supplier_id=sp.id_sup JOIN history as h ON h.bmk_id=bm.id_bm WHERE role='BM' AND DATE(tanggal_masuk) BETWEEN '$filterStart' AND '$filterEnd' GROUP BY id_bm");
                    }
                    while($data = $sql->fetch_assoc()){?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $data['nama_barang'];?></td>
                            <td><?= $data['nama_sup'];?></td>
                            <td><span class="badge text-bg-success">+ <?= $data['jumlah_masuk'];?></span></td>
                            <td><?= date('d/m/Y H:i', strtotime($data['tanggal_masuk']));?></td>
                            <td>
                                <a href="?page=detail_bm&id=<?= $data['id_bm'];?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-info"></i></a>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_bm'];?>" name="id">
                                    <input type="hidden" value="<?= $data['id_barang'];?>" name="id_brg">
                                    <input type="hidden" value="<?= $data['id'];?>" name="id_h">
                                    <input type="hidden" value="<?= $data['jumlah_masuk'];?>" name="jml">

                                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php $no++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>