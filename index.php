<?php include('header.php'); ?>

<!-- Make sure the entire content fits the screen -->
<div class="d-flex flex-column min-vh-100">

    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #001f3f;"> <!-- Navy color -->
        <a class="navbar-brand" href="#"><b>School Management System</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
            aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
            <ul class="navbar-nav mr-auto">
            </ul>
        </div>
    </nav>
    <!--/.Navbar -->

    <!-- Hero Section with Gradient Background and Circular Buttons -->
    <div class="flex-grow-1 d-flex align-items-center py-5 shadow" style="background: linear-gradient(-45deg, #001f3f 50%, transparent 50%);">
        <div class="container-fluid my-2">
            <div class="row">
                <div class="col-lg-6 my-auto">
                    <h1 class="display-3 font-weight-bold text-dark">Web Manajemen SMA</h1>
                    <p class="py-lg-4 text-dark">
                        Selamat datang di portal sistem informasi Sekolah SMA.<br> 
                        Website ini menyediakan layanan bagi admin, guru, dan siswa.
                    </p>
                </div>

                <!-- Circular Buttons on the Right -->
                <div class="col-lg-6 d-flex justify-content-end align-items-center">
                    <div class="text-center mx-3">
                        <!-- Admin Button -->
                        <a href="admin/login.php" class="btn btn-primary btn-circle">
                            <i class="fa fa-user-shield"></i><br>Admin
                        </a>
                    </div>
                    <div class="text-center mx-3">
                        <!-- Guru Button -->
                        <a href="guru/login.php" class="btn btn-success btn-circle">
                            <i class="fa fa-chalkboard-teacher"></i><br>Guru
                        </a>
                    </div>
                    <div class="text-center mx-3">
                        <!-- Siswa Button -->
                        <a href="siswa/login.php" class="btn btn-info btn-circle">
                            <i class="fa fa-user-graduate"></i><br>Siswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?> <!-- Include the footer -->
</div>

<!-- Custom CSS for Circular Buttons -->
<style>
    .btn-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
        color: white;
    }
    .btn-circle i {
        font-size: 30px;
    }
</style>
