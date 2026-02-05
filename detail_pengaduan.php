<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$p = mysqli_query($conn, "
    SELECT pengaduan.*, users.nama
    FROM pengaduan
    JOIN users ON pengaduan.id_user = users.id
    WHERE pengaduan.id='$id'
");
$data = mysqli_fetch_assoc($p);

if (isset($_POST['kirim'])) {
    $status = $_POST['status'];
    $tanggapan = $_POST['tanggapan'];
    $id_admin = $_SESSION['id'];

    mysqli_query($conn, "
        UPDATE pengaduan SET status='$status' WHERE id='$id'
    ");

    mysqli_query($conn, "
        INSERT INTO tanggapan (id_pengaduan, id_admin, isi_tanggapan)
        VALUES ('$id', '$id_admin', '$tanggapan')
    ");

    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h4><?= $data['judul'] ?></h4>
            <p><b>Siswa:</b> <?= $data['nama'] ?></p>
            <p><?= $data['isi'] ?></p>

            <form method="post">
                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggapan</label>
                    <textarea name="tanggapan" class="form-control" required></textarea>
                </div>

                <button name="kirim" class="btn btn-primary">Simpan</button>
                <a href="admin.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
