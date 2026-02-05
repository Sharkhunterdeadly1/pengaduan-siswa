<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori_pengaduan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Buat Pengaduan</h3>
    <a href="dashboard_siswa.php" class="btn btn-secondary btn-sm mb-3">Kembali</a>

    <form method="post" action="proses_pengaduan.php">
        <div class="mb-3">
            <label>Kategori</label>
            <select name="id_kategori" class="form-control" required>
                <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
                    <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required minlength="5">
        </div>

        <div class="mb-3">
            <label>Isi Pengaduan</label>
            <textarea name="isi" class="form-control" required minlength="10"></textarea>
        </div>

        <button class="btn btn-primary">Kirim Pengaduan</button>
    </form>
</div>

</body>
</html>
