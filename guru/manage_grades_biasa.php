<?php
session_start();
include('../includes/db.php');

$user = $_SESSION['user'];
$id_guru = $user['id'];

// Ambil daftar mata pelajaran yang diajarkan guru
$subjects_stmt = $pdo->prepare("SELECT id, nama FROM mata_pelajaran WHERE guru_pengajar = ?");
$subjects_stmt->execute([$id_guru]);
$subjects = $subjects_stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_subject_id = $_GET['filter_subject'] ?? null;

// Ambil daftar periode (tahun ajaran)
$periods_stmt = $pdo->prepare("SELECT id, tahun_ajaran FROM periode");
$periods_stmt->execute();
$periods = $periods_stmt->fetchAll(PDO::FETCH_ASSOC);

$selected_period_id = $_GET['filter_period'] ?? null;

// Filter mata pelajaran berdasarkan periode yang dipilih
if ($selected_period_id) {
    $subjects_stmt = $pdo->prepare("
        SELECT id, nama 
        FROM mata_pelajaran 
        WHERE guru_pengajar = ? AND periode_id = ?
    ");
    $subjects_stmt->execute([$id_guru, $selected_period_id]);
    $subjects = $subjects_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ambil daftar nilai jika periode dan mata pelajaran terpilih
$grades = [];
if ($selected_period_id && $selected_subject_id) {
    $grades_stmt = $pdo->prepare("
    SELECT DISTINCT s.id AS siswa_id, s.nama AS nama_siswa, 
           n.nilai_tugas AS nilai_tugas,
           n.nilai_uts AS nilai_uts, 
           n.nilai_uas AS nilai_uas, 
           n.id AS nilai_id
    FROM siswa s
    LEFT JOIN siswa_mapel smp ON s.id = smp.id_siswa AND smp.id_mata_pelajaran = ?
    LEFT JOIN nilai n ON s.id = n.id_siswa AND n.id_mata_pelajaran = ?
    WHERE smp.id_mata_pelajaran = ?
");

    $grades_stmt->execute([$selected_subject_id, $selected_subject_id, $selected_subject_id]);
    $grades = $grades_stmt->fetchAll(PDO::FETCH_ASSOC);
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_grade'])) {
    $id = $_POST['id'];
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];

    // Validasi nilai (server-side)
    if (
        ($nilai_tugas >= 0 && $nilai_tugas <= 100) &&
        ($nilai_uts >= 0 && $nilai_uts <= 100) &&
        ($nilai_uas >= 0 && $nilai_uas <= 100)
    ) {
        // Update nilai di database
        $stmt = $pdo->prepare("
            UPDATE nilai
            SET nilai_tugas = ?, nilai_uts = ?, nilai_uas = ?
            WHERE id = ?
        ");
        if ($stmt->execute([$nilai_tugas, $nilai_uts, $nilai_uas, $id])) {
            $message = "Nilai berhasil disimpan.";
        } else {
            $message = "Gagal menyimpan nilai. Silakan coba lagi.";
        }
    } else {
        $message = "Nilai harus berada dalam rentang 0-100.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="guru_style.css">
    <script>
        function editRow(id) {
            const inputs = document.querySelectorAll(`#row-${id} input`);
            inputs.forEach(input => {
                input.removeAttribute('readonly');
            });
            document.querySelector(`#row-${id} .btn-warning`).style.display = 'none';
            document.querySelector(`#row-${id} .btn-success`).style.display = 'inline-block';
        }

        function validateInput(input) {
            const value = parseInt(input.value);
            if (value < 0 || value > 100 || isNaN(value)) {
                alert("Nilai harus berada dalam rentang 0-100.");
                input.value = ""; 
                input.focus();
            }
            if (value >= 0 && value <= 100) {
                input.closest("form").submit();
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-navy">
        <div class="container-fluid">
            <a class="navbar-brand" href="guru_biasa_dashboard.php"><b>Dashboard Guru</b></a>
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
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="guru_biasa_dashboard.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="manage_grades_biasa.php">
                                <i class="fas fa-chart-line"></i> Manage Grades
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_schedule_biasa.php">
                                <i class="fas fa-calendar"></i> View Schedule
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manajemen Nilai</h1>
                </div>
                <?php if ($message): ?>
                    <div class="alert alert-info"> <?= $message ?> </div>
                <?php endif; ?>
                <form method="GET" class="mb-4">
                    <label for="filter_period" class="form-label">Pilih Periode (Tahun Ajaran)</label>
                    <select name="filter_period" id="filter_period" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Periode --</option>
                        <?php foreach ($periods as $period): ?>
                            <option value="<?= $period['id'] ?>" <?= $selected_period_id == $period['id'] ? 'selected' : '' ?>>
                                <?= $period['tahun_ajaran'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>

                <?php if ($selected_period_id): ?>
                <form method="GET" class="mb-4">
                    <input type="hidden" name="filter_period" value="<?= $selected_period_id ?>">
                    <label for="filter_subject" class="form-label">Pilih Mata Pelajaran</label>
                    <select name="filter_subject" id="filter_subject" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>" <?= $selected_subject_id == $subject['id'] ? 'selected' : '' ?>>
                                <?= $subject['nama'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                <?php endif; ?>

                <?php if ($selected_subject_id): ?>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Nilai Tugas</th>
                            <th>Nilai UTS</th>
                            <th>Nilai UAS</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($grades as $grade): ?>
                        <tr id="row-<?= $grade['nilai_id'] ?>">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $grade['nilai_id'] ?>">
                                <td><?= $grade['nama_siswa'] ?></td>
                                <td>
                                    <input type="number" class="form-control" name="nilai_tugas" value="<?= $grade['nilai_tugas'] ?>" min="0" max="100" readonly onblur="validateInput(this)">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="nilai_uts" value="<?= $grade['nilai_uts'] ?>" min="0" max="100" readonly onblur="validateInput(this)">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="nilai_uas" value="<?= $grade['nilai_uas'] ?>" min="0" max="100" readonly onblur="validateInput(this)">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" onclick="editRow(<?= $grade['nilai_id'] ?>)">Edit</button>
                                    <button type="submit" name="save_grade" class="btn btn-sm btn-success" style="display: none;">Simpan</button>
                                </td>
                            </form>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
