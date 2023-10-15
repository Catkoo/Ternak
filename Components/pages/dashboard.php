<!-- 
    VARIABEL 'RESULTBRG ETC' DI PANGGIL DARI FILE FUNCTION.PHP
-->
<div class="card-info ">
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
     <div class="card text-bg-secondary">
        <i class="fa-solid fa-users icon"></i>
        <p class="text">Karyawan</p>
        <p class="jml"><?= $resultSup;?> Data</p>
    </div>
</div>

<!-- 
    PEMBUATAN QUERY YANG DIKIRIM KE FILE SCRIPT.PHP
    UNTUK MENAMPILKAN DATA GRAFIK BARANG MASUK DAN KELUAR
-->
<!-- <?php
$sqlBm = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah_masuk FROM barang_masuk");
while($resBM = $sqlBm->fetch_assoc()){
    $dataBM[] = $resBM["jumlah_masuk"];
}

$sqlBk = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah_keluar FROM barang_keluar");
while($resBK = $sqlBk->fetch_assoc()){
    $dataBK[] = $resBK["jumlah_keluar"];
}
?> -->


<div class="row ml-1">
    <div class="col-md-8">
        <div class="card card-body">
            <canvas id="myChart" style="margin: 0 auto;"></canvas>
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



