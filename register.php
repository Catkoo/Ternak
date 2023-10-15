<?php
session_start();
include "config/koneksi.php";
include "config/function.php";

if(isset($_POST['register'])){
    if(registerFunc($_POST) > 0){
        echo"
        <script>
            alert('Register Berhasil! Silahkan Login');window.location.href='login.php';
        </script>
        ";
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
    <title>REGISTER</title>
</head>
<body>
    <video autoplay muted loop class="bg-video">
        <source src="assets/video/backgroundvid.mp4" type="video/mp4">
    </video>
    
    <div class="login">
        <div class="card login-card">
            <div class="card-body">
                <h1>REGISTER FORM</h1>
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Nama" aria-label="name" aria-describedby="basic-addon1" name="name">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i></span>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="username">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="password"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Password" aria-label="Username" aria-describedby="basic-addon1" name="password">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="password"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Repeat Password" aria-label="Username" aria-describedby="basic-addon1" name="rpassword">
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" name="register">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script src="assets/plugins/Jquery/jquery-3.6.0-min.js"></script>
    <script src="assets/plugins/bootstrap-5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/fontawesome-free-6.1.1/js/all.min.js"></script>
</body>
</html>