<?php
if(isset($_POST['tambahBarang'])){
    if(tambahBarang($_POST) > 0){
        echo "<script>alert('Data Berhasil Di Tambahkan');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-barang'>";
    }
}
if(isset($_POST['editBarang'])){
    if(editBarang($_POST) > 0){
        echo "<script>alert('Data Berhasil Diubah!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-barang'>";
    }
}

if(isset($_POST['delete'])){
    if(deleteBarang($_POST) > 0){
        echo "<script>alert('Data Berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=data-barang'>";
    }
}
?>

<button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addBarang">+ Tambah Data Barang</button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="data-table" class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = $koneksi->query("SELECT barang.*, satuan.id_satuan, satuan.nama_satuan FROM barang JOIN satuan ON satuan.id_satuan=barang.satuan_id ORDER BY update_at DESC");
                    while($data = $sql->fetch_assoc()){?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $data['nama_barang'];?></td>
                            <td><?= $data['nama_satuan'];?></td>
                            <td><?= $data['stok'];?></td>
                            <td><?= date('d/m/Y H:i', strtotime($data['update_at']));?></td>
                            <td>
                                <a href="?page=detail-barang&id=<?= $data['id_barang'];?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-info"></i></a>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#update<?= $data['id_barang'];?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_barang'];?>" name="id">
                                    <input type="hidden" value="<?= $data['foto_barang'];?>" name="foto">
                                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>

                        <!--########### MODAL EDIT DATA BARANG #########-->
                        <div class="modal fade" id="update<?= $data['id_barang'];?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Update Data Barang</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label for="">ID</label>
                                                <input type="text" class="form-control" name="id" value="<?= $data['id_barang'];?>" readonly>
                                            </div>
                                            <div class="mb-2">
                                                <label for="">Nama Barang</label>
                                                <input type="text" class="form-control" name="nama_barang" value="<?= $data['nama_barang'];?>">
                                            </div>
                                            <div class="mb-2">
                                                <label for="">Stok Saat ini</label>
                                                <select name="satuan" class="form-control">
                                                    <?php 
                                                    $qry = $koneksi->query("SELECT * FROM satuan");
                                                    while($stn = $qry->fetch_assoc()){?>
                                                        <option value='<?= $stn['id_satuan'];?>' <?php if($stn['id_satuan'] == $data['satuan_id']){
                                                            echo "selected";
                                                        }?> ><?= $stn['nama_satuan'];?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label for="">Foto Produk</label>
                                                <input type="hidden" class="form-control" name="imgLama" value="<?= $data['foto_barang'];?>">
                                                <input type="file" class="form-control" name="newImg">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="editBarang">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php $no++; } ?>
                    <!-- END WHILE -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL ADD DATA BARANG -->
<div class="modal fade" id="addBarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="">ID</label>
                        <input type="text" class="form-control" name="id" value="<?= $idBarang;?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                    <div class="mb-2">
                        <label for="">Satuan</label>
                        <select name="satuan" class="form-control" required>
                            <option value="">Select One</option>
                            <?php 
                            $qry = $koneksi->query("SELECT * FROM satuan");
                            while($stn = $qry->fetch_assoc()){
                                echo "<option value='".$stn['id_satuan']."'>".$stn['nama_satuan']."</option>";
                            }?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="">Upload Gambar</label>
                        <input type="file" class="form-control" name="gambar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="tambahBarang">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
