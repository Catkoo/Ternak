<div class="sidebar" id="sidebar">
    <div class="logo">Inventory Ternak Ayam</div>
    <div class="sidebar-body">
        <ul>
            <a href="index_pemimpin.php">
                <li class="<?= $page=='' ? 'active' : '';?>"><i class="fa-solid fa-outdent"></i> Dashboard</li>
            </a>
            <hr>
           <a href="?page=report_bm">
                <li class="<?= $page=='report_bm' ? 'active' : '';?>"><i class="fa-solid fa-cart-flatbed-suitcase"></i> Report Barang Masuk</li>
            </a>
            <a href="?page=report_bk">
                <li class="<?= $page=='report_bk' ? 'active' : '';?>"><i class="fa-solid fa-truck"></i> Report Barang Keluar</li>
            </a>
            <hr>
            <a href="?page=tambah_user">
                <li class="<?= $page=='tambah_user' ? 'active' : '';?>"><i class="fa-solid fa-users"></i> Data User</li>
            </a>
        </ul>
    </div>
</div>