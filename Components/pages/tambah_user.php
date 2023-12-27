<?php
// Fungsi untuk menambah pengguna
if (isset($_POST['addUser'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $rpassword = md5($_POST['rpassword']);
    $role = $_POST['role'];
    $email = $_POST['email']; // Added email field

    // Memeriksa apakah ada kolom yang kosong
    if (empty($nama) || empty($username) || empty($_POST['password']) || empty($_POST['rpassword']) || empty($email)) {
        echo "<script>alert('Data tidak boleh kosong!');</script>";
    } else {
        // Lanjutkan pemrosesan jika tidak ada kolom yang kosong

        // Validasi email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Format email tidak valid!');</script>";
        } else {
            // Validasi panjang password
            if (strlen($_POST['password']) < 8) {
                echo "<script>alert('Password minimal harus 8 karakter!');</script>";
            } else {
                // Lakukan validasi lainnya seperti yang telah Anda lakukan sebelumnya
                // ...

                if ($password !== $rpassword) {
                    echo "<script>alert('Password tidak sesuai!');</script>";
                } else {
                    // Check if email already exists
                    $emailExists = checkEmailExists($email);
                    if ($emailExists) {
                        echo "<script>alert('Email sudah digunakan. Silakan gunakan email yang lain!');</script>";
                    } else {
                        $result = addUser($nama, $username, $password, $rpassword, $role, $email);

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
            }
        }
    }
}


// Function to check if email already exists
function checkEmailExists($email) {
    global $koneksi;

    // Query to check if the email already exists
    $query = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    return $query->num_rows > 0; // Return true if email exists, false otherwise
}

// Fungsi untuk mengedit pengguna
if (isset($_POST['editUser'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    // Cek apakah pengguna ingin mengubah kata sandi
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $rpassword = md5($_POST['rpassword']);

        // Validasi apakah kata sandi dan konfirmasi ulang kata sandi cocok
        if ($password !== $rpassword) {
            echo "<script>alert('Password tidak sesuai!');</script>";
        } else if (strlen($_POST['password']) < 8) {
            echo "<script>alert('Password harus minimal 8 karakter!');</script>";
        } else {
            $result = editUser($id, $nama, $username, $password, $rpassword);
        }
    } else {
        // Pengguna tidak ingin mengubah kata sandi
        // Disini kita melakukan pengecekan terhadap keseluruhan data yang diisi
        if (!empty($nama) && !empty($username)) {
            // Hapus bagian yang berkaitan dengan edit role di sini

            $result = editUserWithoutPassword($id, $nama, $username);
        } else {
            echo "<script>alert('Semua data harus diisi!');</script>";
        }
    }

    // Tambahkan notifikasi
    if (isset($result) && $result === 1) {
        echo "<script>alert('Informasi pengguna berhasil diubah');</script>";
    } else if (isset($result) && $result === -1) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else if (isset($result) && $result === -2) {
        echo "<script>alert('Tidak Ada Data Yang Diubah!');</script>";
    } else if (isset($result) && $result === -3) {
        echo "<script>alert('Informasi pengguna berhasil diubah, tetapi peran (role) tidak berhasil diubah.');</script>";
        // You can customize the message above based on your specific requirements
    } else if (isset($result) && $result === 2) {
        echo "<script>alert('Tidak Ada Data Yang Diubah');</script>";
    } else {
        echo "<script>alert('Gagal mengubah informasi pengguna');</script>";
    }
}

// Fungsi untuk menghapus pengguna
if (isset($_POST['deleteUser'])) {
    $id = $_POST['id'];
    $role = getRoleById($id);

    // Pengecekan role sebelum memanggil deleteUser
    if ($role === 'pimpinan') {
        echo "<script>alert('Akun pimpinan tidak dapat dihapus!');</script>";
    } else {
        $result = deleteUser($id);

        if ($result === 1) {
            echo "<script>alert('User berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Gagal menghapus user!');</script>";
        }
    }
}
function getRoleById($id) {
    global $koneksi;

    $query = $koneksi->prepare("SELECT role FROM users WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->bind_result($role);
    $query->fetch();

    return $role;
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
                        <!-- <th>Password</th> -->
                        <th>Role</th> <!-- Tambahkan kolom Role -->
                        <th>Email</th>
                        <th>Latest Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
$no = 1;
$sql = $koneksi->query("SELECT * FROM users ORDER BY latest_update DESC");
while ($data = $sql->fetch_assoc()) { ?>
    <tbody>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['username']; ?></td>
            <!-- <td>Password Telah Dienkripsi</td> -->
            <td><?= $data['role']; ?></td> <!-- Menampilkan peran (role) -->
            <td><?= $data['email']; ?></td>
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
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $data['email']; ?>" readonly>
                    </div>
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
                    <div class="mb-2">
                        <label for="rpassword">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="rpassword" name="rpassword">
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
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="user@example.com">
                    </div>
                    <div class="mb-2">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-2">
                        <label for="rpassword">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="rpassword" name="rpassword">
                    </div>
                    <div class="mb-2">
                        <label for="role">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin">admin</option>
                            <!-- <option value="pimpinan">pimpinan</option> -->
                            <!-- Tambahkan opsi untuk peran lainnya jika diperlukan -->
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addUser">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

            </form>
        </div>
    </div>
</div>
