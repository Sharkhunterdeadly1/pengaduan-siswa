<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id'];
echo "ID SESSION USER = " . $_SESSION['id'];
exit;

$query = mysqli_query($conn, "
    SELECT pengaduan.*, tanggapan.isi_tanggapan
    FROM pengaduan
    LEFT JOIN tanggapan 
    ON pengaduan.id = tanggapan.id_pengaduan
    WHERE pengaduan.id_user = '$id_user'
    ORDER BY pengaduan.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card {
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Sistem Pengaduan Siswa</span>
    <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
