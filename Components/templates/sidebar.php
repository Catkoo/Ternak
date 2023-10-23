<div class="sidebar" id="sidebar">
    <div class="logo">Inventory Ternak Ayam</div>
    <div class="sidebar-body">
        <ul>
            <a href="index.php">
                <li class="<?= $page=='' ? 'active' : '';?>"><i class="fa-solid fa-outdent"></i> Dashboard</li>
            </a>
            <a href="?page=data-barang">
                <li class="<?= $page=='data-barang' ? 'active' : '';?>"><i class="fa-solid fa-cubes"></i></i> Data Barang</li>
            </a>
            <a href="?page=data-satuan">
                <li class="<?= $page=='data-satuan' ? 'active' : '';?>"><i class="fa-solid fa-box-open"></i> Data Satuan</li>
            </a>
            <a href="?page=supplier">
                <li class="<?= $page=='supplier' ? 'active' : '';?>"><i class="fa-solid fa-users"></i> Data Supplier</li>
            </a>
            <hr>
            <a href="?page=barang-masuk">
                <li class="<?= $page=='barang-masuk' || $page=='add_bm' || $page=='detail_bm' ? 'active' : '';?>"><i class="fa-solid fa-cart-flatbed-suitcase"></i> Data Barang Masuk</li>
            </a>
            <a href="?page=barang-keluar">
                <li class="<?= $page=='barang-keluar' || $page=='add_bk' || $page=='detail-bk' ? 'active' : '';?>"><i class="fa-solid fa-truck"></i> Data Barang Keluar</li>
            </a>
            <hr>
            <a href="?page=report">
                <li class="<?= $page=='report' ? 'active' : '';?>"><i class="fa-solid fa-chart-pie"></i> Report</li>
            </a>
            <hr>
            <a href="?page=tambah_user">
                <li class="<?= $page=='tambah_user' ? 'active' : '';?>"><i class="fa-solid fa-users"></i> Data User</li>
            </a>
        </ul>
    </div>
</div>