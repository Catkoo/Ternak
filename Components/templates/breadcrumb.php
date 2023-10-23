<div class="breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php
                if($page == ""){
                    echo '<li class="breadcrumb-item"><a href="#">Dashboard</a></li>';
                }elseif($page == "data-barang"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang</a></li>';
                }elseif($page == "detail-barang"){
                    echo' <li class="breadcrumb-item"><a href="#">Data Barang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Barang</li>';
                }elseif($page == "data-satuan"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Satuan</a></li>';
                }elseif($page == "supplier"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Supplier</a></li>';
                }elseif($page == "barang-masuk"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Masuk</a></li>';
                }elseif($page == "add_bm"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Masuk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Barang Masuk</li>';
                }elseif($page == "detail_bm"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Masuk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Barang Masuk</li>';
                }elseif($page == "barang-keluar"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Keluar</a></li>';
                }elseif($page == "add_bk"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Keluar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Barang Keluar</li>';
                }elseif($page == "detail-bk"){
                    echo '<li class="breadcrumb-item"><a href="#">Data Barang Keluar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Barang Keluar</li>';
                }elseif($page == "report"){
                    echo'<li class="breadcrumb-item"><a href="#">Report Data</a></li>';
                }elseif($page == "tambah_user"){
                    echo '<li class="breadcrumb-item"><a href="#">Tambah User</a></li>';
                }
            ?>
        </ol>
    </nav>
</div>