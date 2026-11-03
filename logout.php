<?php

session_start();

// Menghapus semua data session
$_SESSION = [];

// Menghapus cookie session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Menghapus session
session_destroy();

// Menghapus cookie Remember Me
setcookie(
    "remember_username",
    "",
    time() - 3600,
    "/project_perpustakaan/"
);

// Kembali ke halaman login
header("Location: index.php");
exit;

?>