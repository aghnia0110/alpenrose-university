<?php
session_start();
include 'koneksi.php';

// Cek akses admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit;
}

// Pencarian
$cari = $_GET['cari'] ?? '';

$sql = "SELECT
            j.*,
            k.matakuliah,
            d.nama_lengkap AS nama_dosen
        FROM jadwal j
        LEFT JOIN kelas k ON j.kode_kelas = k.kode_kelas
        LEFT JOIN dosen d ON j.nid = d.nid
        WHERE j.kode_kelas LIKE ?
        OR k.matakuliah LIKE ?
        OR d.nama_lengkap LIKE ?
        OR j.hari LIKE ?
        OR j.ruangan LIKE ?
        ORDER BY j.hari ASC, j.jam_mulai ASC";

$stmt = mysqli_prepare($koneksi, $sql);
$keyword = "%$cari%";

mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $keyword,
    $keyword,
    $keyword,
    $keyword,
    $keyword
);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Jadwal - Alpenrose University</title>

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
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .aksi-column {
            min-width: 170px;
            text-align: center;
            white-space: nowrap;
        }

        .aksi-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
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

    <a href="kelas.php">
        <i class="bi bi-book"></i> Data Mata Kuliah & Kelas
    </a>

    <a href="jadwal.php" class="active">
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

    <!-- JUDUL HALAMAN -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="page-title">Data Jadwal</h2>

            <p class="text-muted">
                Informasi jadwal perkuliahan Alpenrose University.
            </p>
        </div>

        <a href="tambah_jadwal.php" class="btn btn-warning">
            <i class="bi bi-plus-circle"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body p-4">

            <h5 class="mb-3" style="color:#102747;">
                <i class="bi bi-calendar-week"></i>
                Daftar Jadwal Perkuliahan
            </h5>

            <!-- PENCARIAN -->
            <form method="GET" class="row g-2 mb-4">

                <div class="col-md-6">
                    <input
                        type="text"
                        name="cari"
                        class="form-control"
                        placeholder="Cari kode kelas, mata kuliah, dosen, hari, atau ruangan..."
                        value="<?= htmlspecialchars($cari); ?>"
                    >
                </div>

                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="jadwal.php" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

            <!-- TABEL -->
            <div class="table-responsive">

                <table class="table table-bordered table-striped align-middle">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kelas</th>
                            <th>Mata Kuliah</th>
                            <th>NID</th>
                            <th>Nama Dosen</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Ruangan</th>
                            <th class="aksi-column">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (mysqli_num_rows($result) > 0): ?>

                            <?php $no = 1; ?>

                            <?php while ($data = mysqli_fetch_assoc($result)): ?>

                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td><?= htmlspecialchars($data['kode_kelas'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['matakuliah'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['nid'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['nama_dosen'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['hari'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['jam_mulai'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['jam_selesai'] ?? '-'); ?></td>

                                    <td><?= htmlspecialchars($data['ruangan'] ?? '-'); ?></td>

                                    <td class="aksi-column">
                                        <div class="aksi-buttons">

                                            <a href="edit_jadwal.php?id=<?= $data['id']; ?>"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <a href="hapus_jadwal.php?id=<?= $data['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    Data jadwal belum tersedia.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <div class="text-muted small">
                Total jadwal ditampilkan: <?= mysqli_num_rows($result); ?> data.
            </div>

        </div>
    </div>

</div>

</body>
</html>