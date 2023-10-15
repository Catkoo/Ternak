<form method="post" class="form-report" style="">
    <input type="date" class="form-control" name="start" required>
    <input type="date" class="form-control" name="end" required>
    <button class="btn btn-primary" name="filter" type="submit" style="width:120px;">Filter</button>
</form>

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <?php 
            if(isset($_POST['filter'])){
                $start = $_POST['start'];
                $end = $_POST['end'];
            ?>
                <a href="export.php?start=<?= $start;?>&end=<?= $end;?>" class="btn btn-primary mb-4">EXPORT</a>
                <table class="table" id="data-table-report">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Jumlah Masuk</th>
                            <th>Tanggal Masuk</th>
                            <th>Jumlah Keluar</th>
                            <th>Tanggal Keluar</th>
                        </tr>
                    </thead>
                    <?php
                    $no =1;
                    $sql = $koneksi->query("SELECT br.id_barang, br.stok, br.nama_barang, br.satuan_id, st.id_satuan, st.nama_satuan, bk.barang_id, bk.tanggal_keluar, bk.jumlah_keluar, bm.barang_id, bm.tanggal_masuk, bm.jumlah_masuk
                    FROM barang as br
                    JOIN satuan as st ON st.id_satuan=br.satuan_id
                    LEFT JOIN barang_keluar as bk ON bk.barang_id=br.id_barang
                    LEFT JOIN barang_masuk as bm ON bm.barang_id=br.id_barang
                    WHERE date(bk.tanggal_keluar) BETWEEN '$start' AND '$end' 
                    OR date(bm.tanggal_masuk) BETWEEN '$start' AND '$end'
                    ");

                    while($data = $sql->fetch_array()){
                        $sqlBK = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah_keluar FROM barang_keluar WHERE date(tanggal_keluar) BETWEEN '$start' AND '$end' ");
                        $totBk = $sqlBK->fetch_array();

                        $sqlBM = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah_masuk FROM barang_masuk WHERE date(tanggal_masuk) BETWEEN '$start' AND '$end' ");
                        $totBm = $sqlBM->fetch_array();
                        ?>
                        <tbody>
                            <tr>
                                <td><?= $no;?></td>
                                <td><?= $data['nama_barang'];?></td>
                                <td><?= $data['nama_satuan'];?></td>
                                <td><?= $data['stok'];?></td>
                                <td><?= $data['jumlah_masuk'] != null ? $data['jumlah_masuk'] : '-';?></td>
                                <td><?= $data['tanggal_masuk'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_masuk'])) : '-';?></td>
                                <td><?= $data['jumlah_keluar'] != null ? $data['jumlah_keluar'] : '-';?></td>
                                <td><?= $data['tanggal_keluar'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_keluar'])) : '-';?></td>
                            </tr>
                        </tbody>
                    <?php $no++; } ?>
                    <tfoot>
                        <tr>
                            <th colspan="2" >Total Barang Masuk : </th>
                            <td colspan="6" ><?= $totBm['jumlah_masuk'] != null ? $totBm['jumlah_masuk'] : 'No Data Available';?></td>
                        </tr>
                        <tr>
                            <th colspan="2">Total Barang Keluar :</th>
                            <td colspan="6"><?= $totBk['jumlah_keluar'] != null ? $totBk['jumlah_keluar'] : 'No Data Available';?></td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-center">REPORT DATA DARI TANGGAL <b><?= date('d/m/Y', strtotime($start));?></b> SAMPAI <b><?= date('d/m/Y', strtotime($end));?></b></td>
                        </tr>
                    </tfoot> 

                   
                </table>
            <?php }else{
                echo "<p class='text-center'>No Data Selected</p>";
            } ?>
        </div>
    </div>
</div>




<!-- <?php
$no =1;
$sql = $koneksi->query("SELECT br.id_barang, br.stok, br.nama_barang, br.satuan_id, st.id_satuan, st.nama_satuan, bk.barang_id, bk.tanggal_keluar, bk.jumlah_keluar, bm.barang_id, bm.tanggal_masuk, bm.jumlah_masuk
FROM barang as br
JOIN satuan as st ON st.id_satuan=br.satuan_id
LEFT JOIN barang_keluar as bk ON bk.barang_id=br.id_barang
LEFT JOIN barang_masuk as bm ON bm.barang_id=br.id_barang
WHERE date(bk.tanggal_keluar) BETWEEN '$start' AND '$end' 
OR date(bm.tanggal_masuk) BETWEEN '$start' AND '$end'
");

while($data = $sql->fetch_array()){
    $sqlBK = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah_keluar FROM barang_keluar WHERE date(tanggal_keluar) BETWEEN '$start' AND '$end' ");
    $totBk = $sqlBK->fetch_array();

    $sqlBM = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah_masuk FROM barang_masuk WHERE date(tanggal_masuk) BETWEEN '$start' AND '$end' ");
    $totBm = $sqlBM->fetch_array();
    ?>
    <tbody>
        <tr>
            <td><?= $no;?></td>
            <td><?= $data['nama_barang'];?></td>
            <td><?= $data['nama_satuan'];?></td>
            <td><?= $data['stok'];?></td>
            <td><?= $data['jumlah_masuk'] != null ? $data['jumlah_masuk'] : '-';?></td>
            <td><?= $data['tanggal_masuk'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_masuk'])) : '-';?></td>
            <td><?= $data['jumlah_keluar'] != null ? $data['jumlah_keluar'] : '-';?></td>
            <td><?= $data['tanggal_keluar'] != null ? date('d/m/Y H:i', strtotime($data['tanggal_keluar'])) : '-';?></td>
        </tr>
    </tbody>
<?php $no++; } ?>
<tfoot>
    <tr>
        <th colspan="2" >Total Barang Masuk : </th>
        <td colspan="6" ><?= $totBm['jumlah_masuk'] != null ? $totBm['jumlah_masuk'] : 'No Data Available';?></td>
    </tr>
    <tr>
        <th colspan="2">Total Barang Keluar :</th>
        <td colspan="6"><?= $totBk['jumlah_keluar'] != null ? $totBk['jumlah_keluar'] : 'No Data Available';?></td>
    </tr>
    <tr>
        <td colspan="8" class="text-center">REPORT DATA DARI TANGGAL <b><?= date('d/m/Y', strtotime($start));?></b> SAMPAI <b><?= date('d/m/Y', strtotime($end));?></b></td>
    </tr>
</tfoot> -->
