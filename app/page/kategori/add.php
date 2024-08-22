<?php
$activePage = 'kategori';
require_once '../../../database/koneksi.php';
require_once '../../../database/class/kategori.php';

$kategori = new Kategori($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'] ?? '';

    if (empty($nama_kategori)) {
        echo json_encode(['icon' => 'error', 'message' => 'Nama kategori tidak boleh kosong!']);
        exit;
    }

    // Periksa apakah kategori sudah ada
    if ($kategori->exists($nama_kategori)) {
        echo json_encode(['icon' => 'error', 'message' => 'Nama kategori sudah ada!']);
        exit;
    }

    if ($kategori->create($nama_kategori)) {
        echo json_encode(['icon' => 'success', 'message' => 'Kategori berhasil ditambahkan!']);
    } else {
        echo json_encode(['icon' => 'error', 'message' => 'Gagal menambahkan kategori!']);
    }
}
?>
