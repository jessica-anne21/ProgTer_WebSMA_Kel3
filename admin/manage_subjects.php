<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT id, tahun_ajaran AS nama FROM periode");
$stmt->execute();
$periods = $stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_period = $_GET['periode_id'] ?? null;

$stmt = $pdo->prepare("SELECT id, nama FROM guru");
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$subject = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM mata_pelajaran WHERE id = ?");
    $stmt->execute([$id]);
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = $_POST['nama'];
    $guru_pengajar = $_POST['guru_pengajar'];
    $periode_id = $_POST['periode_id'];

    if ($id) {
        // Update Mata Pelajaran
        $stmt = $pdo->prepare("UPDATE mata_pelajaran SET nama = ?, guru_pengajar = ?, periode_id = ? WHERE id = ?");
        $stmt->execute([$nama, $guru_pengajar, $periode_id, $id]);
    } else {
        // Tambah Mata Pelajaran
        $stmt = $pdo->prepare("INSERT INTO mata_pelajaran (nama, guru_pengajar, periode_id) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $guru_pengajar, $periode_id]);
    }
    header('Location: manage_subjects.php?periode_id=' . $periode_id);
    exit;
}

// Delete Mata Pelajaran
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM mata_pelajaran WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_subjects.php?periode_id=' . $selected_period);
    exit;
}

// Fetch Mata Pelajaran untuk Periode yang Dipilih
$subjects = [];
if ($selected_period) {
    $stmt = $pdo->prepare("SELECT mp.*, g.nama AS nama_guru FROM mata_pelajaran mp LEFT JOIN guru g ON mp.guru_pengajar = g.id WHERE mp.periode_id = ?");
    $stmt->execute([$selected_period]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Mata Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php"><b>Admin Dashboard</b></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Logout</a></li>
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
                            <a class="nav-link active" href="manage_subjects.php">
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
                    <h1 class="h2">Manajemen Mata Pelajaran</h1>
                </div>

                <!-- Pilih Periode -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-8">
                            <select name="periode_id" class="form-select" onchange="this.form.submit()">
                                <option value="" disabled selected>Pilih Periode</option>
                                <?php foreach ($periods as $period): ?>
                                    <option value="<?= $period['id'] ?>" <?= $selected_period == $period['id'] ? 'selected' : '' ?>>
                                        <?= $period['nama'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Button "Tambah Mata Pelajaran" -->
                <div class="mb-3">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subjectModal">
                        Tambah Mata Pelajaran
                    </button>
                </div>

                <?php if ($selected_period): ?>
                    <!-- Daftar Mata Pelajaran -->
                    <div class="card">
                        <div class="card-header">Daftar Mata Pelajaran</div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Guru</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($subjects as $subject): ?>
                                        <tr>
                                            <td><?= $subject['id'] ?></td>
                                            <td><?= $subject['nama'] ?></td>
                                            <td><?= $subject['nama_guru'] ?></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#subjectModal" data-id="<?= $subject['id'] ?>" data-nama="<?= $subject['nama'] ?>" data-guru="<?= $subject['guru_pengajar'] ?>">Edit</button>
                                                <a href="?delete=<?= $subject['id'] ?>&periode_id=<?= $selected_period ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</a>
                                                
                                                <button class="btn btn-success btn-sm enroll-btn" data-bs-toggle="modal" data-bs-target="#enrollModal" data-id="<?= $subject['id'] ?>">Enroll Students</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Silakan pilih periode terlebih dahulu.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>

    <!-- Modal untuk Enroll Siswa -->
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollModalLabel">Enroll Students in Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="enroll_students.php">
                        <input type="hidden" name="subject_id" id="subjectIdEnroll">
                        <input type="hidden" name="periode_id" value="<?= $selected_period ?>"> 
                        
                        <div class="mb-3">
                            <label class="form-label">Pilih Siswa</label><br>
                            <?php
                                $stmt = $pdo->prepare("SELECT id, nama FROM siswa");
                                $stmt->execute();
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($students as $student) {
                                    echo "
                                    <div class=\"form-check\">
                                        <input class=\"form-check-input\" type=\"checkbox\" name=\"student_id[]\" value=\"{$student['id']}\" id=\"student{$student['id']}\">
                                        <label class=\"form-check-label\" for=\"student{$student['id']}\">
                                            {$student['nama']}
                                        </label>
                                    </div>";
                                }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Enroll Students</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subjectModal" tabindex="-1" aria-labelledby="subjectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subjectModalLabel">Tambah Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="manage_subjects.php">
                        <input type="hidden" name="id" id="subjectId">
                        <div class="mb-3">
                            <label for="subjectName" class="form-label">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control" id="subjectName" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="subjectTeacher" class="form-label">Guru Pengajar</label>
                            <select class="form-select" id="subjectTeacher" name="guru_pengajar" required>
                                <option value="" disabled selected>Pilih Guru</option>
                                <?php foreach ($teachers as $teacher): ?>
                                    <option value="<?= $teacher['id'] ?>"><?= $teacher['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subjectPeriod" class="form-label">Periode</label>
                            <select class="form-select" name="periode_id" required>
                                <option value="" disabled selected>Pilih Periode</option>
                                <?php foreach ($periods as $period): ?>
                                    <option value="<?= $period['id'] ?>"><?= $period['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.enroll-btn').forEach(button => {
            button.addEventListener('click', function() {
                var subjectId = this.getAttribute('data-id');
                document.getElementById('subjectIdEnroll').value = subjectId;
            });
        });

        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; 
                if (button.getAttribute('data-id')) {
                    document.getElementById('subjectId').value = button.getAttribute('data-id');
                    document.getElementById('subjectName').value = button.getAttribute('data-nama');
                    document.getElementById('subjectTeacher').value = button.getAttribute('data-guru');
                }
            });
        });
    </script>
</body>
</html>
