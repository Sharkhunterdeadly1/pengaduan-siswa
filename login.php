<?php
session_start();
include 'koneksi.php';

// JIKA SUDAH LOGIN
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_siswa.php");
    }
    exit;
}

// PROSES LOGIN
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['id']    = $user['id'];
        $_SESSION['nama']  = $user['nama'];
        $_SESSION['role']  = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: dashboard_admin.php");
        } else {
            header("Location: dashboard_siswa.php");
        }
        exit;

    } else {
        $error = "Email atau password salah";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Sistem Pengaduan Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 15px;
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

<div class="col-md-4">
    <div class="card login-card shadow">
        <div class="card-body p-4">

            <h3 class="text-center mb-3">🔐 Login</h3>
            <p class="text-center text-muted">Sistem Pengaduan Siswa</p>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php } ?>

            <form method="post">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <span class="input-group-text" onclick="togglePassword()" 
                              style="cursor:pointer;" id="eye">👁️</span>
                    </div>
                </div>

                <button name="login" class="btn btn-primary w-100 mt-2">
                    Login
                </button>
            </form>

            <hr>
            <p class="text-center text-muted small">
                © <?= date('Y') ?> Sistem Pengaduan Siswa
            </p>

        </div>
    </div>
</div>

<script>
function togglePassword() {
    const pwd = document.getElementById("password");
    const eye = document.getElementById("eye");

    if (pwd.type === "password") {
        pwd.type = "text";
        eye.innerHTML = "🙈";
    } else {
        pwd.type = "password";
        eye.innerHTML = "👁️";
    }
}
</script>

</body>
</html>
