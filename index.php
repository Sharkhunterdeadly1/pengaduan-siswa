<?php
session_start();

if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_siswa.php");
    }
} else {
    header("Location: login.php");
}
exit;
