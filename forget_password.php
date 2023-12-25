<?php
session_start();
include "config/koneksi.php";
include "config/function.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $query = $koneksi->prepare("SELECT id, username, reset_token FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        $userId = '';
        $username = '';
        $currentToken = '';
        $query->bind_result($userId, $username, $currentToken);
        $query->fetch();

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Store the new token in the database and set token expiration
        $updateTokenQuery = $koneksi->prepare("UPDATE users SET reset_token = ?, token_expiration = DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE id = ?");
        $updateTokenQuery->bind_param("si", $token, $userId);
        $updateTokenQuery->execute();

        // Send the reset link to the user's email
        $resetLink = "http://localhost/Ternak/reset_password.php?token=$token";

        // You can customize the email content as needed
        $subject = "Reset Password";
        $message = "Hello $username,\n\nYou have requested to reset your password. Click the link below to reset your password:\n$resetLink\n\nThis password reset link will expire in 5 minute.\n\nIf you did not request this, please ignore this email.";

        // Send the email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'mail.ternakgesek.my.id';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@ternakgesek.my.id';
        $mail->Password = 'ternakgesek19';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->setFrom('noreply@ternakgesek.my.id', 'Ternak Gesek');
        $mail->addAddress($email, $username);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            echo "<script>alert('Reset link has been sent to your email. Check your inbox.');</script>";
        } else {
            echo "<script>alert('Failed to send reset link. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Email not found.');</script>";
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
    <title>Forget Password</title>
</head>
<body>
    <div class="login">
        <div class="card login-card">
            <div class="card-body">
                <h1>FORGOT PASSWORD</h1>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="email" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" name="submit">Send Reset Link</button>
                    </div>
                </form>
                <p class="text-center mt-2">
                    <a href="login.php">Back to Login</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/plugins/Jquery/jquery-3.6.0-min.js"></script>
    <script src="assets/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/fontawesome-free-6.1.1/js/all.min.js"></script>
</body>
</html>
