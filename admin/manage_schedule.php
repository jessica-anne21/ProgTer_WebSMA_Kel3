<?php
include '../includes/db.php'; 
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

$stmt = $pdo->query("SELECT * FROM periode");
$periods = $stmt->fetchAll(PDO::FETCH_ASSOC);

$schedules = [];
$periode_id = null;

if (isset($_POST['periode_id'])) {
    $periode_id = $_POST['periode_id'];
    $stmt = $pdo->prepare("SELECT jadwal.*, guru.nama AS guru_nama, mata_pelajaran.nama AS mata_pelajaran_nama 
                           FROM jadwal 
                           JOIN guru ON jadwal.id_guru = guru.id 
                           JOIN mata_pelajaran ON jadwal.id_mata_pelajaran = mata_pelajaran.id 
                           WHERE jadwal.periode_id = ?");
    $stmt->execute([$periode_id]);
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Jadwal</title>
    <link rel="stylesheet" href="admin_style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function submitPeriodForm() {
            document.getElementById('periodForm').submit();
        }
    </script>
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
                            <a class="nav-link active" href="manage_schedule.php">
                                <i class="fas fa-calendar"></i> Manage Schedule
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_classes.php">
                                <i class="fas fa-chalkboard"></i> Manage Classes
                            </a>
                        </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Jadwal</h1>
                </div>

                <!-- Period Dropdown -->
                <div class="card mb-4">
                    <div class="card-header">Pilih Periode</div>
                    <div class="card-body">
                        <form method="POST" id="periodForm" class="row g-3">
                            <div class="col-md-6">
                                <label for="periode_id" class="form-label">Periode</label>
                                <select class="form-select" name="periode_id" id="periode_id" onchange="submitPeriodForm()" required>
                                    <option value="" disabled selected>Pilih Periode</option>
                                    <?php foreach ($periods as $period): ?>
                                        <option value="<?= $period['id'] ?>" <?= ($period['id'] == $periode_id) ? 'selected' : '' ?>>
                                            <?= $period['tahun_ajaran'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Button Tambah Jadwal -->
                <div class="col-md-12 mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                        Tambah Jadwal
                    </button>
                </div>

                <!-- Tabel Jadwal -->
                <?php if (count($schedules) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Guru</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kelas</th>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Ruangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                    <?php
                    $no = 1;
                    foreach ($schedules as $schedule): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $schedule['guru_nama'] ?></td>
                            <td><?= $schedule['mata_pelajaran_nama'] ?></td>
                            <td><?= $schedule['kelas'] ?></td>
                            <td><?= $schedule['hari'] ?></td>
                            <td><?= $schedule['jam_mulai'] ?></td>
                            <td><?= $schedule['jam_selesai'] ?></td>
                            <td><?= $schedule['ruangan'] ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editScheduleModal<?= $schedule['id'] ?>">Edit</button>
                                
                                <!-- Delete Button -->
                                <a href="delete_schedule.php?id=<?= $schedule['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus jadwal ini?')">Hapus</a>
                            </td>
                        </tr>

                        <!-- Modal Edit Jadwal -->
                        <div class="modal fade" id="editScheduleModal<?= $schedule['id'] ?>" tabindex="-1" aria-labelledby="editScheduleModalLabel<?= $schedule['id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editScheduleModalLabel<?= $schedule['id'] ?>">Edit Jadwal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="edit_schedule.php">
                                            <div class="mb-3">
                                                <label for="guru_id" class="form-label">Guru</label>
                                                <select class="form-select" name="guru_id" required>
                                                    <option value="" disabled>Pilih Guru</option>
                                                    <?php
                                                    // Fetch data guru
                                                    $stmt = $pdo->query("SELECT * FROM guru");
                                                    $gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($gurus as $guru): ?>
                                                        <option value="<?= $guru['id'] ?>" <?= ($guru['id'] == $schedule['id_guru']) ? 'selected' : '' ?>><?= $guru['nama'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                                                <select class="form-select" name="mata_pelajaran_id" required>
                                                    <option value="" disabled>Pilih Mata Pelajaran</option>
                                                    <?php
                                                    // Fetch data mata pelajaran 
                                                    $stmt = $pdo->query("SELECT * FROM mata_pelajaran");
                                                    $mata_pelajaran = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($mata_pelajaran as $mp): ?>
                                                        <option value="<?= $mp['id'] ?>" <?= ($mp['id'] == $schedule['id_mata_pelajaran']) ? 'selected' : '' ?>><?= $mp['nama'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="kelas" class="form-label">Kelas</label>
                                                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $schedule['kelas'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="hari" class="form-label">Hari</label>
                                                <input type="text" class="form-control" id="hari" name="hari" value="<?= $schedule['hari'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="<?= $schedule['jam_mulai'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="<?= $schedule['jam_selesai'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ruangan" class="form-label">Ruangan</label>
                                                <input type="text" class="form-control" id="ruangan" name="ruangan" value="<?= $schedule['ruangan'] ?>" required>
                                            </div>

                                            <input type="hidden" name="schedule_id" value="<?= $schedule['id'] ?>">

                                            <button type="submit" class="btn btn-primary">Update Jadwal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>

                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Tidak ada jadwal untuk periode yang dipilih.</div>
                <?php endif; ?>

                <!-- Modal Add Jadwal -->
                <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="add_schedule.php">
                                    <!-- Field Guru -->
                                    <div class="mb-3">
                                        <label for="guru_id" class="form-label">Guru</label>
                                        <select class="form-select" name="guru_id" required>
                                            <option value="" disabled selected>Pilih Guru</option>
                                            <?php
                                            $stmt = $pdo->query("SELECT * FROM guru");
                                            $gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($gurus as $guru):
                                            ?>
                                                <option value="<?= $guru['id'] ?>"><?= $guru['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Field Mata Pelajaran -->
                                    <div class="mb-3">
                                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                                        <select class="form-select" name="mata_pelajaran_id" required>
                                            <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                            <?php
                                            $stmt = $pdo->query("SELECT * FROM mata_pelajaran");
                                            $mata_pelajaran = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($mata_pelajaran as $mp):
                                            ?>
                                                <option value="<?= $mp['id'] ?>"><?= $mp['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="hari" class="form-label">Hari</label>
                                        <input type="text" class="form-control" id="hari" name="hari" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                        <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                        <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ruangan" class="form-label">Ruangan</label>
                                        <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                                    </div>

                                    <input type="hidden" name="periode_id" value="<?= $periode_id ?>">

                                    <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
