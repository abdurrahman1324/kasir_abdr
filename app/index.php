<?php
session_start();
require_once '../database/koneksi.php';
require_once '../database/class/auth.php';

$pdo = Koneksi::connect();
$auth = Auth::getInstance($pdo);

// Cek apakah pengguna sudah login
if (!$auth->isLoggedIn()) {
    header('Location: /kasir_abdr/app/auth/login.php');
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
    <?php include 'layout/header.php'; ?>
</head>
<body>
    <div id="app">
        <?php include 'layout/navbar.php'; ?>
        <?php include 'layout/sidebar.php'; ?>
        <main class="main-content">
            <section class="section">
                <?php
                $allowedPages = ['kategori', 'barang', 'dashboard'];
                $page = isset($_GET["page"]) ? $_GET["page"] : 'dashboard';
                switch ($page) {
                    case 'kategori':
                        include('page/kategori/view.php'); 
                        break;
                    case 'barang':
                        include('page/barang/view.php'); 
                        break;
                    case 'supplier':
                        include('page/supplier/view.php'); 
                        break;
                    case 'member':
                        include('page/member/view.php'); 
                        break;
                    case 'cetak':
                        include('page/cetak/view.php'); 
                        break;
                    case 'dashboard':
                        include('page/dashboard/index.php');
                        break;
                    default:
                        include('page/dashboard/index.php');
                }
                ?>
            </section>
        </main>
        <?php include 'layout/footer.php'; ?>
    </div>

    <!-- Script untuk menginisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('table').DataTable(); // Menginisialisasi DataTables untuk semua tabel di halaman
        });
    </script>
</body>
</html>
