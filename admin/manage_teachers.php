<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit();
}

$periode = $_POST['periode'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_teacher') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $periode = $_POST['periode_id'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($id) {
        $stmt = $pdo->prepare("UPDATE guru SET nama = ?, telepon = ?, email = ?, alamat = ?, password = ?, role = ?, periode_id = ? WHERE id = ?");
        $stmt->execute([$nama, $telepon, $email, $alamat, $hashedPassword, $role, $periode, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO guru (nama, telepon, email, alamat, password, role, periode_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama, $telepon, $email, $alamat, $hashedPassword, $role, $periode]);
    }
    header('Location: manage_teachers.php');
    exit();
}

// Proses penghapusan guru
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM guru WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_teachers.php');
    exit();
}

// Mengambil data guru berdasarkan periode
$teachers = [];
if ($periode) {
    $stmt = $pdo->prepare("
        SELECT guru.*, periode.tahun_ajaran nama_periode
        FROM guru
        JOIN periode ON guru.periode_id = periode.id
        WHERE periode_id = ?
    ");
    $stmt->execute([$periode]);
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Mengambil semua periode untuk dropdown
$periods = $pdo->query("
    SELECT id, tahun_ajaran AS nama_periode
    FROM periode
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Guru</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <link rel="stylesheet" href="admin_style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
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
                            <a class="nav-link active" href="manage_teachers.php">
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
                            <a class="nav-link" href="manage_classes.php">
                                <i class="fas fa-chalkboard"></i> Manage Classes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Guru</h1>
                </div>

                <!-- Dropdown Periode -->
                <form method="POST" class="mb-3">
                    <label for="periode" class="form-label">Pilih Periode:</label>
                    <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Periode --</option>
                        <?php foreach ($periods as $period): ?>
                            <option value="<?= $period['id'] ?>" <?= ($periode == $period['id']) ? 'selected' : '' ?>>
                                <?= $period['nama_periode'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <!-- Button Tambah Guru -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                    Tambah Guru
                </button>

                <!-- Tabel Guru -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($teachers)): ?>
                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <!-- Hyperlink pada Nama Guru -->
                                    <td>
                                        <a href="#" 
                                        class="teacher-details" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#teacherModal" 
                                        data-id="<?= $teacher['id'] ?>"
                                        data-nama="<?= $teacher['nama'] ?>"
                                        data-email="<?= $teacher['email'] ?>"
                                        data-alamat="<?= $teacher['alamat'] ?>"
                                        data-telepon="<?= $teacher['telepon'] ?>">
                                        <?= $teacher['nama'] ?>
                                        </a>
                                    </td>
                                    <td><?= ($teacher['role'] === 'guru_biasa') ? 'Guru Biasa' : 'Guru Wali' ?></td>
                                    <td>
                                        <a href="manage_teachers.php?delete=<?= $teacher['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        <button class="btn btn-warning btn-sm edit-teacher" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTeacherModal" 
                                                data-id="<?= $teacher['id'] ?>" 
                                                data-nama="<?= $teacher['nama'] ?>" 
                                                data-telepon="<?= $teacher['telepon'] ?>" 
                                                data-email="<?= $teacher['email'] ?>" 
                                                data-alamat="<?= $teacher['alamat'] ?>" 
                                                data-role="<?= $teacher['role'] ?>">Edit</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data guru untuk periode ini.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </main>

            <!-- Modal Tambah Guru -->
            <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTeacherModalLabel">Tambah Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="manage_teachers.php">
                            <input type="hidden" name="action" value="save_teacher">
                            <input type="hidden" name="periode_id" value="<?= $periode ?>">

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
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="guru_biasa">Guru Biasa</option>
                                        <option value="guru_wali">Guru Wali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Teacher Modal -->
            <div class="modal fade" id="editTeacherModal" tabindex="-1" aria-labelledby="editTeacherModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTeacherModalLabel">Edit Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="manage_teachers.php">
                            <input type="hidden" name="action" value="save_teacher">
                            <input type="hidden" name="id" id="edit-id">
                            <input type="hidden" name="periode_id" value="<?= $periode ?>">

                            <div class="modal-body">
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
                                    <label for="edit-role" class="form-label">Role</label>
                                    <select class="form-select" id="edit-role" name="role" required>
                                        <option value="guru_biasa">Guru Biasa</option>
                                        <option value="guru_wali">Guru Wali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal Detail Guru -->
            <div class="modal fade" id="teacherModal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="teacherModalLabel">Detail Guru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Id:</strong> <span id="modal-id"></span></p>
                            <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
                            <p><strong>Email:</strong> <span id="modal-email"></span></p>
                            <p><strong>Alamat:</strong> <span id="modal-alamat"></span></p>
                            <p><strong>Telepon:</strong> <span id="modal-telepon"></span></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                document.querySelectorAll('.teacher-details').forEach(item => {
                    item.addEventListener('click', event => {
                        const id = item.getAttribute('data-id');
                        const nama = item.getAttribute('data-nama');
                        const email = item.getAttribute('data-email');
                        const alamat = item.getAttribute('data-alamat');
                        const telepon = item.getAttribute('data-telepon');

                        document.getElementById('modal-id').textContent = id;
                        document.getElementById('modal-nama').textContent = nama;
                        document.getElementById('modal-email').textContent = email;
                        document.getElementById('modal-alamat').textContent = alamat;
                        document.getElementById('modal-telepon').textContent = telepon;
                    });
                });

                document.querySelectorAll('.edit-teacher').forEach(button => {
                    button.addEventListener('click', () => {
                        const id = button.getAttribute('data-id');
                        const nama = button.getAttribute('data-nama');
                        const telepon = button.getAttribute('data-telepon');
                        const email = button.getAttribute('data-email');
                        const alamat = button.getAttribute('data-alamat');
                        const role = button.getAttribute('data-role');

                        document.getElementById('edit-id').value = id;
                        document.getElementById('edit-nama').value = nama;
                        document.getElementById('edit-telepon').value = telepon;
                        document.getElementById('edit-email').value = email;
                        document.getElementById('edit-alamat').value = alamat;
                        document.getElementById('edit-role').value = role;
                    });
                });
            </script>
</body>
</html>

