<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn, "
    SELECT p.*, u.nama, k.nama_kategori
    FROM pengaduan p
    JOIN users u ON p.id_user = u.id
    JOIN kategori k ON p.id_kategori = k.id
    ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="mb-3">📋 Dashboard Admin</h3>
    <a href="logout.php" class="btn btn-danger btn-sm mb-3">Logout</a>

    <table class="table table-bordered table-hover bg-white">
        <tr class="table-dark">
            <th>No</th>
            <th>Siswa</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['nama_kategori'] ?></td>
            <td><?= $row['judul'] ?></td>
            <td>
                <span class="badge bg-<?= 
                    $row['status']=='selesai'?'success':
                    ($row['status']=='diproses'?'warning':'secondary')
                ?>">
                    <?= $row['status'] ?>
                </span>
            </td>
            <td>
                <a href="detail_admin.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">
                    Detail
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
