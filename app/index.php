<?php
require_once '../database/koneksi.php';
require_once '../database/class/auth.php';

$pdo = Koneksi::connect();
$auth = Auth::getInstance($pdo);

// Cek apakah pengguna sudah login
if (!$auth->isLoggedIn()) {
    header('Location: /kasir_abdr/app/auth/login.php'); // Perbaiki path jika perlu
    exit();
}
$currentUser = $auth->getUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>TO _ KO</title>
</head>

<body>
    <div id="app">
        <?php include 'layout/header.php'; ?>
        <?php include 'layout/navbar.php'; ?>
        <?php include 'layout/sidebar.php'; ?>
        <div class="main-content">
            <section class="section">
                <?php
                $page = isset($_GET["page"]) ? $_GET["page"] : 'dashboard';
                switch ($page) {
                    case 'barang':
                        include('page/barang/barang.php'); 
                        break;
                    case 'dashboard':
                        include('page/dashboard/index.php');
                        break;
                    default:
                        include('page/dashboard/index.php');
                }
                ?>
            </section>
        </div>
        <?php include 'layout/footer.php'; ?>
    </div>
</body>

</html>
