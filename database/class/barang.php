<?php
require_once __DIR__ . '/../koneksi.php';

class Barang {
    private $pdo;

    public function __construct() {
        $this->pdo = Koneksi::connect();
    }

    public function uploadGambar($file) {
        $targetDir = "gambar_barang/";
        $targetFile = $targetDir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Validasi gambar
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File bukan gambar.");
        }
    
        // Validasi ukuran file
        if ($file["size"] > 5000000) { // 5MB
            throw new Exception("File terlalu besar.");
        }
    
        // Validasi format file
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            throw new Exception("Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.");
        }
    
        // Pindahkan file ke folder target
        if (!move_uploaded_file($file["tmp_name"], $targetFile)) {
            throw new Exception("Terjadi kesalahan saat mengupload file.");
        }
    
        return basename($file["name"]);
    }
    
    public function addBarang($kode_barang, $id_kategori, $nama_barang, $gambar_barang, $harga_jual, $harga_beli, $stok) {
        $sql = "INSERT INTO barang (kode_barang, id_kategori, nama_barang, gambar_barang, harga_jual, harga_beli, stok) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
    
        try {
            $stmt->execute([$kode_barang, $id_kategori, $nama_barang, $gambar_barang, $harga_jual, $harga_beli, $stok]);
            return $this->pdo->lastInsertId(); // Mengembalikan ID barang yang baru ditambahkan
        } catch (PDOException $e) {
            throw new Exception("Gagal menambahkan barang: " . $e->getMessage());
        }
    }
    

    public function updateBarang($id_barang, $id_kategori, $nama_barang, $gambar_barang, $harga_jual, $harga_beli, $stok) {
        $sql = "UPDATE barang 
                SET id_kategori = :id_kategori, nama_barang = :nama_barang, gambar_barang = :gambar_barang, harga_jual = :harga_jual, harga_beli = :harga_beli,  
                    stok = :stok
                WHERE id_barang = :id_barang";
        $stmt = $this->pdo->prepare($sql);
    
        try {
            $stmt->execute([
                ':id_kategori' => $id_kategori,
                ':id_barang' => $id_barang,
                ':nama_barang' => $nama_barang,
                ':gambar_barang' => $gambar_barang,
                ':harga_jual'  => $harga_jual, 
                ':harga_beli'  => $harga_beli,
                ':stok' => $stok
            ]);
        } catch (PDOException $e) {
            throw new Exception("Gagal mengupdate barang: " . $e->getMessage());
        }
    }
    
    public function deleteBarang($id_barang) {
        // Mengambil nama gambar sebelum menghapus data
        $stmt = $this->pdo->prepare("SELECT gambar_barang FROM barang WHERE id_barang = ?");
        $stmt->execute([$id_barang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $gambar = $row['gambar_barang'];
            $file_path = __DIR__ . '/../gambar_barang/' . $gambar;
            if (file_exists($file_path)) {
                unlink($file_path); // Hapus file gambar
            }
        }

        $sql = "DELETE FROM barang WHERE id_barang = :id_barang";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([':id_barang' => $id_barang]);
        } catch (PDOException $e) {
            throw new Exception("Gagal menghapus barang: " . $e->getMessage());
        }
    }

    public function generateKodeBarang() {
        $lastId = $this->getLastId();
        $nextId = $lastId + 1;
        return 'BRNG-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }
    
    private function getLastId() {
        $stmt = $this->pdo->query("SELECT MAX(id_barang) AS last_id FROM barang");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['last_id'] ?: 0;
    }
}
?>
