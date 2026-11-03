<?php
require_once "config/auth.php";
require_once "koneksi.php";

// Pastikan ID buku tersedia dan valid.
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("ID buku tidak valid.");
}

// Ambil data buku berdasarkan ID.
$query = mysqli_prepare($koneksi, "SELECT * FROM buku WHERE id = ?");
if (!$query) {
    die("Terjadi kesalahan pada database.");
}

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$buku = mysqli_fetch_assoc($result);

mysqli_stmt_close($query);

if (!$buku) {
    die("Buku tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku | Mini Digital Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container py-5">
    <div class="form-card p-4 mx-auto" style="max-width: 650px;">

        <a href="dashboard.php" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>

        <h3 class="fw-bold mt-4">Edit Buku</h3>
        <p class="subtitle mb-4">
            Perbarui informasi koleksi buku di perpustakaan.
        </p>

        <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int) $buku['id'] ?>">

            <div class="mb-3">
                <label class="form-label fw-semibold">Sampul Buku Saat Ini</label>
                <div class="mt-2">
                    <?php if (!empty($buku['sampul'])): ?>
                        <img
                            src="uploads/<?= htmlspecialchars($buku['sampul'], ENT_QUOTES, 'UTF-8') ?>"
                            alt="Sampul <?= htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8') ?>"
                            style="width: 120px; height: 160px; object-fit: cover; border-radius: 10px;"
                        >
                    <?php else: ?>
                        <div class="text-secondary small">
                            <i class="bi bi-image"></i> Belum ada sampul buku.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="sampul" class="form-label fw-semibold">
                    Ganti Sampul Buku <span class="text-secondary fw-normal">(Opsional)</span>
                </label>
                <input
                    type="file"
                    class="form-control"
                    id="sampul"
                    name="sampul"
                    accept=".jpg,.jpeg,.png"
                >
                <div class="form-text">Format JPG, JPEG, atau PNG. Maksimal 2 MB.</div>
            </div>

            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Buku</label>
                <input
                    type="text"
                    class="form-control"
                    id="judul"
                    name="judul"
                    value="<?= htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label fw-semibold">Kategori</label>
                <input
                    type="text"
                    class="form-control"
                    id="kategori"
                    name="kategori"
                    value="<?= htmlspecialchars($buku['kategori'], ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="penulis" class="form-label fw-semibold">Penulis</label>
                <input
                    type="text"
                    class="form-control"
                    id="penulis"
                    name="penulis"
                    value="<?= htmlspecialchars($buku['penulis'], ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="tahun_terbit" class="form-label fw-semibold">Tahun Terbit</label>
                <input
                    type="number"
                    class="form-control"
                    id="tahun_terbit"
                    name="tahun_terbit"
                    value="<?= htmlspecialchars((string) $buku['tahun_terbit'], ENT_QUOTES, 'UTF-8') ?>"
                    min="1901"
                    max="<?= date('Y') ?>"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="stok" class="form-label fw-semibold">Stok</label>
                <input
                    type="number"
                    class="form-control"
                    id="stok"
                    name="stok"
                    value="<?= (int) $buku['stok'] ?>"
                    min="0"
                    required
                >
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="dashboard.php" class="btn btn-light">
                    Batal
                </a>
            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
