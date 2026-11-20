<?php
session_start();
include 'koneksi.php';

// Pastikan sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Ambil data mahasiswa
$query = mysqli_query($koneksi, "SELECT * FROM mahasiswa ORDER BY nim ASC");

if (!$query) {
    die("Gagal mengambil data: " . mysqli_error($koneksi));
}

// Proses hapus mahasiswa
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];

    $stmt = mysqli_prepare($koneksi, "DELETE FROM mahasiswa WHERE nim = ?");
    mysqli_stmt_bind_param($stmt, "s", $nim);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: mahasiswa.php?pesan=hapus");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Alpenrose University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6fa;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 245px;
            min-height: 100vh;
            background: #14243d;
            color: white;
            position: fixed;
            padding: 25px 18px;
        }
        .sidebar h4 {
            color: #d6b56d;
            margin-bottom: 35px;
        }
        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 7px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background: #d6b56d;
            color: #14243d;
        }
        .main {
            margin-left: 245px;
            padding: 35px;
        }
        .content-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }
        .table thead {
            background: #14243d;
            color: white;
        }
        @media(max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .main {
                margin-left: 0;
                padding: 18px;
            }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Alpenrose University</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="mahasiswa.php" class="active">Data Mahasiswa</a>
    <a href="dosen.php">Data Dosen</a>
    <a href="kelas.php">Data Kelas</a>
    <a href="jadwal.php">Jadwal Kuliah</a>
    <a href="krs.php">KRS Mahasiswa</a>
    <a href="absensi_mahasiswa.php">Absensi</a>
    <a href="nilai_mahasiswa.php">Nilai Mahasiswa</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h2 class="fw-bold mb-2">Data Mahasiswa</h2>
    <p class="text-secondary">Alpenrose University Academic Information System</p>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus'): ?>
        <div class="alert alert-success">Data mahasiswa berhasil dihapus.</div>
    <?php endif; ?>

    <div class="content-card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold">Daftar Mahasiswa</h5>
            <span class="badge bg-primary">
                Total: <?= mysqli_num_rows($query); ?> Mahasiswa
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($data = mysqli_fetch_assoc($query)):
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($data['nim']); ?></td>
                        <td><?= htmlspecialchars($data['nama']); ?></td>
                        <td><?= htmlspecialchars($data['jurusan']); ?></td>
                        <td>
                            <a href="mahasiswa.php?hapus=<?= urlencode($data['nim']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data mahasiswa.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>