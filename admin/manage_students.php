<?php
include '../includes/db.php'; 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

// Ambil daftar periode
$stmtPeriode = $pdo->query("SELECT id, tahun_ajaran AS nama_periode FROM periode ORDER BY id ASC");
$periodeList = $stmtPeriode->fetchAll(PDO::FETCH_ASSOC);

// Ambil siswa berdasarkan periode
$selectedPeriode = $_GET['periode'] ?? null;
if ($selectedPeriode) {
    $stmtSiswa = $pdo->prepare("SELECT siswa.*, periode.tahun_ajaran AS nama_periode 
                                FROM siswa 
                                JOIN periode ON siswa.periode_id = periode.id 
                                WHERE siswa.periode_id = ?");
    $stmtSiswa->execute([$selectedPeriode]);
} else {
    $stmtSiswa = $pdo->query("SELECT siswa.*, periode.tahun_ajaran AS nama_periode 
                              FROM siswa 
                              JOIN periode ON siswa.periode_id = periode.id");
}
$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

// Tambah siswa baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $periode_id = $selectedPeriode;

    $stmtInsert = $pdo->prepare("INSERT INTO siswa (nama, telepon, email, alamat, jenis_kelamin, agama, tanggal_lahir, password, periode_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtInsert->execute([$nama, $telepon, $email, $alamat, $jenis_kelamin, $agama, $tanggal_lahir, $password, $periode_id]);

    header("Location: manage_students.php?periode=$periode_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php"><b>Admin Dashboard</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                            <a class="nav-link active" href="manage_students.php">
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
                            <a class="nav-link" href="manage_classes.php">
                                <i class="fas fa-chalkboard"></i> Manage Classes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Siswa</h1>
                </div>

                <!-- Dropdown Pilihan Periode -->
                <form method="GET" class="mb-4">
                    <label for="periode" class="form-label">Pilih Periode:</label>
                    <select class="form-select" id="periode" name="periode" onchange="this.form.submit()">
                        <option value="">-- Pilih Periode --</option>
                        <?php foreach ($periodeList as $periode): ?>
                            <option value="<?= $periode['id'] ?>" <?= $selectedPeriode == $periode['id'] ? 'selected' : '' ?>>
                                <?= $periode['nama_periode'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <?php if ($selectedPeriode): ?>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">Tambah Siswa</button>
                <?php endif; ?>

                <!-- Tabel Daftar Siswa -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Tanggal Lahir</th>
                                <th>Status</th>
                                <th>Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siswaList as $siswa): ?>
                                <tr>
                                    <td><?= $siswa['id'] ?></td>
                                    <td><?= $siswa['nama'] ?></td>
                                    <td><?= $siswa['telepon'] ?></td>
                                    <td><?= $siswa['email'] ?></td>
                                    <td><?= $siswa['alamat'] ?></td>
                                    <td><?= $siswa['jenis_kelamin'] ?></td>
                                    <td><?= $siswa['agama'] ?></td>
                                    <td><?= $siswa['tanggal_lahir'] ?></td>
                                    <td>
                                        <?php if ($siswa['status'] === 'Aktif'): ?>
                                            <button class="btn btn-success btn-sm" disabled>Aktif</button>
                                        <?php else: ?>
                                            <?= $siswa['status'] ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStudentModal<?= $siswa['id'] ?>">Edit</button>

                                        <!-- Delete Button -->
                                        <a href="delete_student.php?id=<?= $siswa['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus siswa ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="update_student.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStudentModalLabel">Edit Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit-id">
                        
                        <div class="mb-3">
                            <label for="edit-nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="edit-telepon" name="telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="edit-alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="edit-jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" id="edit-agama" name="agama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit-tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Tambah Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama</label>
                            <input type="text" class="form-control" id="agama" name="agama" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
    const editButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.getAttribute('data-id');
            document.getElementById('edit-nama').value = button.getAttribute('data-nama');
            document.getElementById('edit-telepon').value = button.getAttribute('data-telepon');
            document.getElementById('edit-email').value = button.getAttribute('data-email');
            document.getElementById('edit-alamat').value = button.getAttribute('data-alamat');
            document.getElementById('edit-jenis_kelamin').value = button.getAttribute('data-jenis_kelamin');
            document.getElementById('edit-agama').value = button.getAttribute('data-agama');
            document.getElementById('edit-tanggal_lahir').value = button.getAttribute('data-tanggal_lahir');
        });
    });
</script>

</body>
</html>
