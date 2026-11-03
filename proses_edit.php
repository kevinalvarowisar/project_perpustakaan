<?php
require_once "config/auth.php";
?>
<?php
include "koneksi.php";

$id = $_POST['id'];
$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$penulis = $_POST['penulis'];
$tahun = $_POST['tahun_terbit'];
$stok = $_POST['stok'];

$query = mysqli_prepare(
    $koneksi,
    "SELECT sampul FROM buku WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$dataLama = mysqli_fetch_assoc($result);

if (!$dataLama) {
    die("Buku tidak ditemukan.");
}

$sampulLama = $dataLama['sampul'];
$sampulBaru = $sampulLama;

// Jika pengguna mengupload gambar baru
if (!empty($_FILES['sampul']['name'])) {

    $tmpName = $_FILES['sampul']['tmp_name'];
    $ukuran = $_FILES['sampul']['size'];

    if ($ukuran > 2 * 1024 * 1024) {
        die("Ukuran gambar maksimal 2MB.");
    }

    $info = getimagesize($tmpName);

    if ($info === false) {
        die("File bukan gambar.");
    }

    if ($info['mime'] == 'image/jpeg') {
        $ekstensi = 'jpg';
    } elseif ($info['mime'] == 'image/png') {
        $ekstensi = 'png';
    } else {
        die("Hanya JPG dan PNG yang diperbolehkan.");
    }

    $sampulBaru = uniqid() . "." . $ekstensi;

    if (!move_uploaded_file(
        $tmpName,
        "uploads/" . $sampulBaru
    )) {
        die("Upload gambar gagal.");
    }
}

// Update database
$query = mysqli_prepare(
    $koneksi,
    "UPDATE buku SET
    judul = ?,
    kategori = ?,
    penulis = ?,
    tahun_terbit = ?,
    stok = ?,
    sampul = ?
    WHERE id = ?"
);

mysqli_stmt_bind_param(
    $query,
    "ssssisi",
    $judul,
    $kategori,
    $penulis,
    $tahun,
    $stok,
    $sampulBaru,
    $id
);

if (mysqli_stmt_execute($query)) {

    if ($sampulBaru != $sampulLama && !empty($sampulLama)) {
        $fileLama = "uploads/" . $sampulLama;

        if (file_exists($fileLama)) {
            unlink($fileLama);
        }
    }

    header("Location: dashboard.php");
    exit;

} else {
    if ($sampulBaru != $sampulLama) {
        unlink("uploads/" . $sampulBaru);
    }

    echo "Gagal memperbarui buku.";
}
?>