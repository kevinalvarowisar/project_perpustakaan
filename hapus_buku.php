<?php
require_once "config/auth.php";
?>
<?php
include "koneksi.php";

$id = $_GET['id'];

$query = mysqli_prepare(
    $koneksi,
    "SELECT sampul FROM buku WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$buku = mysqli_fetch_assoc($result);

if (!$buku) {
    die("Buku tidak ditemukan.");
}

$query = mysqli_prepare(
    $koneksi,
    "DELETE FROM buku WHERE id = ?"
);

mysqli_stmt_bind_param($query, "i", $id);

if (mysqli_stmt_execute($query)) {

    if (!empty($buku['sampul'])) {
        $file = "uploads/" . $buku['sampul'];

        if (file_exists($file)) {
            unlink($file);
        }
    }

    header("Location: dashboard.php");
    exit;

} else {
    echo "Gagal menghapus buku.";
}
?>