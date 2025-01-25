<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit;
}

$error = "";
$success = "";

try {
    // Ambil semua data periode
    $stmt = $pdo->query("SELECT id, tahun_ajaran FROM periode ORDER BY id ASC");
    $periods = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Filter Periode
    $filter_periode = $_GET['filter_periode'] ?? null;

    // Query kelas berdasarkan periode
    $query = "
        SELECT k.id, k.kelas_level, k.kelas_type, k.guru_id, g.nama AS guru_wali, p.tahun_ajaran
        FROM kelas k
        LEFT JOIN guru g ON k.guru_id = g.id
        LEFT JOIN periode p ON k.periode_id = p.id
    ";
    if ($filter_periode) {
        $query .= " WHERE k.periode_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$filter_periode]);
    } else {
        $stmt = $pdo->query($query);
    }
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tambah kelas
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
        $kelas_level = $_POST['kelas_level'];
        $kelas_type = $_POST['kelas_type'];
        $periode_id = $_POST['periode_id'];

        if (!$periode_id) {
            $error = "Periode belum dipilih.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO kelas (kelas_level, kelas_type, periode_id) VALUES (?, ?, ?)");
            if ($stmt->execute([$kelas_level, $kelas_type, $periode_id])) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?filter_periode=$periode_id&success=1");
                exit;
            } else {
                $error = "Gagal menambahkan kelas.";
            }
        }
    }

    // Hapus kelas
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM kelas WHERE id = ?");
        if ($stmt->execute([$delete_id])) {
            $success = "Kelas berhasil dihapus.";
        } else {
            $error = "Gagal menghapus kelas.";
        }
    }

    // Edit guru wali
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_guru_wali'])) {
        $kelas_id = $_POST['kelas_id'];
        $guru_id = $_POST['guru_id'];

        if ($kelas_id && $guru_id) {
            $stmt = $pdo->prepare("UPDATE kelas SET guru_id = ? WHERE id = ?");
            if ($stmt->execute([$guru_id, $kelas_id])) {
                $success = "Guru wali berhasil diperbarui.";
            } else {
                $error = "Gagal memperbarui guru wali.";
            }
        } else {
            $error = "Data tidak lengkap.";
        }
    }

} catch (Exception $e) {
    $error = "Terjadi kesalahan: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="admin_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php"><b>Admin Dashboard</b></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                    <li class="nav-item">
                            <a class="nav-link" href="admin_dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_period.php">
                                <i class="fas fa-calendar"></i> Manage Periods
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_teachers.php">
                                <i class="fas fa-users"></i> Manage Teachers
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_students.php">
                                <i class="fas fa-user-graduate"></i> Manage Students
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_subjects.php">
                                <i class="fas fa-book"></i> Manage Subjects
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Manage Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_classes.php">
                                <i class="fas fa-chalkboard"></i> Manage Classes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manajemen Kelas</h1>
            </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <!-- Dropdown Filter Periode -->
        <form method="GET" class="mb-3">
            <label for="filter_periode" class="form-label">Filter Periode</label>
            <select name="filter_periode" class="form-select" onchange="this.form.submit()">
                <option value="" disabled selected>Pilih Periode</option>
                <?php foreach ($periods as $period): ?>
                    <option value="<?= $period['id'] ?>" <?= $filter_periode == $period['id'] ? 'selected' : '' ?>>
                        <?= $period['tahun_ajaran'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Tabel Kelas -->
        <h3>Daftar Kelas</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Guru Wali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($classes)): ?>
                        <?php foreach ($classes as $index => $class): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $class['kelas_level'] ?> <?= $class['kelas_type'] ?></td>
                                <td><?= $class['guru_wali'] ?? 'Belum Ditentukan' ?></td>
                                <td>
                                    <a href="?delete_id=<?= $class['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kelas ini?')">Hapus</a>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editWaliModal<?= $class['id'] ?>">Edit</button>
                                    <a href="view_students.php?class_id=<?= $class['id'] ?>" class="btn btn-info btn-sm">View Students</a>
                                </td>
                            </tr>

                            <!-- Modal Edit Guru Wali -->
                            <div class="modal fade" id="editWaliModal<?= $class['id'] ?>" tabindex="-1" aria-labelledby="editWaliModalLabel<?= $class['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="<?= $_SERVER['PHP_SELF'] . '?filter_periode=' . $filter_periode ?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editWaliModalLabel<?= $class['id'] ?>">Edit Guru Wali</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="kelas_id" value="<?= $class['id'] ?>">
                                                <div class="mb-3">
                                                    <label for="guru_id" class="form-label">Guru Wali</label>
                                                    <select name="guru_id" class="form-select" required>
                                                        <option value="" disabled selected>Pilih Guru Wali</option>
                                                        <?php
                                                        $guruStmt = $pdo->prepare("SELECT id, nama FROM guru WHERE role = 'guru_wali' AND periode_id = ?");
                                                        $guruStmt->execute([$filter_periode]);
                                                        $gurus = $guruStmt->fetchAll(PDO::FETCH_ASSOC);
                                                        ?>
                                                        <?php foreach ($gurus as $guru): ?>
                                                            <option value="<?= $guru['id'] ?>" <?= $class['guru_id'] == $guru['id'] ? 'selected' : '' ?>>
                                                                <?= $guru['nama'] ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" name="edit_guru_wali" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Tidak ada kelas untuk periode ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addClassModal">
            Tambah Kelas
        </button>

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClassModalLabel">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Input Hidden untuk Periode ID -->
                        <input type="hidden" name="periode_id" value="<?= $filter_periode ?>" required>

                        <div class="mb-3">
                            <label for="kelas_level" class="form-label">Tingkatan</label>
                            <select name="kelas_level" class="form-select" required>
                                <option value="" disabled selected>Pilih Tingkatan</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_type" class="form-label">Jurusan</label>
                            <select name="kelas_type" class="form-select" required>
                                <option value="" disabled selected>Pilih Jurusan</option>
                                <option value="IPA">IPA</option>
                                <option value="IPS">IPS</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" name="add_class" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
