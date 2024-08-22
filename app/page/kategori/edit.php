<?php
$activePage = 'kategori';
require_once '../../../database/koneksi.php';
require_once '../../../database/class/kategori.php';

$kategori = new Kategori($pdo);

$response = array('icon' => 'error', 'message' => 'Terjadi kesalahan!');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_kategori = isset($_POST['id_kategori']) ? trim($_POST['id_kategori']) : '';
    $nama_kategori = isset($_POST['nama_kategori']) ? trim($_POST['nama_kategori']) : '';

    if (!empty($id_kategori) && !empty($nama_kategori)) {
        try {
            // Cek apakah kategori dengan nama yang sama sudah ada (kecuali kategori yang sedang diedit)
            $sql = "SELECT COUNT(*) FROM kategori WHERE nama_kategori = :nama_kategori AND id_kategori != :id_kategori";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nama_kategori', $nama_kategori, PDO::PARAM_STR);
            $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $response = array('icon' => 'error', 'message' => 'Kategori dengan nama ini sudah ada.');
            } else {
                // Update kategori di database
                $sql = "UPDATE kategori SET nama_kategori = :nama_kategori WHERE id_kategori = :id_kategori";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nama_kategori', $nama_kategori, PDO::PARAM_STR);
                $stmt->bindParam(':id_kategori', $id_kategori, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    $response = array('icon' => 'success', 'message' => 'Kategori berhasil diperbarui!');
                } else {
                    $response['message'] = 'Gagal memperbarui kategori.';
                }
            }
        } catch (PDOException $e) {
            $response['message'] = 'Kesalahan: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Data tidak lengkap.';
    }

    echo json_encode($response);
}
