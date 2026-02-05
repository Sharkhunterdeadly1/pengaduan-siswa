<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "
    SELECT p.*, u.nama 
    FROM pengaduan p 
    JOIN users u ON p.id_user=u.id
    WHERE p.id='$id'
");
$p = mysqli_fetch_assoc($data);

if (isset($_POST['kirim'])) {
    $tanggapan = $_POST['tanggapan'];
    $status = $_POST['status'];
    $id_admin = $_SESSION['id'];

    mysqli_query($conn, "
        INSERT INTO tanggapan (id_pengaduan, id_admin, tanggapan)
        VALUES ('$id', '$id_admin', '$tanggapan')
    ");

    mysqli_query($conn, "
        UPDATE pengaduan SET status='$status' WHERE id='$id'
    ");

    header("Location: dashboard_admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Detail Pengaduan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">

<h4>Detail Pengaduan</h4>
<p><b>Siswa:</b> <?= $p['nama'] ?></p>
<p><b>Judul:</b> <?= $p['judul'] ?></p>
<p><b>Isi:</b><br><?= nl2br($p['isi']) ?></p>

<form method="post">
    <div class="mb-2">
        <label>Status</label>
        <select name="status" class="form-select">
            <option value="menunggu">Menunggu</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
        </select>
    </div>

    <div class="mb-2">
        <label>Tanggapan Admin</label>
        <textarea name="tanggapan" class="form-control" required></textarea>
    </div>

    <button name="kirim" class="btn btn-success">Kirim Tanggapan</button>
    <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
</form>

</div>
</body>
</html>
