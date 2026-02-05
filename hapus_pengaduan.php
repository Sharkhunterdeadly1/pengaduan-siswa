<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard_admin.php");
    exit;
}

// CEK STATUS
$cek = mysqli_query($conn, "SELECT status FROM pengaduan WHERE id='$id'");
$data = mysqli_fetch_assoc($cek);

if ($data['status'] != 'selesai') {
    header("Location: dashboard_admin.php");
    exit;
}

// HAPUS TANGGAPAN
mysqli_query($conn, "DELETE FROM tanggapan WHERE id_pengaduan='$id'");

// HAPUS PENGADUAN
mysqli_query($conn, "DELETE FROM pengaduan WHERE id='$id'");

header("Location: dashboard_admin.php");
exit;
