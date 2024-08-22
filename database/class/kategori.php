<?php  
require_once __DIR__ . '/../koneksi.php';

class Kategori {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($nama_kategori) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
            return $stmt->execute([$nama_kategori]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM kategori");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function update($id, $nama_kategori) {
        try {
            $stmt = $this->pdo->prepare("UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?");
            return $stmt->execute([$nama_kategori, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM kategori WHERE id_kategori = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function exists($nama_kategori) {
        try {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM kategori WHERE nama_kategori = ?");
            $stmt->execute([$nama_kategori]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
