<?php
if(isset($_POST['delete'])){
    if(deleteBarangKLR($_POST) > 0){
        echo "<script>alert('Data Berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=barang-keluar'>";
    }
}
?>


<a href="?page=add_bk" class="btn btn-primary btn-sm mb-3">+ Tambah Data</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Keluar</th>
                        <th>Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no =1;
                    $sql = $koneksi->query("SELECT * FROM barang_keluar as bk JOIN barang as b ON bk.barang_id=b.id_barang LEFT JOIN satuan as st ON st.id_satuan=b.satuan_id JOIN history as h ON h.bmk_id=bk.id_bk WHERE role='BK' group by id_bk");
                    while($data = $sql->fetch_assoc()){?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $data['nama_barang'];?></td>
                            <td><span class="badge text-bg-danger">- <?= $data['jumlah_keluar'];?></span></td>
                            <td><?= date('d/m/Y H:i', strtotime($data['tanggal_keluar']));?></td>
                            <td><?= $data['tujuan'];?></td>
                            <td>
                                <a href="?page=detail-bk&id=<?= $data['id_bk'];?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-info"></i></a>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_bk'];?>" name="id">
                                    <input type="hidden" value="<?= $data['id_barang'];?>" name="id_brg">
                                    <input type="hidden" value="<?= $data['id'];?>" name="id_h">
                                    <input type="hidden" value="<?= $data['jumlah_keluar'];?>" name="jml">

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