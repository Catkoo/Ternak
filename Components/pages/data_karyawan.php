<?php
if(isset($_POST['tambahKaryawan'])){
    if(tambahKaryawan($_POST) > 0){
        echo "<script>alert('data berhasil diinput');</script>";
        echo "<meta http-equiv='refresh' content='1;url=?page=karyawan'>";
    }
}
if(isset($_POST['editKaryawan'])){
    if(editKaryawan($_POST) > 0){
        echo "<script>alert('data berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawan'>";
    }
}

if(isset($_POST['delete'])){
    if(deleteKaryawan($_POST) > 0){
        echo "<script>alert('data berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawan'>";
    }
}
?>


<button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addKary">+ Tambah Data Karyawan</button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>No Karyawan</th>
                        <th>Alamat Karyawan</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $no =1;
                $sql = $koneksi->query("SELECT * FROM karyawan");
                while($data = $sql->fetch_assoc()){?>
                    <tbody>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $data['nik'];?></td>
                            <td><?= $data['nama_kary'];?></td>
                            <td><?= $data['telepon_kary'];?></td>
                            <td><?= $data['alamat_kary'];?></td>
                            <td><?= date('d/m/Y H:i', strtotime($data['latest_update']));?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#update<?= $data['id_kary'];?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_kary'];?>" name="id">
                                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>

                    <!-- Modal Edit Supplier-->
                    <div class="modal fade" id="update<?= $data['id_kary'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Update Karyawan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form method="post">
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label for="">ID</label>
                                        <input type="text" class="form-control" name="id" value="<?= $data['id_kary'];?>" readonly>
                                    </div>
                                     <div class="mb-2">
                                        <label for="">NIK</label>
                                        <input type="text" class="form-control" name="nik" value="<?= $data['nik'];?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Nama Karyawan</label>
                                        <input type="text" class="form-control" name="karyawan" value="<?= $data['nama_kary'];?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">No Karyawan</label>
                                        <input type="text" class="form-control" name="no" value="<?= $data['telepon_kary'];?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="">Alamat Karyawan</label>
                                        <textarea class="form-control" name="alamat"><?= $data['alamat_kary'];?></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="editKaryawan">Submit</button>
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
<div class="modal fade" id="addKary" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Karyawan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post">
            <div class="modal-body">
                <div class="mb-2">
                    <label for="">ID</label>
                    <input type="text" class="form-control" name="idkary" value="<?= $idKary;?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="">NIK</label>
                    <input type="text" class="form-control" name="nik">
                </div>
                <div class="mb-2">
                    <label for="">Nama Karyawan</label>
                    <input type="text" class="form-control" name="karyawan">
                </div>
                <div class="mb-2">
                    <label for="">No Karyawan</label>
                    <input type="text" class="form-control" name="no">
                </div>
                <div class="mb-2">
                    <label for="">Alamat Karyawan</label>
                    <textarea class="form-control" name="alamat"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="tambahKaryawan">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>