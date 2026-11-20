<?php
session_start();
include 'koneksi.php';

// Mengambil data dari form login
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role_pilihan = strtolower(trim($_POST['role'] ?? ''));

// Validasi input
if ($username === '' || $password === '') {
    header("Location: login.html?error=gagal");
    exit;
}

// Mencari akun berdasarkan username
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM user WHERE username = ? LIMIT 1"
);

if (!$stmt) {
    die("Terjadi kesalahan database: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Memeriksa username dan password
if ($data && $password === $data['password']) {

    // Mengambil role dari database
    $role_database = strtolower(trim($data['role']));

    // Admin tidak perlu memilih role
    if (
        $role_database !== 'admin' &&
        $role_database !== $role_pilihan
    ) {
        mysqli_stmt_close($stmt);
        header("Location: login.html?error=role");
        exit;
    }

    // Membuat session login
    session_regenerate_id(true);

    $_SESSION['username'] = $data['username'];
    $_SESSION['nama'] = $data['nama'] ?? $data['username'];
    $_SESSION['role'] = $role_database;

    mysqli_stmt_close($stmt);

    // Masuk ke dashboard
    header("Location: dashboard.php");
    exit;

} else {

    mysqli_stmt_close($stmt);

    // Jika login gagal
    header("Location: login.html?error=gagal");
    exit;
}
?>