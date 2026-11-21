<?php
session_start();
include 'koneksi.php';

// Cek hak akses admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.html");
    exit;
}

// Proses hapus dosen
if (isset($_GET['hapus'])) {
    $nid = $_GET['hapus'];

    $stmtHapus = mysqli_prepare(
        $koneksi,
        "DELETE FROM dosen WHERE nid = ?"
    );

    mysqli_stmt_bind_param($stmtHapus, "s", $nid);

    if (mysqli_stmt_execute($stmtHapus)) {
        mysqli_stmt_close($stmtHapus);
        header("Location: dosen.php?pesan=hapus");
        exit;
    } else {
        $pesanError = mysqli_stmt_error($stmtHapus);
        mysqli_stmt_close($stmtHapus);
    }
}

// Pencarian dosen
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';

$sql = "SELECT * FROM dosen
        WHERE nid LIKE ?
        OR nama_lengkap LIKE ?
        ORDER BY nid ASC";

$stmt = mysqli_prepare($koneksi, $sql);

$keyword = "%" . $cari . "%";

mysqli_stmt_bind_param($stmt, "ss", $keyword, $keyword);
mysqli_stmt_execute($stmt);

$query = mysqli_stmt_get_result($stmt);
$total = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Dosen - Alpenrose University</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f3ed;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #17243b;
            color: white;
            position: fixed;
            padding: 25px 18px;
        }

        .sidebar h4 {
            color: #d9bd83;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: #ddd;
            text-decoration: none;
            padding: 11px;
            border-radius: 7px;
            margin-bottom: 5px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #d9bd83;
            color: #17243b;
        }

        .menu-title {
            font-size: 12px;
            color: #9ba8ba;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .main {
            margin-left: 250px;
            padding: 35px;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .table thead th {
            background: #17243b;
            color: white;
            white-space: nowrap;
        }

        .btn-gold {
            background: #d9bd83;
            color: #17243b;
            border: none;
        }

        .btn-gold:hover {
            background: #c5a66b;
            color: #17243b;
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

<!-- SIDEBAR -->
<div class="sidebar">

    <h4>ALPENROSE</h4>
    <p>UNIVERSITY</p>

    <hr>

    <a href="dashboard.php">
        <i class="bi bi-grid"></i> Dashboard
    </a>

    <p class="menu-title">ACADEMIC MANAGEMENT</p>

    <a href="mahasiswa.php">
        <i class="bi bi-people"></i> Data Mahasiswa
    </a>

    <a href="dosen.php" class="active">
        <i class="bi bi-person-badge"></i> Data Dosen
    </a>

    <a href="kelas.php">
        <i class="bi bi-book"></i> Data Mata Kuliah & Kelas
    </a>

    <a href="jadwal.php">
        <i class="bi bi-calendar"></i> Data Jadwal
    </a>

    <a href="krs.php">
        <i class="bi bi-journal"></i> Data KRS
    </a>

    <a href="absensi.php">
        <i class="bi bi-clipboard-check"></i> Data Absensi
    </a>

    <a href="nilai.php">
        <i class="bi bi-award"></i> Data Nilai
    </a>

    <p class="menu-title">ADMISSION MANAGEMENT</p>

    <a href="admin_pendaftaran.php">
        <i class="bi bi-person-plus"></i> Pendaftaran Mahasiswa Baru
    </a>

    <a href="logout.php">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

</div>

<!-- KONTEN UTAMA -->
<div class="main">

    <h3 class="fw-bold">Data Dosen</h3>

    <p class="text-secondary">
        Pengelolaan data dosen Alpenrose University
    </p>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus'): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            Data dosen berhasil dihapus.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit'): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i>
        Data dosen berhasil diperbarui.
    </div>
<?php endif; ?>

    <?php if (isset($pesanError)): ?>
        <div class="alert alert-danger">
            Gagal menghapus data: <?= htmlspecialchars($pesanError); ?>
        </div>
    <?php endif; ?>

    <div class="content-card mt-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

            <div>
                <h5 class="fw-bold mb-1">Daftar Dosen</h5>

                <small class="text-secondary">
                    Total: <?= $total; ?> dosen
                </small>
            </div>

            <form method="GET" class="d-flex gap-2">

                <input
                    type="text"
                    name="cari"
                    class="form-control"
                    placeholder="Cari NID atau nama dosen..."
                    value="<?= htmlspecialchars($cari); ?>"
                >

                <button type="submit" class="btn btn-gold">
                    <i class="bi bi-search"></i> Cari
                </button>

                <a href="dosen.php" class="btn btn-secondary">
                    Reset
                </a>

            </form>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NID</th>
                        <th>Nama Lengkap</th>
                        <th>Program Studi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;

                if ($total > 0):
                    while ($data = mysqli_fetch_assoc($query)):
                ?>

                    <tr>
                        <td><?= $no++; ?></td>

                        <td>
                            <?= htmlspecialchars($data['nid']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['nama_lengkap']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['program_studi'] ?? '-'); ?>
                        </td>

                        <td>
                            <div class="d-flex gap-2">

                                <a
                                    href="edit_dosen.php?nid=<?= urlencode($data['nid']); ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <a
                                    href="dosen.php?hapus=<?= urlencode($data['nid']); ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus dosen ini?')"
                                >
                                    <i class="bi bi-trash"></i> Hapus
                                </a>

                            </div>
                        </td>
                    </tr>

                <?php
                    endwhile;
                else:
                ?>

                    <tr>
                        <td colspan="5" class="text-center text-secondary">
                            Data dosen tidak ditemukan.
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

<?php
mysqli_stmt_close($stmt);
?>