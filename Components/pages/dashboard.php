
<div class="card-info">
    <div class="card text-bg-primary">
        <i class="fa-solid fa-cubes icon"></i>
        <p class="text">Data Barang</p>
        <p class="jml"><?= $resultBrg;?> Data</p>
    </div>
    <div class="card text-bg-success">
        <i class="fa-solid fa-cart-flatbed-suitcase icon"></i>
        <p class="text">Barang Masuk</p>
        <p class="jml"><?= $resultBm;?> Data</p>
    </div>
    <div class="card text-bg-danger">
        <i class="fa-solid fa-truck icon"></i>
        <p class="text">Barang Keluar</p>
        <p class="jml"><?= $resultBk;?> Data</p>
    </div>
    <div class="card text-bg-secondary">
        <i class="fa-solid fa-users icon"></i>
        <p class="text">Supplier</p>
        <p class="jml"><?= $resultSup;?> Data</p>
    </div>
</div>

    <div class="card text-bg-warning"> <!-- Ganti primary ke warning -->
            <?php
                // Ambil data stok barang dari database
            $sqlStok = $koneksi->query("SELECT * FROM barang");
            while ($dataStok = $sqlStok->fetch_assoc()) {
            $namaBarang = $dataStok['nama_barang'];
            $stokBarang = $dataStok['stok'];

    // Periksa jika stok kurang dari 50
    if ($stokBarang < 50) {
        echo "<div class='alert alert-danger' role='alert'>Stok $namaBarang menipis ($stokBarang)</div>";
    }
}
?>

        </p>
    </div>
</div>


    </div>
    <div class="col">
        <div class="card">
            <div class="card-header text-center">HISTORY</div>
            <div class="card-body">
                <!-- 
                    KONTEN DIBUAT DIFILE SCRIPT.JS PADA COMMENT 'MENAMPILKAN LIST HISTORY'
                    PEMANGGILAN MENGGUAKAN CLASS HISTORY.
                -->
                <ul class="list-group list-group-flush history"></ul>
            </div>
        </div>
    </div>
</div>



