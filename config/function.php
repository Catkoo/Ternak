<?php

// QUERY YANG DITAMPILKAN DI HALAMAN DASHBOARD.PHP
$sqlBrg = $koneksi->query("SELECT * FROM barang");
$resultBrg = $sqlBrg->num_rows;

$sqlBk = $koneksi->query("SELECT * FROM barang_keluar");
$resultBk = $sqlBk->num_rows;

$sqlBm = $koneksi->query("SELECT * FROM barang_masuk");
$resultBm = $sqlBm->num_rows;

$sqlSup = $koneksi->query("SELECT * FROM supplier");
$resultSup = $sqlSup->num_rows;

// MENGHAPUS DATA HISTORY KETIKA DATA SUDAH LEBIH DARI 1 HARI
$koneksi->query("DELETE FROM history WHERE DATEDIFF(CURDATE(), tgl) > 1");

// FUNGSI REGISTER
// function registerFunc($data){
//     global $koneksi;

//     $name = $data['name'];
//     $username = $data['username'];
//     $pwd = md5($data['password']);
//     $rpwd = md5($data['rpassword']);

//     $qry = $koneksi->query("SELECT * FROM users");
//     $res = $qry->fetch_assoc();

//     // MENGECEK APAKAH USERNAME SUDAH ADA DI DALAM DATABASE
//     // JIKA SUDAH ADA MAKA AKAN MENAMPILKAN ALERT ERROR
//     // MENGECEK APAKAH PASSWORD 1 DAN PASSWORD 2 MATCH
//     // JIKA TIDAK MATCH MAKA AKAN MENAMPILKAN PESAN ERROR
//     // JIKA KONDISI DIATAS TERPENUHI MAKA DATA AKAN DIKIRIM KE DALAM DATABASE.
//     if($username == $res['username']){
//         echo "<script>alert('Opps.. Username sudah digunakan');</script>";
//     }elseif($pwd != $rpwd){
//         echo "<script>alert('Password tidak sesuai!');</script>";
//     }else{
//         $koneksi->query("INSERT INTO users(id, nama, username, password, created_at)VALUE(NULL, '$name', '$username', '$pwd', NOW())");
//     }

//     return mysqli_affected_rows($koneksi);
// }

// LOGIN FUNCTION
function loginFunc($data) {
    global $koneksi;

    $username = $data['username'];
    $password = md5($data['password']);

    if (strlen($data['password']) < 8) {
        echo "<script>alert('Password harus minimal 8 karakter!');window.location.href='login.php';</script>";
        return;
    }

    $stmt = $koneksi->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $password, $role);
        $stmt->fetch();

        $_SESSION['login'] = [
            'id' => $id,
            'username' => $username,
            'role' => $role
        ];

        if ($role == 'admin') {
            header('location: index.php'); // Ganti dengan halaman admin
        } elseif ($role == 'pimpinan') {
            header('location: index_pemimpin.php'); // Ganti dengan halaman pimpinan
        } else {
            header('location: login.php'); // Ganti dengan halaman default jika role bukan admin atau pimpinan
        }
    } else {
        echo "<script>alert('Username Atau Password Salah');window.location.href='login.php';</script>";
    }

    return mysqli_affected_rows($koneksi);
}





//Reset password
if(isset($_POST['changepwd'])){
    $old = md5($_POST['oldpassword']);
    $new = md5($_POST['newpassword']);
    $id = $_SESSION['login']['id'];

    // Check if the new password is empty
    if(empty($_POST['newpassword'])){
        echo "<script>alert('Password Baru tidak boleh kosong');
        window.location.href='?page='</script>";
    } else {
        // QUERY MENGAMBIL ID USER LOGIN
        $qry = $koneksi->query("SELECT * FROM users WHERE id='$id'");
        $res = $qry->fetch_assoc();

        // MENGECEK PASSWORD LAMA YANG DIINPUT
        // APAKAH COCOK DENGAN YANG TERDAPAT DALAM DATABASE
        // JIKA TIDAK MAKA AKAN MENAMPILKAN PESAN ERROR
        // JIKA SESUAI PASSWORD AKAN DI UPDATE DENGAN PASSWORD BARU
        if($old != $res['password']){
            echo "<script>alert('Password Tidak Sesuai');
            window.location.href='?page='</script>";
        } else {
            $koneksi->query("UPDATE users SET password='$new' WHERE id='$id'");
            echo "<script>alert('Password Berhasil Diubah');
            window.location.href='login.php';</script>";
        }
    }
}


