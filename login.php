<?php
ob_start();
session_start();
include "config/koneksi.php";
include "config/function.php";

if (isset($_SESSION['logout_message'])) {
    echo '<script>alert("' . $_SESSION['logout_message'] . '");</script>';
    unset($_SESSION['logout_message']); // Hapus pesan setelah menampilkannya
}

if (isset($_SESSION['login'])) {
    // Check if the user is logged in by checking the presence of 'login' in the session
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        // Check if 'role' is set and its value is 'admin', then redirect to 'index.php'
        header('location: index.php');
    } elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'pimpinan') {
        // Check if 'role' is set and its value is 'pimpinan', then redirect to 'index_pemimpin.php'
        header('location: index_pemimpin.php');
    }
}

if (isset($_POST['login'])) {
    if (loginFunc($_POST) > 0) {
        // Setelah login berhasil, tampilkan pesan alert menggunakan JavaScript
        echo '<script>alert("Login Berhasil!");</script>';

        // Setelah itu, cek peran pengguna
        $role = getRoleByUsername($_POST['username']); // Ganti dengan fungsi yang sesuai
        if ($role === 'admin') {
            header('location: index.php');
        } elseif ($role === 'pimpinan') {
            header('location: index_pemimpin.php');
        }
    } else {
        echo '<script>alert("Login Gagal!");</script>';
    }
}


function getRoleByUsername($username) {
    // Contoh cara mendapatkan peran berdasarkan username dari database
    global $koneksi;
    $query = $koneksi->prepare("SELECT role FROM users WHERE username = ?");
    $query->bindParam(1, $username);
    $query->execute();
    $result = $query->fetchColumn();
    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/plugins/bootstrap-5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-6.1.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Ternak Gesek</title>
</head>
<body>
    <div class="login">
        <div class="card login-card">
            <div class="card-body">
                <h1>LOGIN FORM</h1>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="password"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="password">
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" name="login">Login</button>
                    </div>
                </form>
                    <p class="text-center mt-2">
                    <a href="forget_password.php">Forget Password?</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/plugins/Jquery/jquery-3.6.0-min.js"></script>
    <script src="assets/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/fontawesome-free-6.1.1/js/all.min.js"></script>
</body>
</html>
