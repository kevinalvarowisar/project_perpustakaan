<?php

include "koneksi.php";

$username = "admin";
$password = "admin123";

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$query = mysqli_prepare(
    $koneksi,
    "INSERT INTO users (username, password)
     VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $query,
    "ss",
    $username,
    $passwordHash
);

if (mysqli_stmt_execute($query)) {
    echo "Akun admin berhasil dibuat!";
} else {
    echo "Gagal membuat akun: " . mysqli_error($koneksi);
}

?>