// FUNCTION ADD BARANG
function tambahBarang($data){
    global $koneksi;

    $id = $data['id'];
    $nama = $data['nama_barang'];
    // $stok = $data['stok'];
    $satuan = $data['satuan'];

    $fileName = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    $eks = explode('.', $fileName);
    $eks = strtolower(end($eks));
    $newName = uniqid();
    $newName .= '.';
    $newName .= $eks;
    $ekstensiVld = ['png', 'jpg', 'jpeg'];

    // MENGECEK APAKAH EXTENSI GAMBAR SESUAI DENGAN YANG DITENTUKAN
    if(!in_array($eks, $ekstensiVld)){
        echo "<script>alert('Ekstensi File Tidak Valid!');</script>";
    }

    // UPLOAD FILE KE DALAM FOLDER LOCAL 'ASSETS/IMG/'
    // LALU MENGIRIM DATA KE DALAM DATABASE
    move_uploaded_file($tmp, 'assets/img/'.$newName);
    $koneksi->query("INSERT INTO barang(id_barang, nama_barang, satuan_id, foto_barang, created_at, update_at)VALUES('$id', '$nama', '$satuan', '$newName', NOW(), NOW())");
    return mysqli_affected_rows($koneksi);
}
// FUNCTION EDIT BARANG
function editBarang($data){
    global $koneksi;

    $id = $data['id'];
    $nama = $data['nama_barang'];
    $stok = $data['stok'];
    $oldImg = $data['imgLama'];
    $satuan = $data['satuan'];

    $newImg = $_FILES['newImg']['name'];
    $tmp = $_FILES['newImg']['tmp_name'];

    $eks = explode('.', $newImg);
    $eks = strtolower(end($eks));
    $newName = uniqid();
    $newName .= '.';
    $newName .= $eks;
    $ekstensiVld = ['png', 'jpg', 'jpeg'];

    // MENGECEK APAKAH DATA GAMBAR ADA DI DALAM FOLDER LOCAL
    if(!empty($tmp)){
        // JIKA ADA MAKA GAMBAR BARU AKAN DI UPLOAD KEDALAM FOLDER LOCAL
        // LALU GAMBAR LAMA AKAN DIHAPUS
        move_uploaded_file($tmp, 'assets/img/'.$newName);
        unlink('assets/img/'.$oldImg);

        $koneksi->query("UPDATE barang SET 
            nama_barang='$nama',
            satuan_id = '$satuan',
            foto_barang = '$newName',
            update_at = NOW()
        WHERE id_barang='$id'");
    }else{
        $koneksi->query("UPDATE barang SET 
            nama_barang='$nama',
            satuan_id = '$satuan',
            update_at = NOW()
        WHERE id_barang='$id'");
    }

    return mysqli_affected_rows($koneksi);
}
// FUNCTION DELETE BARANG
function deleteBarang($data){
    global $koneksi;
    $id = $data['id'];
    $foto = $data['foto'];
    unlink('assets/img/'.$foto);

    $koneksi->query("DELETE FROM barang WHERE id_barang='$id'");
    $koneksi->query("DELETE FROM barang_keluar WHERE barang_id='$id'");
    $koneksi->query("DELETE FROM barang_masuk WHERE barang_id='$id'");
    $koneksi->query("DELETE FROM history WHERE barang_id='$id'");
    return mysqli_affected_rows($koneksi);
}

// FUNCTION TAMBAH, DELETE, EDIT DATA SATUAN
function tambahSatuan($data){
    global $koneksi;

    $id = $data['id'];
    $satuan = $data['nama_satuan'];

    // Validasi jika nama satuan kosong
    if (empty($satuan)) {
        echo "<script>alert('Nama Satuan tidak boleh kosong!');</script>";
        return false; // Keluar dari fungsi jika nama satuan kosong
    }

    $koneksi->query("INSERT INTO satuan(id_satuan, nama_satuan, update_at) VALUES('$id', '$satuan', NOW())");
    return mysqli_affected_rows($koneksi);
}
function deleteSatuan($data){
    global $koneksi;
    $id = $data['id'];

    $koneksi->query("DELETE FROM satuan WHERE id_satuan='$id'");
    return mysqli_affected_rows($koneksi);
}
function editSatuan($data){
    global $koneksi;

    $id = $data['id'];
    $name = $data['nama_satuan'];

    // Validasi jika nama satuan kosong
    if (empty($name)) {
        echo "<script>alert('Nama Satuan tidak boleh kosong!');</script>";
        return false; // Keluar dari fungsi jika nama satuan kosong
    }

    $koneksi->query("UPDATE satuan SET nama_satuan='$name', update_at=NOW() WHERE id_satuan='$id'");
    return mysqli_affected_rows($koneksi);
}

// FUNCTION TAMBAH, EDIT, DELETE DATA SUPPLIER
function tambahSupplier($data){
    global $koneksi;

    $id = $data['idsup'];
    $name = $data['supplier'];
    $no = $data['no'];
    $alamat = $data['alamat'];

    // Validasi jika salah satu data kosong
    if (empty($id) || empty($name) || empty($no) || empty($alamat)) {
        echo "<script>alert('Semua data harus diisi!');</script>";
        return false; // Keluar dari fungsi jika salah satu data kosong
    }

    $koneksi->query("INSERT INTO supplier(id_sup, nama_sup, telepon_sup, alamat_sup, latest_update)VALUES('$id', '$name','$no', '$alamat', NOW())");
    return mysqli_affected_rows($koneksi);
}

function editSupplier($data){
    global $koneksi;

    $id = $data['id'];
    $name = $data['supplier'];
    $no = $data['no'];
    $alamat = $data['alamat'];

    // Validasi jika salah satu data kosong
    if (empty($name) || empty($no) || empty($alamat)) {
        echo "<script>alert('Semua data harus diisi!');</script>";
        return false; // Keluar dari fungsi jika salah satu data kosong
    }

    $koneksi->query("UPDATE supplier SET nama_sup='$name', telepon_sup='$no', alamat_sup='$alamat', latest_update=NOW() WHERE id_sup = '$id'");
    return mysqli_affected_rows($koneksi);
}

function deleteSupplier($data){
    global $koneksi;
    $id = $data['id'];

    $koneksi->query("DELETE FROM supplier WHERE id_sup='$id'");
    return mysqli_affected_rows($koneksi);
}


// FUNCTION TAMBAH, DELETE DATA BARANG MASUK
function tambahBarangMasuk($data){
    global $koneksi;

    $id = $data['id'];
    $idBRG = $data['idBRG'];
    $sup = $data['supplier'];
    $jml = $data['jml'];

    $koneksi->query("INSERT INTO barang_masuk(id_bm, barang_id, supplier_id, jumlah_masuk, tanggal_masuk)VALUES('$id', '$idBRG', '$sup', '$jml', NOW())");

    $koneksi->insert_id;
    $koneksi->query("UPDATE barang set stok=stok+$jml WHERE id_barang='$idBRG'");
    $koneksi->query("INSERT INTO history(id, barang_id, bmk_id, role, jumlah, tgl)VALUES(NULL, '$idBRG', '$id', 'BM', '$jml', NOW())");

    return mysqli_affected_rows($koneksi);
}
function deleteBarangMsk($data){
    global $koneksi;

    $id = $data['id'];
    $id_brg = $data['id_brg'];
    $id_h = $data['id_h'];
    $stok = $data['jml'];

    $koneksi->query("DELETE FROM barang_masuk WHERE id_bm='$id'");
    $koneksi->query("DELETE FROM history WHERE id='$id_h'");
    $koneksi->query("UPDATE barang SET stok=stok-$stok WHERE id_barang='$id_brg'");

    return mysqli_affected_rows($koneksi);
}

// FUNCTION TAMBAH, DELETE BARANG KELUAR
function tambahBarangKeluar($data){
    global $koneksi;

    $id = $data['id'];
    $idBRG = $data['idBRG'];
    $tujuan = $data['tujuan'];
    $jml = $data['jml'];

    $sql = $koneksi->query("SELECT * FROM barang WHERE id_barang='$idBRG'");
    $res = $sql->fetch_assoc();

    // Check if the stock is 0
    if ($res['stok'] == 0) {
        echo '<script>alert("Stok barang kosong. Data barang keluar tidak dapat ditambahkan.");</script>';
        return false;
    }

    // Check if the requested quantity is greater than the available stock
    if ($jml > $res['stok']) {
        echo '<script>alert("Jumlah barang yang akan dikeluarkan melebihi stok yang ada. Silakan cek kembali.");</script>';
        return false;
    } else {
        $koneksi->query("INSERT INTO barang_keluar(id_bk, barang_id, tanggal_keluar, tujuan, jumlah_keluar) VALUES('$id', '$idBRG', NOW(), '$tujuan', '$jml')");
        $koneksi->insert_id;
        $koneksi->query("UPDATE barang SET stok=stok-$jml WHERE id_barang='$idBRG'");
        $koneksi->query("INSERT INTO history(id, barang_id, bmk_id, role, jumlah, tgl) VALUES(NULL, '$idBRG', '$id', 'BK', '$jml', NOW())");
    }

    return true;
}

function deleteBarangKLR($data){
    global $koneksi;

    $id = $data['id'];
    $id_brg = $data['id_brg'];
    $id_h = $data['id_h'];
    $stok = $data['jml'];

    $koneksi->query("DELETE FROM barang_keluar WHERE id_bk='$id'");
    $koneksi->query("DELETE FROM history WHERE id='$id_h'");
    $koneksi->query("UPDATE barang SET stok=stok+$stok WHERE id_barang='$id_brg'");

    return mysqli_affected_rows($koneksi);
}

//User
function addUser($nama, $username, $password, $rpassword, $role, $email) {
    global $koneksi;

    // Mengecek apakah username sudah ada di dalam database
    $queryUsername = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
    $queryUsername->bind_param("s", $username);
    $queryUsername->execute();
    $queryUsername->store_result();

    // Mengecek apakah email sudah ada di dalam database
    $queryEmail = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
    $queryEmail->bind_param("s", $email);
    $queryEmail->execute();
    $queryEmail->store_result();

    if ($queryUsername->num_rows > 0) {
        return -1; // Username sudah digunakan
    }

    if ($queryEmail->num_rows > 0) {
        return -4; // Email sudah digunakan
    }

    // Mengecek apakah password 1 dan password 2 match
    if ($password !== $rpassword) {
        return -2; // Password tidak sesuai
    }

    // Jika kondisi di atas terpenuhi, data akan dimasukkan ke dalam database
    $queryInsert = $koneksi->prepare("INSERT INTO users (nama, username, password, role, email, latest_update) VALUES (?, ?, ?, ?, ?, NOW())");
    $queryInsert->bind_param("sssss", $nama, $username, $password, $role, $email);
    $queryInsert->execute();

    if ($queryInsert->affected_rows > 0) {
        return 1; // User berhasil ditambahkan
    } else {
        return -3; // Error saat menambahkan user
    }
}


function editUser($id, $nama, $username, $password, $rpassword) {
    global $koneksi;

    // Mengecek apakah username sudah ada di dalam database (kecuali pengguna saat ini)
    $queryUsername = $koneksi->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $queryUsername->bind_param("si", $username, $id);
    $queryUsername->execute();
    $queryUsername->store_result();

    if ($queryUsername->num_rows > 0) {
        return -1; // Username sudah digunakan
    }

    // Jika password tidak kosong, maka lakukan pemeriksaan dan update password
    if (!empty($password)) {
        // Mengecek apakah password dan konfirmasi ulang password cocok
        if ($password !== $rpassword) {
            return -2; // Password tidak sesuai
        }

        // Jika kondisi di atas terpenuhi, data akan diupdate di dalam database termasuk password
        $queryUpdate = $koneksi->prepare("UPDATE users SET nama = ?, username = ?, password = ? WHERE id = ?");
        $queryUpdate->bind_param("sssi", $nama, $username, $password, $id);
    } else {
        // Jika password kosong, hanya update nama dan username
        $queryUpdate = $koneksi->prepare("UPDATE users SET nama = ?, username = ? WHERE id = ?");
        $queryUpdate->bind_param("ssi", $nama, $username, $id);
    }

    $queryUpdate->execute();

    if ($queryUpdate->affected_rows > 0) {
        return 1; // User berhasil diubah
    } else {
        return -3; // Error saat mengubah user
    }
}



function editUserWithoutPassword($id, $nama, $username) {
    global $koneksi;

    // Mengecek apakah username sudah ada di dalam database (kecuali pengguna saat ini)
    $query = $koneksi->prepare("SELECT * FROM users WHERE username = ? AND id != ?");
    $query->bind_param("si", $username, $id);
    $query->execute();
    $query->store_result();

    if ($query->num_rows > 0) {
        return -1; // Username sudah digunakan
    }

    // Jika kondisi di atas terpenuhi, data akan diupdate di dalam database tanpa mengubah password
    $query = $koneksi->prepare("UPDATE users SET nama = ?, username = ? WHERE id = ?");
    $query->bind_param("ssi", $nama, $username, $id);
    $query->execute();

    if ($query->affected_rows > 0) {
        return 1; // User berhasil diubah
    } else {
        return -3; // Error saat mengubah user
    }
}
///------------------------------------------------------------------------------------



function deleteUser($id) {
    global $koneksi;

    // Menghapus user berdasarkan ID
    $query = $koneksi->prepare("DELETE FROM users WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();

    if ($query->affected_rows > 0) {
        return 1; // User berhasil dihapus
    } else {
        return -2; // Error saat menghapus user
    }
}

////reset
function generateToken($userId) {
    global $koneksi;

    // Batalkan token lama yang belum digunakan
    $resetRequestTime = date('Y-m-d H:i:s');
    $cancelQuery = $koneksi->prepare("UPDATE users SET reset_request_time = ? WHERE id = ? AND reset_request_time IS NULL");
    $cancelQuery->bind_param("si", $resetRequestTime, $userId);
    $cancelQuery->execute();

    // Generate token baru
    $token = bin2hex(random_bytes(32));

    // Tentukan waktu kedaluwarsa (30 menit dari sekarang)
    $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // Simpan waktu reset_request_time (saat permintaan reset terakhir kali)
    $resetRequestTime = null;

    // Update database dengan token baru, waktu kedaluwarsa, dan waktu reset_request_time
    $query = $koneksi->prepare("UPDATE users SET reset_token = ?, token_expiration = ?, reset_request_time = ? WHERE id = ?");
    $query->bind_param("sssi", $token, $expiration, $resetRequestTime, $userId);
    $query->execute();

    return $token;
}

function validateToken($token) {
    global $koneksi;

    $currentDateTime = date('Y-m-d H:i:s');
    $query = $koneksi->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiration > ?");
    $query->bind_param("ss", $token, $currentDateTime);
    $query->execute();
    $query->store_result();

    return $query->num_rows > 0;
}

function resetPassword($token, $password) {
    global $koneksi;

    // Validasi token
    if (validateToken($token)) {
        $hashedPassword = md5($password);

        // Dapatkan ID pengguna berdasarkan token
        $query = $koneksi->prepare("SELECT id, reset_request_time FROM users WHERE reset_token = ?");
        $query->bind_param("s", $token);
        $query->execute();
        $query->store_result();

if ($query->num_rows > 0) {
    $query->bind_result($userId, $resetRequestTime);
    $query->fetch();

    // Reset password, hapus token, dan tandai token sebagai digunakan
    $hashedPassword = md5($password);
    $updatePasswordQuery = $koneksi->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiration = NULL, reset_request_time = NOW() WHERE id = ?");
    $updatePasswordQuery->bind_param("si", $hashedPassword, $userId);
    $updatePasswordQuery->execute();

    // Tandai token sebagai digunakan
    $markTokenUsedQuery = $koneksi->prepare("UPDATE users SET reset_request_time = NOW() WHERE reset_token = ?");
    $markTokenUsedQuery->bind_param("s", $token);
    $markTokenUsedQuery->execute();

    return true;
} else {
    // Log bahwa tidak ada pengguna dengan token yang diberikan ditemukan
    error_log("Token tidak ditemukan pada resetPassword");
}
    } else {
        // Log bahwa validasi token gagal
        error_log("Validasi token gagal pada resetPassword");
    }

    return false;
}