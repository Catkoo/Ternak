<?php
$orderBy = 'tanggal_keluar DESC'; // Default sorting (urutkan berdasarkan tanggal keluar)

if (isset($_POST['filter'])) {
    // Ambil bulan awal dari form
    $filterStart = $_POST['start'];
    $orderBy = 'tanggal_keluar ASC'; // Ubah pengurutan menjadi urutkan berdasarkan tanggal keluar secara menaik
}
?>

<form method="post" class="form-report" style="">
    <input type="month" class="form-control" name="start" required>
    <button class="btn btn-primary btn-sm" name="filter" type="submit">Filter</button>
    <button id="cetakPDFFiltered" class="btn btn-primary btn-sm">Cetak Laporan Filtered (PDF)</button>
    <button id="cetakPDFAll" class="btn btn-primary btn-sm">Cetak Laporan Semua (PDF)</button>
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
                    if (isset($filterStart) && !empty($filterStart)) {
                        $filterCondition = "AND DATE_FORMAT(tanggal_keluar, '%Y-%m') = '$filterStart'";
                    }

                    $sql = $koneksi->query("SELECT * FROM barang_keluar as bk JOIN barang as b ON bk.barang_id=b.id_barang LEFT JOIN satuan as st ON st.id_satuan=b.satuan_id JOIN history as h ON h.bmk_id=bk.id_bk WHERE role='BK' $filterCondition group by id_bk ORDER BY tanggal_keluar DESC");
                    $dataLaporanFiltered = array();

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
        var docDefinition = {
            content: [
                {
                    text: title,
                    style: 'header'
                },
                {
                    text: 'Ternak Ayam Gesek KM.19',
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
                    table: {
                        headerRows: 1,
                        widths: [30, '*', '*', 40, 70],
                        body: [
                            [{ text: 'No', style: 'tableHeader' }, { text: 'Nama Barang', style: 'tableHeader' }, { text: 'Jumlah', style: 'tableHeader' }, { text: 'Bulan Keluar', style: 'tableHeader' }, { text: 'Tujuan', style: 'tableHeader' }],
                            // Data laporan akan dimasukkan di sini
                        ]
                    }
                }
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 20] // Atur margin bawah
                },
                subheader: {
                    fontSize: 12,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 15] // Atur margin bawah
                },
                tableHeader: {
                    fontSize: 12,
                    bold: true,
                    fillColor: '#CCCCCC', // Warna latar belakang
                }
            },
         footer: function (currentPage, pageCount) {
            return {
                text: 'Tanggal Cetak: ' + new Date().toLocaleDateString('id-ID'),
                style: 'footer', // Menentukan gaya teks footer
                alignment: 'right', // Mencetak tanggal di sudut kanan bawah
                margin: [0, 0, 40, 20] // Atur margin bawah dan kanan
            };
        }
    };

        // Memasukkan data dari parameter ke dalam dokumen PDF
        data.forEach(function (row) {
            docDefinition.content[3].table.body.push([
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

    // Cetak Laporan Filtered (PDF)
    document.getElementById("cetakPDFFiltered").addEventListener("click", function () {
        // Ambil bulan yang diisi dalam input
        var selectedMonth = document.querySelector("input[type='month']").value;

        // Periksa apakah bulan telah diisi
        if (selectedMonth) {
            // Ambil data laporan yang ingin dicetak dari tabel
            var dataLaporanFiltered = [];
            var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
            var rows = table.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                dataLaporanFiltered.push({
                    no: cells[0].textContent,
                    nama_barang: cells[1].textContent,
                    jumlah_keluar: cells[2].textContent,
                    bulan_keluar: cells[3].textContent,
                    tujuan: cells[4].textContent
                });
            }

            // Panggil fungsi generatePDF dengan data laporan
            generatePDF(dataLaporanFiltered, 'Laporan Barang Keluar');
        } else {
            // Tampilkan pesan kesalahan jika bulan belum diisi
            alert('Silakan isi bulan terlebih dahulu sebelum mencetak laporan berdasarkan filter.');
        }
    });

    // Cetak Laporan Semua (PDF)
    document.getElementById("cetakPDFAll").addEventListener("click", function () {
        // Ambil data laporan semua dari tabel
        var dataLaporanAll = [];
        var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
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
