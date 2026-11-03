<?php
require_once "config/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
</head>
<body>
<div class="container py-5">

    <div class="form-card p-4 mx-auto"
         style="max-width: 650px;">

        <a href="dashboard.php"
           class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <h3 class="fw-bold mt-4">Tambah Buku</h3>

        <p class="subtitle mb-4">
            Lengkapi informasi koleksi buku.
        </p>

    <h1>Tambah Buku Baru</h1>
        <form action="proses_tambah.php"
      method="POST"
      enctype="multipart/form-data">

        <label>Judul Buku</label><br>
        <input type="text" name="judul" required>
        <br><br>

        <label>Kategori</label><br>
        <input type="text" name="kategori" required>
        <br><br>

        <label>Penulis</label><br>
        <input type="text" name="penulis" required>
        <br><br>

        <label>Tahun Terbit</label><br>
        <input type="number" name="tahun_terbit"
               min="1901" max="2155" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Sampul Buku</label><br>
<input type="file" name="sampul"
       accept=".jpg,.jpeg,.png" required>
<br><br>

        <button type="submit">Simpan Buku</button>

    </form>

    </div>


    <br>
    <a href="dashboard.php">Kembali ke Daftar Buku</a>

</body>
</html>