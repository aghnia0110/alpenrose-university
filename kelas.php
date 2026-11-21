<?php
session_start();
include 'koneksi.php';

// Cek akses admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit;
}

// Pencarian data
$cari = $_GET['cari'] ?? '';

$sql = "SELECT * FROM kelas
        WHERE kode_kelas LIKE ?
        OR matakuliah LIKE ?
        OR jurusan LIKE ?
        ORDER BY semester ASC, kode_kelas ASC";

$stmt = mysqli_prepare($koneksi, $sql);
$keyword = "%$cari%";
mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah & Kelas - Alpenrose University</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
            overflow-y: auto;
        }

        .brand {
            color: #d5b36a;
            text-align: center;
            font-family: Georgia, serif;
            font-size: 27px;
            font-weight: bold;
            margin-bottom: 35px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #c39a48;
            color: #102747;
        }

        .menu-title {
            color: #aebdd0;
            font-size: 11px;
            letter-spacing: 1px;
            margin: 22px 0 10px;
            padding-left: 10px;
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

        .page-title {
            color: #102747;
            font-family: Georgia, serif;
            font-weight: bold;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .table thead th {
            background: #102747;
            color: white;
            white-space: nowrap;
        }

        .btn-primary {
            background: #102747;
            border-color: #102747;
        }

        .btn-primary:hover {
            background: #c39a48;
            border-color: #c39a48;
            color: #102747;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
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

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="brand">
        ALPENROSE<br>UNIVERSITY
    </div>

    <a href="dashboard.php">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <div class="menu-title">ACADEMIC MANAGEMENT</div>

    <a href="mahasiswa.php">
        <i class="bi bi-people"></i> Data Mahasiswa
    </a>

    <a href="dosen.php">
        <i class="bi bi-person-badge"></i> Data Dosen
    </a>

    <a href="kelas.php" class="active">
        <i class="bi bi-book"></i> Data Mata Kuliah & Kelas
    </a>

    <a href="jadwal.php">
        <i class="bi bi-calendar"></i> Data Jadwal
    </a>

    <a href="krs.php">
        <i class="bi bi-journal-check"></i> Data KRS
    </a>

    <a href="absensi.php">
        <i class="bi bi-clipboard-check"></i> Data Absensi
    </a>

    <a href="nilai.php">
        <i class="bi bi-award"></i> Data Nilai
    </a>

    <div class="menu-title">ADMINISTRATION</div>

    <a href="admin_pendaftaran.php">
        <i class="bi bi-person-plus"></i> Pendaftaran Mahasiswa Baru
    </a>

    <a href="logout.php" class="text-danger mt-4">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <div>
            <h5 class="mb-1">Academic Management</h5>
            <small class="text-muted">Alpenrose University</small>
        </div>

        <div>
            <i class="bi bi-person-circle fs-4" style="color:#102747;"></i>
            <span class="ms-2">Administrator Server</span>
        </div>
    </div>

    <h2 class="page-title">Data Mata Kuliah & Kelas</h2>

    <p class="text-muted">
        Kelola informasi mata kuliah dan kelas Alpenrose University.
    </p>

    <div class="card shadow-sm mt-4">
        <div class="card-body p-4">

            <h5 class="mb-3" style="color:#102747;">
                <i class="bi bi-book"></i> Daftar Mata Kuliah
            </h5>

            <!-- PENCARIAN -->
            <form method="GET" class="row g-2 mb-4">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="cari"
                        class="form-control"
                        placeholder="Cari kode kelas, mata kuliah, atau jurusan..."
                        value="<?= htmlspecialchars($cari); ?>"
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="kelas.php" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

            <!-- TABEL DATA -->
            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Fakultas</th>
                            <th>Program Studi</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($result) > 0): ?>

                            <?php $no = 1; ?>

                            <?php while ($data = mysqli_fetch_assoc($result)): ?>

                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars($data['kode_kelas']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['matakuliah']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['sks']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['fakultas']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['jurusan']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['semester']); ?>
                                    </td>

                                    <td>
    <a href="edit_kelas.php?kode_kelas=<?= urlencode($data['kode_kelas']); ?>"
       class="btn btn-warning btn-sm">
        <i class="bi bi-pencil-square"></i> Edit
    </a>
</td>
                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Data mata kuliah atau kelas tidak ditemukan.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <div class="text-muted small">
                Total data ditampilkan: <?= mysqli_num_rows($result); ?> kelas.
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>