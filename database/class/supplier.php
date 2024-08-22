<?php
require_once __DIR__ . '/../koneksi.php';

class Supplier {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllSuppliers() {
        $sql = "SELECT * FROM supplier";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSupplierById($id_supplier) {
        $sql = "SELECT * FROM supplier WHERE id_supplier = :id_supplier";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_supplier' => $id_supplier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSupplier($nama_supplier, $alamat, $no_telpon, $email, $npwp) {
        $sql = "INSERT INTO supplier (nama_supplier, alamat, no_telpon, email, npwp) 
                VALUES (:nama_supplier, :alamat, :no_telpon, :email, :npwp)";
        $stmt = $this->pdo->prepare($sql);
    
        try {
            $stmt->execute([
                ':nama_supplier' => $nama_supplier,
                ':alamat'        => $alamat,
                ':no_telpon'     => $no_telpon,
                ':email'         => $email,
                ':npwp'          => $npwp,
            ]);
            return $this->pdo->lastInsertId(); // Mengembalikan ID Supplier yang baru ditambahkan
        } catch (PDOException $e) {
            throw new Exception("Gagal menambahkan Supplier: " . $e->getMessage());
        }
    }

    public function updateSupplier($id_supplier, $nama_supplier, $alamat, $no_telpon, $email, $npwp) {
        $sql = "UPDATE supplier 
                SET nama_supplier = :nama_supplier, alamat = :alamat, no_telpon = :no_telpon, email = :email, npwp = :npwp
                WHERE id_supplier = :id_supplier";
        $stmt = $this->pdo->prepare($sql);
    
        try {
            $stmt->execute([
                ':id_supplier' => $id_supplier,
                ':nama_supplier' => $nama_supplier,
                ':alamat' => $alamat,
                ':no_telpon' => $no_telpon,
                ':email' => $email,
                ':npwp' => $npwp
            ]);
        } catch (PDOException $e) {
            throw new Exception("Gagal mengupdate Supplier: " . $e->getMessage());
        }
    }

    public function deleteSupplier($id_supplier) {
        $sql = "DELETE FROM supplier WHERE id_supplier = :id_supplier";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([':id_supplier' => $id_supplier]);
        } catch (PDOException $e) {
            throw new Exception("Gagal menghapus Supplier: " . $e->getMessage());
        }
    }
}
