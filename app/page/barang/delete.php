<?php
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();

// Cek apakah koneksi berhasil
if (!$pdo) {
    $response = [
        'message' => 'Koneksi ke database gagal.',
        'icon' => 'error'
    ];
    echo json_encode($response);
    exit;
}

// Set header untuk JSON response
header('Content-Type: application/json');

$response = [
    'message' => 'Data berhasil dihapus.',
    'icon' => 'success'
];

if (isset($_POST['id'])) {
    $id_barang = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    // Periksa apakah ID barang valid
    if ($id_barang !== false) {
        // Menghapus gambar dari direktori jika diperlukan
        $stmt = $pdo->prepare("SELECT gambar_barang FROM barang WHERE id_barang = ?");
        $stmt->execute([$id_barang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $gambar = $row['gambar_barang'];
            $file_path = __DIR__ . '/gambar_barang/' . $gambar; // Gunakan __DIR__ untuk jalur relatif
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar
            }
        }

        // Hapus data dari database
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = ?");
        if ($stmt->execute([$id_barang])) {
            $response['message'] = 'Data berhasil dihapus!';
            $response['icon'] = 'success';
        } else {
            $response['message'] = 'Gagal menghapus data.';
            $response['icon'] = 'error';
        }
    } else {
        $response['message'] = 'ID barang tidak valid.';
        $response['icon'] = 'error';
    }
} else {
    $response['message'] = 'ID barang tidak ditemukan.';
    $response['icon'] = 'error';
}

echo json_encode($response);
