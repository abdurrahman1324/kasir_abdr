<?php
session_start();
require_once '../../database/koneksi.php';


// Include konten dinamis berdasarkan menu yang dipilih
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard'; // default ke 'dashboard'
$pagePath = "/kasir_abdr/app/page/dashboard/$dashboard/index.php";

if (file_exists($pagePath)) {
    include $pagePath;
} else {
    echo "<p>Halaman tidak ditemukan.</p>";
}
?>
