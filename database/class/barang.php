<?php
require_once '../../../database/koneksi.php';

class Barang {
    private $pdo;

    public function __construct() {
        $this->pdo = Koneksi::connect();
    }

    // Menambahkan barang baru
    public function addBarang($nama_barang, $gambar_barang, $harga_barang, $jumlah_barang) {
        $sql = "INSERT INTO barang (nama_barang, gambar_barang, harga_barang, jumlah_barang) 
                VALUES (:nama_barang, :gambar_barang, :harga_barang, :jumlah_barang)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':nama_barang' => $nama_barang,
            ':gambar_barang' => $gambar_barang,
            ':harga_barang' => $harga_barang,
            ':jumlah_barang' => $jumlah_barang
        ]);
    }

    // Mengambil semua data barang
    public function getAllBarang() {
        $sql = "SELECT * FROM barang";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // Mengambil data barang berdasarkan ID
    public function getBarangById($id_barang) {
        $sql = "SELECT * FROM barang WHERE id_barang = :id_barang";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_barang' => $id_barang]);
        return $stmt->fetch();
    }

    // Mengupdate data barang
    public function updateBarang($id_barang, $nama_barang, $gambar_barang, $harga_barang, $jumlah_barang) {
        $sql = "UPDATE barang 
                SET nama_barang = :nama_barang, gambar_barang = :gambar_barang, harga_barang = :harga_barang, 
                    jumlah_barang = :jumlah_barang
                WHERE id_barang = :id_barang";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':id_barang' => $id_barang,
            ':nama_barang' => $nama_barang,
            ':gambar_barang' => $gambar_barang,
            ':harga_barang' => $harga_barang,
            ':jumlah_barang' => $jumlah_barang
        ]);
    }

    // Menghapus data barang
    public function deleteBarang($id_barang) {
        $sql = "DELETE FROM barang WHERE id_barang = :id_barang";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_barang' => $id_barang]);
    }

    // Mengupload gambar
    public function uploadGambar($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $file['tmp_name'];
            $fileName = basename($file['name']); // Menggunakan basename untuk menghindari nama file yang panjang atau path
            $uploadFileDir = 'gambar_barang/'; // Sesuaikan dengan jalur yang benar
            $dest_path = $uploadFileDir . $fileName;

            // Validasi file (contoh: hanya izinkan gambar jpg, jpeg, png)
            $fileSize = $file['size'];
            $fileType = mime_content_type($fileTmpPath);
            $allowedTypes = ['image/jpeg', 'image/png'];

            if (in_array($fileType, $allowedTypes) && $fileSize < 5 * 1024 * 1024) { // Maksimal 5MB
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    return $fileName;
                } else {
                    throw new Exception('Terjadi kesalahan saat mengupload gambar.');
                }
            } else {
                throw new Exception('File tidak valid atau terlalu besar.');
            }
        } else {
            throw new Exception('Gambar belum dipilih atau terdapat kesalahan.');
        }
    }
}
?>
