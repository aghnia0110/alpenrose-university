
<?php
session_start();

// Pengecekan status login
if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == 'gagal') {

    $login_gagal = true;

} elseif (isset($_SESSION['username'])) {

    $login_gagal = false;

    $username = $_SESSION['username'];
    $nama = $_SESSION['nama'] ?? $username;
    $role = $_SESSION['role'] ?? 'mahasiswa';

} else {

    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Alpenrose University</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            background: #f5f4ef;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            background: #102747;
            padding: 25px 20px;
            color: white;
        }

        .brand {
            color: #d5b36a;
            text-align: center;
            font-family: Georgia, serif;
            font-size: 27px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 13px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #c39a48;
            color: #102747;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
        }

        .topbar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .welcome {
            background: linear-gradient(120deg, #102747, #345678);
            padding: 40px;
            border-radius: 15px;
            color: white;
            margin-bottom: 30px;
        }

        .welcome h1 {
            color: #e2c47e;
            font-family: Georgia, serif;
        }

        .card-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            height: 100%;
            box-shadow: 0 3px 15px rgba(0,0,0,.04);
        }

        .card-box i {
            font-size: 32px;
            color: #c39a48;
        }

        .card-box h3 {
            color: #102747;
            margin-top: 15px;
        }

        .logout {
            color: #ffb4a9 !important;
            margin-top: 30px;
        }

        .error-card {
            background: white;
            width: 90%;
            max-width: 500px;
            padding: 45px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
        }

        .error-card i {
            font-size: 70px;
            color: #dc3545;
        }

        .error-card h1 {
            color: #102747;
            font-family: Georgia, serif;
            margin-top: 20px;
        }

        @media(max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

<?php if ($login_gagal) { ?>

    <!-- HALAMAN LOGIN GAGAL -->

    <div class="container d-flex justify-content-center align-items-center"
         style="min-height:100vh;">

        <div class="error-card">

            <div style="color:#c39a48; font-family:Georgia,serif;
                        font-weight:bold; margin-bottom:25px;">
                <i class="bi bi-mortarboard-fill"
                   style="font-size:25px; color:#c39a48;"></i>
                ALPENROSE UNIVERSITY
            </div>

            <i class="bi bi-x-circle-fill"></i>

            <h1>LOGIN GAGAL!</h1>

            <p class="text-muted mt-3">
                Username atau password yang Anda masukkan salah.
                Silakan periksa kembali akun Anda.
            </p>

            <a href="login.html"
               class="btn btn-primary mt-3"
               style="background:#102747; border:none; padding:12px 25px;">
                <i class="bi bi-arrow-left me-2"></i>
                Kembali ke Login
            </a>

            <footer class="text-center text-muted mt-4 small">
                © 2026 Alpenrose University. All Rights Reserved.
            </footer>

        </div>

    </div>

<?php } else { ?>


<!-- DASHBOARD LOGIN BERHASIL -->

<div class="sidebar">

    <div class="brand">
        <i class="bi bi-mortarboard-fill"></i>
        <br>
        ALPENROSE
        <div style="font-size:10px;letter-spacing:3px;">
            UNIVERSITY
        </div>
    </div>

    <a href="dashboard.php" class="active">
        <i class="bi bi-grid-fill me-2"></i> Dashboard
    </a>

    <?php if ($role === 'admin') { ?>

        <a href="mahasiswa.php">
            <i class="bi bi-people-fill me-2"></i> Data Mahasiswa
        </a>

        <a href="dosen.php">
            <i class="bi bi-person-badge-fill me-2"></i> Data Dosen
        </a>

        <a href="kelas.php">
            <i class="bi bi-book-fill me-2"></i> Data Kelas
        </a>

        <a href="jadwal.php">
            <i class="bi bi-calendar-week me-2"></i> Data Jadwal
        </a>

        <a href="krs.php">
            <i class="bi bi-journal-check me-2"></i> Data KRS
        </a>

        <a href="absensi.php">
            <i class="bi bi-clipboard-check me-2"></i> Data Absensi
        </a>

        <a href="nilai.php">
            <i class="bi bi-award-fill me-2"></i> Data Nilai
        </a>

    <?php } elseif ($role === 'dosen') { ?>

        <a href="jadwal.php">
            <i class="bi bi-calendar-week me-2"></i> Jadwal Mengajar
        </a>

        <a href="absensi.php">
            <i class="bi bi-clipboard-check me-2"></i> Kelola Absensi
        </a>

        <a href="nilai.php">
            <i class="bi bi-award-fill me-2"></i> Kelola Nilai
        </a>

    <?php } elseif ($role === 'mahasiswa') { ?>

        <a href="jadwal.php">
            <i class="bi bi-calendar-week me-2"></i> Jadwal Kuliah
        </a>

        <a href="krs.php">
            <i class="bi bi-journal-check me-2"></i> Kartu Rencana Studi
        </a>

        <a href="absensi_mahasiswa.php">
            <i class="bi bi-clipboard-check me-2"></i> Riwayat Absensi
        </a>

        <a href="nilai_mahasiswa.php">
            <i class="bi bi-award-fill me-2"></i> Nilai Akademik
        </a>

    <?php } ?>

    <a href="logout.php" class="logout">
        <i class="bi bi-box-arrow-left me-2"></i> Logout
    </a>

</div>

<div class="main">

    <div class="topbar">

        <div>
            <h5 class="fw-bold mb-1">Alpenrose University</h5>
            <small class="text-muted">Academic Portal</small>
        </div>

        <div class="text-end">
            <strong><?= htmlspecialchars($nama) ?></strong>
            <br>
            <span class="badge bg-warning text-dark">
                <?= htmlspecialchars(ucfirst($role)) ?>
            </span>
        </div>

    </div>

    <div class="welcome">

        <p>WELCOME TO ALPENROSE UNIVERSITY</p>

        <?php if ($role === 'admin') { ?>

            <h1>Hello, Administrator!</h1>
            <p>
                Selamat datang di halaman Admin Server.
                Anda memiliki akses untuk mengelola data akademik
                Alpenrose University.
            </p>

        <?php } elseif ($role === 'dosen') { ?>

            <h1>Hello, <?= htmlspecialchars($nama) ?>!</h1>
            <p>
                Selamat datang di portal Dosen.
                Silakan kelola jadwal mengajar, absensi,
                dan nilai mahasiswa.
            </p>

        <?php } else { ?>

            <h1>Hello, <?= htmlspecialchars($nama) ?>!</h1>
            <p>
                Selamat datang di portal Mahasiswa.
                Silakan lihat jadwal kuliah, KRS,
                absensi, dan nilai akademik Anda.
            </p>

        <?php } ?>

    </div>

    <h3 class="fw-bold mb-3" style="color:#102747;">
        <?php
        if ($role === 'admin') {
            echo 'Administrator Overview';
        } elseif ($role === 'dosen') {
            echo 'Lecturer Overview';
        } else {
            echo 'Student Overview';
        }
        ?>
    </h3>

    <div class="row g-3">

        <?php if ($role === 'admin') { ?>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-people-fill"></i>
                    <h3>48</h3>
                    <p>Total Mahasiswa</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-person-badge-fill"></i>
                    <h3>0</h3>
                    <p>Total Dosen</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-book-fill"></i>
                    <h3>7</h3>
                    <p>Total Kelas</p>
                </div>
            </div>

        <?php } elseif ($role === 'dosen') { ?>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-calendar-week"></i>
                    <h3>0</h3>
                    <p>Jadwal Mengajar</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-clipboard-check"></i>
                    <h3>0</h3>
                    <p>Absensi Mahasiswa</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-award-fill"></i>
                    <h3>0</h3>
                    <p>Nilai Mahasiswa</p>
                </div>
            </div>

        <?php } else { ?>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-book-fill"></i>
                    <h3>0</h3>
                    <p>Mata Kuliah</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-calendar-check-fill"></i>
                    <h3>0</h3>
                    <p>Jadwal Akademik</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-box">
                    <i class="bi bi-award-fill"></i>
                    <h3>-</h3>
                    <p>Prestasi Akademik</p>
                </div>
            </div>

        <?php } ?>

    </div>

    <div class="card-box mt-4">

        <h4 class="fw-bold">Account Information</h4>
        <hr>

        <p><strong>Nama:</strong> <?= htmlspecialchars($nama) ?></p>
        <p><strong>Username:</strong> <?= htmlspecialchars($username) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars(ucfirst($role)) ?></p>

        <p>
            <strong>Status:</strong>
            <span class="text-success">Login Berhasil</span>
        </p>

    </div>

    <footer class="text-center text-muted mt-4 small">
        © 2026 Alpenrose University. All Rights Reserved.
    </footer>

</div>

<?php } ?>

</body>
</html>