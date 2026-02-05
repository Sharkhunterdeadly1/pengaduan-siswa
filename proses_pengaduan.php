<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id']; // ⬅️ INI KUNCI
$id_kategori = $_POST['id_kategori'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];

if (empty($id_user)) {
    die("ERROR: ID user kosong");
}

mysqli_query($conn, "
    INSERT INTO pengaduan (id_user, id_kategori, judul, isi, status)
    VALUES ('$id_user', '$id_kategori', '$judul', '$isi', 'menunggu')
");

header("Location: dashboard_siswa.php");
exit;
