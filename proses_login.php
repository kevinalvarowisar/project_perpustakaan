<?php

session_start();

include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_prepare(
    $koneksi,
    "SELECT * FROM users WHERE username = ?"
);

mysqli_stmt_bind_param($query, "s", $username);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {

    session_regenerate_id(true);

    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];

    if (isset($_POST['remember'])) {

        setcookie(
            "remember_username",
            $username,
            time() + (30 * 24 * 60 * 60),
            "/project_perpustakaan/",
            "",
            false,
            true
        );

    } else {

        setcookie(
            "remember_username",
            "",
            time() - 3600,
            "/project_perpustakaan/"
        );

    }

    header("Location: dashboard.php");
    exit;

} else {

    echo "Username atau password salah.";
    echo "<br><a href='index.php'>Kembali ke Login</a>";

}

?>