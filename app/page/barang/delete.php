<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();

// Set header untuk JSON response
header('Content-Type: application/json');

$response = [
    'message' => 'Metode tidak valid.',
    'icon' => 'error'
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id_barang > 0) {
        try {
            $pdo->beginTransaction();

            // Menghapus gambar dari direktori jika diperlukan
            $stmt = $pdo->prepare("SELECT gambar_barang FROM barang WHERE id_barang = ?");
            $stmt->execute([$id_barang]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $gambar = $row['gambar_barang'];
                $file_path = __DIR__ . '/gambar_barang/' . $gambar;
                if (file_exists($file_path)) {
                    unlink($file_path); // Hapus file gambar
                }
            }

            // Hapus data dari database
            $stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = ?");
            $stmt->execute([$id_barang]);

            $pdo->commit();
            $response = [
                'message' => 'Data berhasil dihapus!',
                'icon' => 'success'
            ];
        } catch (Exception $e) {
            $pdo->rollBack();
            $response = [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'icon' => 'error'
            ];
        }
    } else {
        $response = [
            'message' => 'ID barang tidak valid.',
            'icon' => 'error'
        ];
    }
} else {
    $response = [
        'message' => 'Metode tidak valid.',
        'icon' => 'error'
    ];
}
echo json_encode($response);
exit;

