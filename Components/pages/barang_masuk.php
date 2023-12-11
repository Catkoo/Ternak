<?php
if (isset($_POST['delete'])) {
    if (deleteBarangMsk($_POST) > 0) {
        echo "<script>alert('Data Berhasil Dihapus!');</script>";
        echo "<meta http-equiv='refresh' content='0;url=?page=barang-masuk'>";
    }
}

$filterStart = '';

if (isset($_POST['filter'])) {
    // Ambil bulan awal dari form
    $filterStart = $_POST['start'];
}
?>


<a href="?page=add_bm" class="btn btn-primary btn-sm mb-3">+ Tambah Data</a>

<form method="post" class="form-report" style="">
    <input type="month" class="form-control" name="start" required>
    <button class="btn btn-primary btn-sm" name="filter" type="submit">Filter</button>
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
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th>Bulan Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sqlFilterCondition = '';
                    $existing_ids = array();

                    if (!empty($filterStart)) {
                        // Jika filter bulan diisi, tambahkan kondisi ke kueri SQL
                        $sqlFilterCondition = "AND DATE_FORMAT(tanggal_masuk, '%Y-%m') = '$filterStart'";
                    }

                    $sql = $koneksi->query("SELECT *, DATE_FORMAT(tanggal_masuk, '%M %Y') AS bulan_masuk FROM barang_masuk as bm JOIN barang as b ON bm.barang_id=b.id_barang JOIN supplier as sp ON bm.supplier_id=sp.id_sup JOIN history as h ON h.bmk_id=bm.id_bm WHERE role='BM' $sqlFilterCondition ORDER BY tanggal_masuk DESC");

                    while ($data = $sql->fetch_assoc()) {
                        // Pengecekan apakah ID sudah ditampilkan, jika iya, lewati
                        if (in_array($data['id_bm'], $existing_ids)) {
                            continue;
                        }

                        $existing_ids[] = $data['id_bm']; // Menambahkan ID ke dalam array
                    ?>
                        <tr>
                            <td><?= $no; ?></td>
                            <td><?= $data['nama_barang']; ?></td>
                            <td><?= $data['nama_sup']; ?></td>
                            <td><span class="badge text-bg-success">+ <?= $data['jumlah_masuk']; ?></span></td>
                            <td><?= date('d/m/Y', strtotime($data['tanggal_masuk'])); ?></td>
                            <td>
                                <a href="?page=detail_bm&id=<?= $data['id_bm']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-info"></i></a>
                                <form method="post" class="d-inline">
                                    <input type="hidden" value="<?= $data['id_bm']; ?>" name="id">
                                    <input type="hidden" value="<?= $data['id_barang']; ?>" name="id_brg">
                                    <input type="hidden" value="<?= $data['id']; ?>" name="id_h">
                                    <input type="hidden" value="<?= $data['jumlah_masuk']; ?>" name="jml">
                                    <button class="btn btn-danger btn-sm" name="delete"><i class="fa-solid fa-trash"></i></button>
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
        

<script>
    // Fungsi untuk membuat laporan PDF
    function generatePDF(data) {
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
                    text: 'Lampiran : Laporan Barang Masuk',
                    style: 'attachment'
                },
                {
                    text: `Tanggal    : ${currentDate}\n\n`, // Added automatic date
                    style: 'date'
                },
                {
                    table: {
                        headerRows: 1,
                        widths: [30, '*', '*', 40, 70],
                        body: [
                            [{ text: 'No', style: 'tableHeader' }, { text: 'Nama Barang', style: 'tableHeader' }, { text: 'Supplier', style: 'tableHeader' }, { text: 'Jumlah', style: 'tableHeader' }, { text: 'Bulan Masuk', style: 'tableHeader' }],
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
                            alignment: 'left', // Spasi kosong untuk menjaga posisi "Mengetahui" di sebelah kiri
                        },
                        {
                            text: `Toapaya Selatan, ${currentDate}\nMengetahui,\n\n\n\n\n\n\n\n(     Herman Kurniawan     ) `,
                            alignment: 'right', // Mengubah posisi "Mengetahui" dan "Garis Pendek Pimpinan" ke kanan
                            margin: [0, 0, 40, 0] // Atur margin kanan
                        }
                    ]
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
                },
                attachment: {
                    fontSize: 12,
                    italic: true,
                    alignment: 'left',
                    margin: [0, 20, 0, 10] // Atur margin atas
                },
                date: {
                    fontSize: 12,
                    alignment: 'left',
                    margin: [0, 5, 0, 0] // Atur margin atas
                }
            }
        };

        // Memasukkan data dari parameter ke dalam dokumen PDF
        data.forEach(function (row) {
            docDefinition.content[5].table.body.push([
                row.no,
                row.nama_barang,
                row.nama_sup,
                row.jumlah_masuk,
                row.bulan_masuk
            ]);
        });

        // Buat dan unduh dokumen PDF
        pdfMake.createPdf(docDefinition).download('Laporan Barang Masuk.pdf');
    }

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
                nama_sup: cells[2].textContent,
                jumlah_masuk: cells[3].textContent,
                bulan_masuk: cells[4].textContent
            });
        }

        // Panggil fungsi generatePDF dengan data laporan
        generatePDF(dataLaporanAll);
    });
</script>
        </div>
    </div>
</div>
