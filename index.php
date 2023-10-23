<?php
session_start();
error_reporting(1);
date_default_timezone_set('Asia/jakarta');
$page = $_GET['page'];
include "config/koneksi.php";
include "config/newID.php";
include "config/function.php";

if(!$_SESSION['login']){
    echo"<script>alert('Silahkan Login!');</script>";
    header("location:login.php");
}

include "Components/templates/header.php";
?>
<div class="content-body">
    <div class="container">
        <?php include "Components/templates/breadcrumb.php";?>
        <!-- content blank -->
        <?php   
        if($page == ""){
            include "Components/pages/dashboard.php";
            
        }elseif($page == "data-barang"){
            include "Components/pages/data_barang.php";
        }elseif($page == "detail-barang"){
            include "Components/pages/detail/detail_data_barang.php";

        }elseif($page == "data-satuan"){
            include "Components/pages/data_satuan.php";

        }elseif($page == "supplier"){
            include "Components/pages/data_supplier.php";

        }elseif($page == "barang-masuk"){
            include "Components/pages/barang_masuk.php";
        }elseif($page == "add_bm"){
            include "Components/pages/add/add_barang_masuk.php";
        }elseif($page == "detail_bm"){
            include "Components/pages/detail/detail_bm.php";

        }elseif($page == "barang-keluar"){
            include "Components/pages/barang_keluar.php";
        }elseif($page == "add_bk"){
            include "Components/pages/add/add_barang_keluar.php";
        }elseif($page == "detail-bk"){
            include "Components/pages/detail/detail_bk.php";
        }
        
        elseif($page == "report"){
            include "Components/pages/report.php";
        }elseif($page == "tambah_user"){
            include "Components/pages/tambah_user.php";
        }
        ?>
        
    </div>
</div><!-- content body -->
</div><!-- end page content -->
</main><!-- end main -->


<?php include "Components/templates/footer.php";?>