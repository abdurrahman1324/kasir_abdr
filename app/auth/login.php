<?php
session_start();
require_once '../../database/koneksi.php';
require_once '../../database/class/auth.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /kasir_abdr/app/page/dashboard.php');
    exit;
}

$auth = new Auth($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($auth->login($username, $password)) {
        header('Location: /kasir_abdr/app/page/dashboard.php');
        exit;
    } else {
        $error = 'Login gagal, periksa kembali username dan password Anda.';
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AdminLTE 3 | Log in</title>
<link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<div class="login-logo">
  <a href="/kasir_abdr/assets/Admin LTE/index2.html"><b>Admin</b>LTE</a>
</div>
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form action="" method="post">
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
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>
      </div>
    </form>
    <?php if (isset($error)): ?>
      <p class="text-danger"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <p class="mb-1">
      <a href="#">I forgot my password</a>
    </p>
    <p class="mb-0">
      <a href="register.php" class="text-center">Register a new membership</a>
    </p>
  </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    // Check if 'register' parameter is present in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('register') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'You have been successfully registered. Please login to continue.',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            // Remove 'register' parameter from URL
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        });
    }

    // Check if 'logout' parameter is present in URL
    if (urlParams.get('logout') === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Logged Out',
            text: 'You have been successfully logged out.',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            // Remove 'logout' parameter from URL
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        });
    }
</script>
<script src="/kasir_abdr/assets/Admin LTE/plugins/jquery/jquery.min.js"></script>
<script src="/kasir_abdr/assets/Admin LTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/kasir_abdr/assets/Admin LTE/dist/js/adminlte.min.js"></script>
</body>
</html>
