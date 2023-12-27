<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/plugins/bootstrap-5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-6.1.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/DataTables/datatables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Inventory Ternak Ayam</title>
</head>
<body>
    <main>
        <?php include "Components/templatesp/sidebar.php";?>
        <div class="page-content" id="page">
            <nav class="navbar navbar-expand-lg">
                <a href="#" class="navbar-brand" onclick="toggle()"><i class="fa-solid fa-bars"></i></a>
                <div class="navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav  ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-capitalize" href="#" id="navbarDarkDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Welcome <?= $_SESSION['login']['username'];?> <i class="fa-solid fa-user-large"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-profile" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <!-- <li><a class="dropdown-item" href="#changePass" data-bs-toggle="modal">Change Password</a></li> -->
                                <li><a class="dropdown-item" href="logout.php" id="logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- modal change password -->
            <div class="modal fade" id="changePass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="">Old Password</label>
                                    <input type="password" name="oldpassword" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="">New Password</label>
                                    <input type="password" name="newpassword" class="form-control">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="changepwd">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>