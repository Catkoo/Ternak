<?php
if(isset($_POST['delete'])){
    if(deleteBarangKLR($_POST) > 0){
        echo "<script>alert('Data Berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=barang-keluar'>";
    }
}

$orderBy = 'tanggal_keluar DESC'; // Default sorting (urutkan berdasarkan tanggal keluar)
$filterNamaBarang = '';

if (isset($_POST['filter'])) {
    // Ambil bulan awal dari form
    $filterStart = $_POST['start'];
    $orderBy = 'tanggal_keluar ASC'; // Ubah pengurutan menjadi urutkan berdasarkan tanggal keluar secara menaik
    $filterNamaBarang = isset($_POST['nama_barang']) ? $_POST['nama_barang'] : '';
}
?>

<form method="post" class="form-report" style="">
    <input type="month" class="form-control" name="start" required>
    <input type="text" class="form-control" name="nama_barang" placeholder="Nama Barang">
    <button class="btn btn-primary btn-sm" name="filter" type="submit">Filter</button>
    <!-- Tombol Cetak Laporan Filtered dihapus -->
    <!-- <button id="cetakPDFFiltered" class="btn btn-primary btn-sm">Cetak Laporan Filtered (PDF)</button> -->
    <!-- Tombol Cetak Laporan Semua -->
    <button id="cetakPDFAll" class="btn btn-primary btn-sm">Download PDF</button>
</form>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Bulan Keluar</th>
                        <th>Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                   $filterCondition = "";
                if (!empty($filterStart)) {
                $filterCondition .= " AND DATE_FORMAT(tanggal_keluar, '%Y-%m') = '$filterStart'";
                }
                if (!empty($filterNamaBarang)) {
                 $filterCondition .= " AND b.nama_barang LIKE '%$filterNamaBarang%'";
                }
                    $sql = $koneksi->query("SELECT * FROM barang_keluar as bk JOIN barang as b ON bk.barang_id=b.id_barang LEFT JOIN satuan as st ON st.id_satuan=b.satuan_id JOIN history as h ON h.bmk_id=bk.id_bk WHERE role='BK' $filterCondition group by id_bk ORDER BY tanggal_keluar DESC");
                    while($data = $sql->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= $data['nama_barang'];?></td>
                            <td><span class="badge text-bg-danger">- <?= $data['jumlah_keluar'];?></span></td>
                            <td><?= date('d/m/Y', strtotime($data['tanggal_keluar']));?></td>
                            <td><?= $data['tujuan'];?></td>
                            <td>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_bk'];?>" name="id">
                                    <input type="hidden" value="<?= $data['id_barang'];?>" name="id_brg">
                                    <input type="hidden" value="<?= $data['id'];?>" name="id_h">
                                    <input type="hidden" value="<?= $data['jumlah_keluar'];?>" name="jml">
                                </form>
                            </td>
                        </tr>
                    <?php
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    var script = document.createElement('script');
    script.src = "node_modules/pdfmake/build/pdfmake.js";
    document.body.appendChild(script);

    // Fungsi untuk membuat laporan PDF
function generatePDF(data, title) {
    var currentDate = new Date().toLocaleDateString('id-ID');

    var docDefinition = {
        content: [
            {
                text: 'Ternak Ayam Pak Asun',
                style: 'header'
            },
            {
                text: 'Km.19 Gesek Toapaya Asri, Jl. Nuri No.19, Toapaya Sel., Kec. Toapaya\nNo HP: 081364711234',
                style: 'subheader'
            },
            {
                canvas: [
                    {
                        type: 'line',
                        x1: 0,
                        y1: 0,
                        x2: 513, // Sesuaikan lebar halaman
                        y2: 0,
                        lineWidth: 3,
                        lineColor: 'black'
                    }
                ]
            },
            {
                text: '\n\nLampiran : Laporan Barang Keluar', // Perubahan disini
                style: 'lampiran'
            },
            {
                text: `Tanggal    : ${currentDate}\n\n`, // Penambahan teks baru
                style: 'tanggal'
            },
            {
                table: {
                    headerRows: 1,
                    widths: [30, '*', 40, 70, '*'],
                    body: [
                        [{ text: 'No', style: 'tableHeader' }, { text: 'Nama Barang', style: 'tableHeader' }, { text: 'Jumlah', style: 'tableHeader' }, { text: 'Bulan Keluar', style: 'tableHeader' }, { text: 'Tujuan', style: 'tableHeader' }],
                        // Data laporan akan dimasukkan di sini
                    ]
                }
            },
            {
                text: '\n\n\n\n', // Berikan spasi
            },
            {
                columns: [
                    {
                        text: '',
                        alignment: 'left',
                    },
                    {
                        text: `Toapaya Selatan, ${currentDate}\nMengetahui,\n\n\n\n\n\n\n\n(     Herman Kurniawan     ) `,
                        alignment: 'right',
                        margin: [0, 0, 40, 0]
                    }
                ]
            }
        ],
        styles: {
            header: {
                fontSize: 18,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 20]
            },
            subheader: {
                fontSize: 12,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 8]
            },
            tableHeader: {
                fontSize: 12,
                bold: true,
                fillColor: '#CCCCCC',
            },
            lampiran: { // Gaya untuk lampiran
                fontSize: 12,
                italic: true,
                alignment: 'left',
                margin: [0, 0, 0, 5] // Atur margin bawah
            },
            tanggal: { // Gaya untuk tanggal
                fontSize: 12,
                italic: true,
                alignment: 'left',
                margin: [0, 0, 0, 10] // Atur margin bawah
            }
        },
    };

    // Memasukkan data dari parameter ke dalam dokumen PDF
    data.forEach(function (row) {
        docDefinition.content[5].table.body.push([ // Indeks 5 digunakan karena ada dua elemen teks baru sebelumnya
            row.no,
            row.nama_barang,
            row.jumlah_keluar,
            row.bulan_keluar,
            row.tujuan
        ]);
    });

    // Buat dan unduh dokumen PDF
    pdfMake.createPdf(docDefinition).download(title + '.pdf');
}
    // Cetak Laporan Semua (PDF)
    document.getElementById("cetakPDFAll").addEventListener("click", function () {
        // Ambil data laporan semua dari tabel
        var dataLaporanAll = [];
        var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; rows && i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            dataLaporanAll.push({
                no: cells[0].textContent,
                nama_barang: cells[1].textContent,
                jumlah_keluar: cells[2].textContent,
                bulan_keluar: cells[3].textContent,
                tujuan: cells[4].textContent
            });
        }

        // Panggil fungsi generatePDF dengan data laporan
        generatePDF(dataLaporanAll, 'Laporan Barang Keluar');
    });
</script>