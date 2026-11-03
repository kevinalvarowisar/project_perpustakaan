
<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

$username = $_COOKIE['remember_username'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login - Library</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="text-center mb-4">

            <i class="bi bi-book-half login-logo"></i>

            <h2 class="fw-bold mt-3">Library</h2>

            <p class="subtitle">
                Your personal digital library.
            </p>

        </div>

        <h5 class="fw-bold mb-1">Welcome back.</h5>

        <p class="subtitle mb-4">
            Silakan masuk untuk mengelola koleksi buku.
        </p>

        <form action="proses_login.php" method="POST">

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Username
                </label>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Masukkan username"
                    value="<?= htmlspecialchars($username) ?>"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >

            </div>

            <div class="form-check mb-4">

                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="form-check-input"
                    id="remember"
                >

                <label class="form-check-label small" for="remember">
                    Remember me
                </label>

            </div>

            <button type="submit" class="btn btn-primary w-100">
                Sign In <i class="bi bi-arrow-right ms-1"></i>
            </button>

        </form>

        <div class="text-center mt-4">
            <small class="text-secondary">
                Mini Digital Library · 2026
            </small>
        </div>

    </div>

</div>

</body>
</html>
