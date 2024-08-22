<?php
$activePage = 'kategori';
require_once '../../../database/koneksi.php';
require_once '../../../database/class/kategori.php';
$kategori = new Kategori($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(['icon' => 'error', 'message' => 'ID kategori tidak ditemukan!']);
        exit;
    }

    // Periksa apakah kategori ada
    if (!$kategori->getById($id)) {
        echo json_encode(['icon' => 'error', 'message' => 'Kategori tidak ditemukan!']);
        exit;
    }

    if ($kategori->delete($id)) {
        echo json_encode(['icon' => 'success', 'message' => 'Kategori berhasil dihapus!']);
    } else {
        echo json_encode(['icon' => 'error', 'message' => 'Gagal menghapus kategori!']);
    }
} else {
    echo json_encode(['icon' => 'error', 'message' => 'Metode request tidak valid!']);
}
?>