
<?php
require_once "config/auth.php";
include "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");

$totalBuku = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku")
)['total'];

$totalTersedia = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku WHERE stok > 0")
)['total'];

$totalHabis = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM buku WHERE stok = 0")
)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Library - Dashboard</title>

    <!-- CSS Framework Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="brand">
        <i class="bi bi-book-half"></i> Library
    </div>

    <div class="nav-label">MENU UTAMA</div>

    <a href="dashboard.php" class="nav-link active">
        <i class="bi bi-grid"></i> Dashboard
    </a>

    <a href="tambah_buku.php" class="nav-link">
        <i class="bi bi-plus-circle"></i> Tambah Buku
    </a>

    <div class="nav-label">AKUN</div>

    <a href="logout.php" class="nav-link">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <div class="position-absolute bottom-0 start-0 p-4 text-secondary small">
        Library App · 2026
    </div>

</aside>

<!-- MAIN -->
<main class="main-content">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h1 class="page-title">Library Overview</h1>

            <p class="subtitle mb-0">
                Selamat datang,
                <?= htmlspecialchars($_SESSION['username']) ?>.
                Berikut koleksi perpustakaanmu.
            </p>
        </div>

        <a href="tambah_buku.php" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Buku
        </a>

    </div>

    <!-- STATISTIK -->
    <div class="row g-3 mb-5">

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-book"></i>
                </div>

                <div class="stat-number"><?= $totalBuku ?></div>
                <div class="stat-label">Total Koleksi Buku</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-check-circle"></i>
                </div>

                <div class="stat-number"><?= $totalTersedia ?></div>
                <div class="stat-label">Buku Tersedia</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-danger-subtle text-danger">
                    <i class="bi bi-exclamation-circle"></i>
                </div>

                <div class="stat-number"><?= $totalHabis ?></div>
                <div class="stat-label">Stok Habis</div>
            </div>
        </div>

    </div>

    <!-- DAFTAR BUKU -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">

        <div>
            <h4 class="fw-bold mb-1">Koleksi Buku</h4>
            <p class="subtitle mb-0">Semua buku yang terdaftar di sistem.</p>
        </div>

        <div class="search-box">
            <i class="bi bi-search"></i>
            <input
                type="text"
                id="searchBook"
                class="form-control"
                placeholder="Cari judul atau penulis..."
            >
        </div>

    </div>

    <div class="row g-4" id="bookList">

        <?php while ($buku = mysqli_fetch_assoc($query)) { ?>

            <div class="col-sm-6 col-lg-4 col-xl-3 book-item">

                <div class="book-card">

                    <?php if (!empty($buku['sampul'])) { ?>

                        <img
                            src="uploads/<?= htmlspecialchars($buku['sampul']) ?>"
                            class="book-cover"
                            alt="Sampul buku"
                        >

                    <?php } else { ?>

                        <div class="book-cover d-flex align-items-center justify-content-center">
                            <i class="bi bi-book text-secondary fs-1"></i>
                        </div>

                    <?php } ?>

                    <div class="book-info">

                        <div class="book-title">
                            <?= htmlspecialchars($buku['judul']) ?>
                        </div>

                        <div class="book-meta mb-2">
                            <?= htmlspecialchars($buku['penulis']) ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <small class="text-secondary">
                                <?= htmlspecialchars($buku['kategori']) ?>
                                · <?= htmlspecialchars($buku['tahun_terbit']) ?>
                            </small>

                            <?php if ($buku['stok'] > 0) { ?>

                                <span class="status-available">
                                    Tersedia
                                </span>

                            <?php } else { ?>

                                <span class="status-empty">
                                    Dipinjam
                                </span>

                            <?php } ?>

                        </div>

                        <div class="d-flex justify-content-between align-items-center">

                            <small class="text-secondary">
                                Stok: <?= (int)$buku['stok'] ?>
                            </small>

                            <div class="d-flex gap-2">

                                <a
                                    href="edit_buku.php?id=<?= (int)$buku['id'] ?>"
                                    class="btn btn-sm btn-light"
                                    title="Edit buku"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a
                                    href="hapus_buku.php?id=<?= (int)$buku['id'] ?>"
                                    class="btn btn-sm btn-light text-danger"
                                    onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                    title="Hapus buku"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

    <div id="emptySearch" class="text-center py-5 text-secondary" style="display:none;">
        <i class="bi bi-search fs-1"></i>
        <p class="mt-2">Buku tidak ditemukan.</p>
    </div>

    <footer class="text-center text-secondary small mt-5">
        Designed for Mini Digital Library · 2026
    </footer>

</main>

<!-- JAVASCRIPT FRAMEWORK -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- CUSTOM JAVASCRIPT -->
<script>
const searchInput = document.getElementById("searchBook");
const bookItems = document.querySelectorAll(".book-item");
const emptySearch = document.getElementById("emptySearch");

searchInput.addEventListener("input", function () {

    const keyword = this.value.toLowerCase();
    let visibleCount = 0;

    bookItems.forEach(function (item) {

        const text = item.textContent.toLowerCase();
        const match = text.includes(keyword);

        item.style.display = match ? "" : "none";

        if (match) {
            visibleCount++;
        }

    });

    emptySearch.style.display =
        visibleCount === 0 ? "block" : "none";

});
</script>

</body>
</html>
