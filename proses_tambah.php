<?php
require_once "config/auth.php";
?>
<?php
include "koneksi.php";

$judul = $_POST['judul'];
$kategori = $_POST['kategori'];
$penulis = $_POST['penulis'];
$tahun = $_POST['tahun_terbit'];
$stok = $_POST['stok'];

// Mengambil informasi gambar
$namaFile = $_FILES['sampul']['name'];
$ukuranFile = $_FILES['sampul']['size'];
$tmpName = $_FILES['sampul']['tmp_name'];

// Memeriksa ukuran maksimal 2MB
if ($ukuranFile > 2 * 1024 * 1024) {
    die("Ukuran gambar maksimal 2MB.");
}

// Memeriksa jenis gambar
$info = getimagesize($tmpName);

if ($info === false) {
    die("File harus berupa gambar.");
}

$tipe = $info['mime'];

if ($tipe == 'image/jpeg') {
    $ekstensi = 'jpg';
} elseif ($tipe == 'image/png') {
    $ekstensi = 'png';
} else {
    die("Hanya JPG dan PNG yang diperbolehkan.");
}

// Membuat nama file unik
$namaBaru = uniqid() . "." . $ekstensi;

$tujuan = "uploads/" . $namaBaru;

// Memindahkan gambar ke folder uploads
if (move_uploaded_file($tmpName, $tujuan)) {

    $query = mysqli_prepare(
        $koneksi,
        "INSERT INTO buku
        (judul, kategori, penulis, tahun_terbit, stok, sampul)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query,
        "ssssis",
        $judul,
        $kategori,
        $penulis,
        $tahun,
        $stok,
        $namaBaru
    );

    if (mysqli_stmt_execute($query)) {
        header("Location: dashboard.php");
        exit;
    } else {
        unlink($tujuan);
        echo "Gagal menyimpan data buku.";
    }

} else {
    echo "Gagal mengupload gambar.";
}
?>