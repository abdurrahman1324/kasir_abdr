<?php

class Member {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Fungsi untuk mengambil semua data member
    public function getAllMembers() {
        $stmt = $this->pdo->prepare("SELECT * FROM member");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk menambahkan member baru
  
    public function addMember($kode_member, $nama_member, $alamat, $no_telpon) {
        $sql = "INSERT INTO member (kode_member, nama_member, alamat, no_telpon) VALUES (:kode_member, :nama_member, :alamat, :no_telpon)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':kode_member' => $kode_member,
            ':nama_member' => $nama_member,
            ':alamat' => $alamat,
            ':no_telpon' => $no_telpon
        ]);
    }

    // Fungsi untuk menghapus member berdasarkan ID
    public function deleteMember($id_member) {
        $stmt = $this->pdo->prepare("DELETE FROM member WHERE id_member = ?");
        return $stmt->execute([$id_member]);
    }

    // Fungsi untuk mendapatkan data member berdasarkan ID
    public function getMemberById($id_member) {
        $stmt = $this->pdo->prepare("SELECT * FROM member WHERE id_member = ?");
        $stmt->execute([$id_member]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fungsi untuk mengupdate data member
    public function updateMember($id_member, $kode_member, $nama_member, $alamat, $no_telpon) {
        $stmt = $this->pdo->prepare("UPDATE member SET kode_member = ?, nama_member = ?, alamat = ?, no_telpon = ? WHERE id_member = ?");
        return $stmt->execute([$kode_member, $nama_member, $alamat, $no_telpon, $id_member]);
    }
}
