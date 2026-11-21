
<?php
session_start();
include 'koneksi.php';

// =====================================
// CEK LOGIN DAN HAK AKSES
// =====================================
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.html");
    exit;
}

$role = strtolower($_SESSION['role']);

if ($role != 'admin' && $role != 'mahasiswa') {
    header("Location: dashboard.php");
    exit;
}

// =====================================
// PENCARIAN DAN QUERY KRS
// =====================================
$cari = $_GET['cari'] ?? '';

if ($role == 'mahasiswa') {

    // Mahasiswa hanya melihat KRS miliknya sendiri
    $sql = "SELECT
                krs.*,
                m.nama AS nama_mahasiswa,
                kl.matakuliah,
                d.nama_lengkap AS nama_dosen,
                j.ruangan
            FROM krs
            LEFT JOIN mahasiswa m
                ON krs.nim = m.nim
            LEFT JOIN kelas kl
                ON krs.kode_kelas = kl.kode_kelas
            LEFT JOIN jadwal j
                ON j.id = (
                    SELECT MIN(j2.id)
                    FROM jadwal j2
                    WHERE j2.kode_kelas = krs.kode_kelas
                )
            LEFT JOIN dosen d
                ON j.nid = d.nid
            WHERE krs.nim = ?
            ORDER BY krs.id_krs DESC";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $_SESSION['username']
    );

} else {

    // Admin dapat melihat seluruh data KRS
    $sql = "SELECT
                krs.*,
                m.nama AS nama_mahasiswa,
                kl.matakuliah,
                d.nama_lengkap AS nama_dosen,
                j.ruangan
            FROM krs
            LEFT JOIN mahasiswa m
                ON krs.nim = m.nim
            LEFT JOIN kelas kl
                ON krs.kode_kelas = kl.kode_kelas
            LEFT JOIN jadwal j
                ON j.id = (
                    SELECT MIN(j2.id)
                    FROM jadwal j2
                    WHERE j2.kode_kelas = krs.kode_kelas
                )
            LEFT JOIN dosen d
                ON j.nid = d.nid
            WHERE krs.nim LIKE ?
               OR m.nama LIKE ?
               OR krs.kode_kelas LIKE ?
               OR kl.matakuliah LIKE ?
               OR d.nama_lengkap LIKE ?
               OR j.ruangan LIKE ?
            ORDER BY krs.id_krs DESC";

    $stmt = mysqli_prepare($koneksi, $sql);
    $keyword = "%$cari%";

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword,
        $keyword
    );
}

if (!$stmt) {
    die("Query gagal: " . mysqli_error($koneksi));
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KRS - Alpenrose University</title>

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

        .content-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        .table thead th {
            background: #102747;
            color: white;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .btn-gold {
            background: #c39a48;
            color: #102747;
            border: none;
        }

        .btn-gold:hover {
            background: #d5b36a;
            color: #102747;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
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

    <?php if ($role == 'admin'): ?>

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

        <a href="jadwal.php">
            <i class="bi bi-calendar-week"></i> Data Jadwal
        </a>

        <a href="krs.php" class="active">
            <i class="bi bi-journal-check"></i> Data KRS
        </a>

        <a href="absensi.php">
            <i class="bi bi-clipboard-check"></i> Data Absensi
        </a>

        <a href="nilai.php">
            <i class="bi bi-card-list"></i> Data Nilai
        </a>

        <div class="menu-title">ADMISSION MANAGEMENT</div>

        <a href="admin_pendaftaran.php">
            <i class="bi bi-person-plus"></i> Pendaftaran Mahasiswa Baru
        </a>

    <?php else: ?>

        <div class="menu-title">AKADEMIK</div>

        <a href="krs.php" class="active">
            <i class="bi bi-journal-check"></i> KRS Saya
        </a>

    <?php endif; ?>

</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <div>
            <h5 class="mb-1">Data KRS</h5>
            <small class="text-muted">
                <?= $role == 'admin' ? 'Administrator Server' : 'Kartu Rencana Studi Saya'; ?>
            </small>
        </div>

        <div>
            <i class="bi bi-person-circle fs-4"></i>
            <span class="ms-2">
                <?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username']); ?>
            </span>
        </div>
    </div>

    <div class="content-box">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h4 class="mb-1">
                    <?= $role == 'admin' ? 'Daftar Kartu Rencana Studi' : 'Kartu Rencana Studi Saya'; ?>
                </h4>

                <p class="text-muted mb-0">
                    <?= $role == 'admin'
                        ? 'Informasi pengambilan mata kuliah mahasiswa.'
                        : 'Informasi mata kuliah yang kamu ambil.'; ?>
                </p>
            </div>

            <?php if ($role == 'admin'): ?>
                <a href="tambah_krs.php" class="btn btn-gold">
                    <i class="bi bi-plus-circle"></i> Tambah KRS
                </a>
            <?php endif; ?>

        </div>

        <!-- PENCARIAN KHUSUS ADMIN -->
        <?php if ($role == 'admin'): ?>
            <form method="GET" class="mb-3">
                <div class="input-group" style="max-width: 450px;">

                    <input
                        type="text"
                        name="cari"
                        class="form-control"
                        placeholder="Cari NIM, nama, kelas, dosen, atau ruangan..."
                        value="<?= htmlspecialchars($cari); ?>"
                    >

                    <button class="btn btn-dark" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>

                    <a href="krs.php" class="btn btn-secondary">
                        Reset
                    </a>

                </div>
            </form>
        <?php endif; ?>

        <!-- TABEL KRS -->
        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Kode Kelas</th>
                        <th>Mata Kuliah</th>
                        <th>Nama Dosen</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <th>Tahun Akademik</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (mysqli_num_rows($result) > 0): ?>

                        <?php $no = 1; ?>

                        <?php while ($data = mysqli_fetch_assoc($result)): ?>

                            <tr>
                                <td class="text-center">
                                    <?= $no++; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nim']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama_mahasiswa'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['kode_kelas']); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['matakuliah'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['nama_dosen'] ?? '-'); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($data['ruangan'] ?? '-'); ?>
                                </td>

                                <td class="text-center">
                                    <?= htmlspecialchars($data['semester'] ?? '-'); ?>
                                </td>

                                <td class="text-center">
                                    <?= htmlspecialchars($data['tahun_akademik'] ?? '-'); ?>
                                </td>

                                <td class="text-center">
                                    <?php if ($data['status'] == 'Aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <?= htmlspecialchars($data['status'] ?? '-'); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Data KRS belum tersedia.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>