<?php
include "config/koneksi.php";
include "config/function.php";

$token = $_GET['token'];
$isValidToken = validateToken($token);

if (isset($_POST['submit'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($isValidToken) {
        // Pemeriksaan password dan konfirmasi password
        if ($password == $confirmPassword) {
            $resetResult = resetPassword($token, $password);

            if ($resetResult) {
                // No need to cancel old token as it's already done in resetPassword
                $newToken = generateToken($resetResult);

                echo "<script>alert('Password has been successfully reset. You can now login with your new password.'); window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('An error occurred while resetting the password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Password and Confirm Password do not match. Please make sure they are the same.');</script>";
        }
    } else {
        echo "<script>alert('Invalid token. Please try again or request a new reset link.'); window.location.href = 'login.php';</script>";
    }
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
    <title>Reset Password</title>
</head>
<body>
    <div class="login">
        <div class="card login-card">
            <div class="card-body">
                <h1>RESET PASSWORD</h1>

                <?php
                if ($isValidToken) {
                    // Token valid, tampilkan formulir reset password
                ?>
                    <form method="post" action="">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" placeholder="New Password" aria-label="New Password" aria-describedby="basic-addon1" name="password" required minlength="8">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon2"><i class="fa-solid fa-key"></i></span>
                            <input type="password" class="form-control" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="basic-addon2" name="confirm_password" required minlength="8">
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit" name="submit">Reset Password</button>
                        </div>
                    </form>
                <?php
                } else {
                    // Token tidak valid, berikan pesan kesalahan
                    echo "<p class='text-danger'>Token tidak valid. Silakan coba lagi atau minta tautan reset yang baru.</p>";
                }
                ?>

            </div>
        </div>
    </div>

    <script src="assets/plugins/Jquery/jquery-3.6.0-min.js"></script>
    <script src="assets/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/fontawesome-free-6.1.1/js/all.min.js"></script>
</body>
</html>
