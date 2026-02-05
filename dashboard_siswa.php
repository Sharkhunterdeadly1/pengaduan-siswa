<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];

$jumlah = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM pengaduan 
    WHERE id_user='$id_user'
");
$total = mysqli_fetch_assoc($jumlah);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card {
            transition: .3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,.15);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Sistem Pengaduan Siswa</span>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
  </div>
</nav>

<div class="container mt-4">
    <h3>Halo, <?= $_SESSION['nama'] ?? 'Siswa' ?></h3>
    <p class="text-muted">Silakan buat pengaduan atau cek riwayat kamu</p>

    <div class="row mt-4">

        <!-- Kartu Buat Pengaduan -->
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Buat Pengaduan</h5>
                    <p>Kirim keluhan atau laporan ke sekolah</p>
                    <a href="buat_pengaduan.php" class="btn btn-primary">
                        Buat Pengaduan
                    </a>
                </div>
            </div>
        </div>

        <!-- Kartu Riwayat -->
        <div class="col-md-6 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Riwayat Pengaduan</h5>
                    <p>Total Pengaduan Kamu</p>
                    <h2><?= $total['total'] ?></h2>
                    <a href="riwayat_pengaduan.php" class="btn btn-info">
                        Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
