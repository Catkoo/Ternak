<?php
ob_start();
session_start();
error_reporting(1);
date_default_timezone_set('Asia/jakarta');
$page = $_GET['page'];
include "config/koneksi.php";
include "config/newID.php";
include "config/function.php";

if (!isset($_SESSION['login'])) {
    echo "<script>alert('Silahkan Login!');</script>";
    header("location: login.php");
}
include "Components/templatesp/header.php";
?>
<div class="content-body">
    <div class="container">
        <?php include "Components/templatesp/breadcrumb.php";?>
        <!-- content blank -->
        <?php   
        if($page == ""){
            include "Components/pages/dashboard.php";      
        }elseif($page == "tambah_user"){
            include "Components/pages/tambah_user.php";
        }elseif($page == "report_bm"){
            include "Components/pages/report_bm.php";
        }elseif($page == "report_bk"){
            include "Components/pages/report_bk.php";
        }
        ?>
        
    </div>
</div><!-- content body -->
</div><!-- end page content -->
</main><!-- end main -->


<?php include "Components/templatesp/footer.php";?>