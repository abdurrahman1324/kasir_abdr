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
    public function updateBarang($id_barang, $nama_barang, $gambar_barang, $harga_barang, $jumlah_barang, $id_supplier) {
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
    
}
?>
