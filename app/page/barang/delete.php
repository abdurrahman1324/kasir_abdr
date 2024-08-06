<?php
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();

if (isset($_GET['delete'])) {
    $id_barang = $_GET['delete'];

    // Periksa apakah ID barang valid
    if (is_numeric($id_barang)) {
        // Menghapus gambar dari direktori jika diperlukan
        $stmt = $pdo->prepare("SELECT gambar_barang FROM barang WHERE id_barang = ?");
        $stmt->execute([$id_barang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $gambar = $row['gambar_barang'];
            $file_path = '/kasir_abdr/app/page/barang/gambar_barang/' . $gambar;
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar
            }
        }

        // Hapus data dari database
        $stmt = $pdo->prepare("DELETE FROM barang WHERE id_barang = ?");
        if ($stmt->execute([$id_barang])) {
            echo 'Barang berhasil dihapus!';
        } else {
            echo 'Gagal menghapus barang.';
        }
    } else {
        echo 'ID barang tidak valid.';
    }
} else {
    echo 'ID barang tidak ditemukan.';
}
?>
