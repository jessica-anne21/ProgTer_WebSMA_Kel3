<?php include('header.php'); ?>

<div class="d-flex flex-column min-vh-100">

    <!-- Bagian Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #001f3f;">
        <a class="navbar-brand" id="navbar-atas" href="#"><b>School Management System</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
            </ul>
        </div>
    </nav>
    <!-- End Bagian Navbar -->

    <div class="flex-grow-1 d-flex align-items-center py-5" style="background: linear-gradient(135deg, #001f3f 40%, #f7f9fc 100%);">
        <div class="container my-4">
            <div class="row align-items-center">
                <!-- Welcome Text -->
                <div class="col-lg-6 my-auto text-white">
                    <h1 class="display-3 font-weight-bold animate-text">Selamat Datang!</h1>
                    <p class="lead py-lg-4">
                        Jelajahi portal informasi Sekolah SMA dengan layanan untuk Admin, Guru, dan Siswa.
                    </p>
                </div>

                <!-- Circular Buttons -->
                <div class="col-lg-6 d-flex justify-content-center mt-4 mt-lg-0">
                    <div class="text-center mx-3">
                        <!-- Admin Button -->
                        <a href="admin/login.php" class="btn btn-primary btn-circle shadow-lg">
                            <i class="fa fa-user-shield"></i><br>Admin
                        </a>
                    </div>
                    <div class="text-center mx-3">
                        <!-- Guru Button -->
                        <a href="guru/login.php" class="btn btn-success btn-circle shadow-lg">
                            <i class="fa fa-chalkboard-teacher"></i><br>Guru
                        </a>
                    </div>
                    <div class="text-center mx-3">
                        <!-- Siswa Button -->
                        <a href="siswa/login.php" class="btn btn-info btn-circle shadow-lg">
                            <i class="fa fa-user-graduate"></i><br>Siswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?> 

</div>

<style>
    .btn {
        margin: 0;
    }
    
    .btn-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-transform: capitalize;
    }

    .btn-circle i {
        font-size: 1.8rem;
    }

    .btn-circle:hover {
        transform: scale(1.15);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    }

    .animate-text {
        animation: fadeInUp 1.2s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .navbar-brand {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 0.05rem;
    }

    .btn-outline-light {
        border: 2px solid #fff;
        color: #fff;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-outline-light:hover {
        background-color: #fff;
        color: #001f3f;
    }
</style>
