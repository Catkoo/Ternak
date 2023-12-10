<?php
if(isset($_POST['tambahSupplier'])){
    if(tambahSupplier($_POST) > 0){
        echo "<script>alert('data berhasil diinput');</script>";
        echo "<meta http-equiv='refresh' content='1;url=?page=supplier'>";
    }
}
if(isset($_POST['editSupplier'])){
    if(editSupplier($_POST) > 0){
        echo "<script>alert('data berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=supplier'>";
    }
}

if(isset($_POST['delete'])){
    if(deleteSupplier($_POST) > 0){
        echo "<script>alert('data berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=supplier'>";
    }
}
?>


<button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addSupp">+ Tambah Data Supplier</button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>No Supplier</th>
                        <th>Alamat Supplier</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
$no = 1;
$sql = $koneksi->query("SELECT * FROM supplier ORDER BY latest_update DESC");
while ($data = $sql->fetch_assoc()) { ?>
    <tbody>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $data['nama_sup']; ?></td>
            <td><?= $data['telepon_sup']; ?></td>
            <td><?= $data['alamat_sup']; ?></td>
            <td><?= date('d/m/Y H:i', strtotime($data['latest_update'])); ?></td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#update<?= $data['id_sup']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                <form method="post" class="d-inline">
                    <input type="hidden" value="<?= $data['id_sup']; ?>" name="id">
                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    </tbody>

                    <!-- Modal Edit Supplier-->
                    <div class="modal fade" id="update<?= $data['id_sup'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Update Supplier</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="">ID</label>
                                        <input type="text" class="form-control" name="id" value="<?= $data['id_sup'];?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Nama Supplier</label>
                                        <input type="text" class="form-control" name="supplier" value="<?= $data['nama_sup'];?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">No Supplier</label>
                                        <input type="text" class="form-control" name="no" value="<?= $data['telepon_sup'];?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Alamat Supplier</label>
                                        <textarea class="form-control" name="alamat"><?= $data['alamat_sup'];?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="editSupplier">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                <?php $no++; } ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add-->
<div class="modal fade" id="addSupp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Supplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">ID</label>
                    <input type="text" class="form-control" name="idsup" value="<?= $idSupp;?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="">Nama Supplier</label>
                    <input type="text" class="form-control" name="supplier">
                </div>
                <div class="mb-2">
                    <label for="">No Supplier</label>
                    <input type="text" class="form-control" name="no">
                </div>
                <div class="mb-2">
                    <label for="">Alamat Supplier</label>
                    <textarea class="form-control" name="alamat"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="tambahSupplier">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>