<?php
session_start();
require_once '../../database/koneksi.php';
require_once '../../database/class/auth.php';

$pdo = Koneksi::connect(); // Pastikan koneksi database sudah diinisialisasi
$auth = new Auth($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if ($auth->register($username, $password, $no_telpon, $alamat, $email, $role)) {
        // Redirect dengan parameter query string
        header('Location: login.php?register=success');
        exit;
    } else {
        $error = 'Registrasi gagal, coba lagi.';
        echo $error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Register</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../../assets/Admin LTE/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../assets/Admin LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/Admin LTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../assets/Admin LTE/index2.html" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>
        <form action="register.php" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="No Telpon" name="no_telpon" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-home"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="role" required>
              <option value="">Pilih Role</option>
              <option value="admin">Admin</option>
              <option value="SuperAdmin">SuperAdmin</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-tag"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>
        <p class="mt-3">
          <a href="index.php" class="text-center">I already have a membership</a>
        </p>
      </div>
    </div>
  </div>
</div>
<!-- jQuery -->
<script src="../../assets/Admin LTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../assets/Admin LTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/Admin LTE/dist/js/adminlte.min.js"></script>
</body>
</html>
