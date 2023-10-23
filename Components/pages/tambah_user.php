<?php
// Fungsi untuk menambah pengguna
// Fungsi untuk menambah pengguna
// Fungsi untuk menambah pengguna
if (isset($_POST['addUser'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $rpassword = md5($_POST['rpassword']); // Tambahkan ini untuk repeated password

    // Validasi apakah kata sandi dan repeated password sama
    if ($password !== $rpassword) {
        echo "<script>alert('Password tidak sesuai!');</script>";
    } else {
        $result = addUser($nama, $username, $password, $rpassword);

        if ($result === 1) {
            echo "<script>alert('User berhasil ditambahkan!');</script>";
        } else if ($result === -1) {
            echo "<script>alert('Username sudah digunakan!');</script>";
        } else if ($result === -2) {
            echo "<script>alert('Error saat menambahkan user!');</script>";
        } else {
            echo "<script>alert('Gagal menambahkan user!');</script>";
        }
    }
}




// Fungsi untuk mengedit pengguna
if (isset($_POST['editUser'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = editUser($id, $nama, $username, $password);

    if ($result === 1) {
        echo "<script>alert('User berhasil diubah!');</script>";
    } else if ($result === -1) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else if ($result === -2) {
        echo "<script>alert('Password tidak sesuai!');</script>";
    } else {
        echo "<script>alert('Gagal mengubah user!');</script>";
    }
}

// Fungsi untuk menghapus pengguna
if (isset($_POST['deleteUser'])) {
    $id = $_POST['id'];

    $result = deleteUser($id);

    if ($result === 1) {
        echo "<script>alert('User berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus user!');</script>";
    }
}
?>

<button class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#addUser">+ Tambah Data User</button>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                $sql = $koneksi->query("SELECT * FROM users");
                while ($data = $sql->fetch_assoc()) { ?>
                    <tbody>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $data['nama']; ?></td>
                            <td><?= $data['username']; ?></td>
                            <td><?= $data['password']; ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($data['latest_update']));?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#update<?= $data['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id']; ?>" name="id">
                                    <button class="btn btn-danger btn-sm" name="deleteUser"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>

                    <!-- Modal Edit User-->
                    <div class="modal fade" id="update<?= $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Update User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                                        <div class="mb-2">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama']; ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?= $data['username']; ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="editUser">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php $no++;
                } ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add User-->
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Data User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-2">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-2">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-2">
                        <label for="rpassword">Ulangi Password</label>
                        <input type="password" class="form-control" id="rpassword" name="rpassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addUser">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
