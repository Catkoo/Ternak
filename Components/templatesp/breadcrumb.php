<div class="breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php
                if($page == ""){
                    echo '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
                } elseif($page == "tambah_user"){
                    echo '<li class="breadcrumb-item"><a href="#">Tambah User</a></li>';
                }elseif($page == "report_bm"){
                    echo '<li class="breadcrumb-item"><a href="#">Report Barang Masuk</a></li>';
                }elseif($page == "report_bk"){
                    echo '<li class="breadcrumb-item"><a href="#">Report Barang Keluar</a></li>';
                }
            ?>
        </ol>
    </nav>
</div>