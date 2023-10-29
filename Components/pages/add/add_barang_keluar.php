<?php
if (isset($_POST['addBK'])) {
    if (empty($_SESSION['last_token']) || $_SESSION['last_token'] != $_POST['token']) {
        $_SESSION['last_token'] = $_POST['token']; // Simpan token terakhir
        if (tambahBarangKeluar($_POST) > 0) {
            echo "<script>alert('Data Berhasil Di Tambahkan');</script>";
            echo "<meta http-equiv='refresh' content='0;url=?page=barang-keluar'>";
        }
    }
}

if (isset($_POST['delete'])) {
    if (deleteBarangKeluar($_POST) > 0) {
        echo "<script>alert('Data Berhasil Dihapus');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=barang-keluar'>";
    }
}
?>

<form action="" method="post">
    <select class="select2 js-states form-control" name="barang" onchange="this.form.submit()">
        <option value="">Select One</option>
        <?php
        $qry = $koneksi->query("SELECT * FROM barang");
        while ($data = $qry->fetch_assoc()) { ?>
            <option value="<?= $data['id_barang'] ?>"
                <?php if (isset($_POST['barang']) && $_POST['barang'] == $data['id_barang']) {echo 'selected';} ?>>
                <?= $data['nama_barang']; ?>
            </option>
        <?php } ?>
    </select>
</form>

<?php
if (isset($_POST['barang'])) {
    $sql = $koneksi->query("SELECT * FROM barang JOIN satuan ON satuan.id_satuan=barang.satuan_id WHERE id_barang='$_POST[barang]'");
    $result = $sql->fetch_assoc();
?>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form method="post">
                        <div class="mb-2">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="barang" value="<?= $result['nama_barang']; ?>" readonly>
                            <input type="hidden" class="form-control" name="id" value="<?= $idBK; ?>" readonly>
                            <input type="hidden" class="form-control" name="idBRG" value="<?= $result['id_barang']; ?>" readonly>
                            <input type="hidden" class="form-control" name="token" value="<?= md5(uniqid(rand(), TRUE)); ?>">
                        </div>
                        <div class="mb-2">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control" name="jml" min="1" required>
                        </div>
                        <div class="mb-2">
                            <label for="">Tujuan</label>
                            <textarea name="tujuan" rows="3" class="form-control" required></textarea>
                        </div>
                        <button class="btn btn-primary" name="addBK">Submit</button>
                    </form>
                </div>
                <div class="col">
                    <img src="assets/img/<?= $result['foto_barang']; ?>" alt="" style="width:320px; height:200px">
                    <div class="row">
                        <div class="col">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" value="<?= $result['nama_satuan']; ?>" readonly>
                        </div>
                        <div class="col">
                            <label for="">Stok Saat Ini</label>
                            <input type="text" class="form-control" value="<?= $result['stok']; ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <form method="post">
                        <div class="mb-2">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" name="barang" value="No Data Selected" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="">Jumlah</label>
                            <input type="text" class="form-control" value="No Data Selected" readonly>
                        </div>
                        <div class="mb-2">
                            <label for="">Tujuan</label>
                            <textarea name="tujuan" rows="3" class="form-control" readonly>No Data Selected</textarea>
                        </div>
                        <button class="btn btn-primary" name="addBK" disabled>Submit</button>
                    </form>
                </div>
                <div class="col">
                    <img src="assets/img/<?= $result['foto_barang']; ?>" alt="" style="width:320px; height:200px">
                    <div class="row">
                        <div class="col">
                            <label for="">Satuan</label>
                            <input type="text" class="form-control" value="No Data Selected" readonly>
                        </div>
                        <div class="col">
                            <label for="">Stok Saat Ini</label>
                            <input type="text" class="form-control" value="No Data Selected" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
