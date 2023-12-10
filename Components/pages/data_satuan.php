<?php
if(isset($_POST['tambahSatuan'])){
    if(tambahSatuan($_POST) > 0){
        echo "<script>alert('data berhasil diinput');</script>";
        echo "<meta http-equiv='refresh' content='1;url=?page=data-satuan'>";
    }
}
if(isset($_POST['editSatuan'])){
    if(editSatuan($_POST) > 0){
        echo "<script>alert('data berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-satuan'>";
    }
}

if(isset($_POST['delete'])){
    if(deleteSatuan($_POST) > 0){
        echo "<script>alert('data berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-satuan'>";
    }
}
?>


<button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addSatuan">+ Tambah Data Satuan</button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Satuan</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
$no = 1;
$sql = $koneksi->query("SELECT * FROM satuan ORDER BY update_at DESC");
while ($data = $sql->fetch_assoc()) { ?>
    <tbody>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $data['nama_satuan']; ?></td>
            <td><?= date('d/m/Y H:i', strtotime($data['update_at'])); ?></td>
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#update<?= $data['id_satuan']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                <form method="post" class="d-inline">
                    <input type="hidden" value="<?= $data['id_satuan']; ?>" name="id">
                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>
        </tr>
    </tbody>

                    <!-- MODAL EDIT SATUAN-->
                    <div class="modal fade" id="update<?= $data['id_satuan'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Update Satuan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="">ID</label>
                                        <input type="text" class="form-control" name="id" value="<?= $data['id_satuan'];?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Nama Satuan</label>
                                        <input type="text" class="form-control" name="nama_satuan" value="<?= $data['nama_satuan'];?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="editSatuan">Submit</button>
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

<!-- MODAL ADD SATUAN-->
<div class="modal fade" id="addSatuan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Satuan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">ID</label>
                    <input type="text" class="form-control" name="id" value="<?= $idSatuan;?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="">Nama Satuan</label>
                    <input type="text" class="form-control" name="nama_satuan">
                    <small><i>ex: box, dus, dll</i></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="tambahSatuan">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>