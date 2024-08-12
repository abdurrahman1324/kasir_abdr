<?php
require_once 'C:/laragon/www/kasir_abdr/database/koneksi.php';

class Auth {
    private $pdo;
    private $error;
    private static $instance = null;

    // Constructor privat untuk mencegah instansiasi langsung
    private function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); // Mulai session jika belum dimulai
        }
    }

    public static function getInstance($pdo) {
        if (self::$instance === null) {
            self::$instance = new self($pdo);
        }
        return self::$instance;
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            $this->error = 'Username atau password salah';
            return false;
        }
    }

    public function register($username, $password, $no_telpon, $alamat, $email, $role) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, no_telpon, alamat, email, role) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $no_telpon, $alamat, $email, $role]);
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUser() {
        if ($this->isLoggedIn()) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch();
        }
        return null;
    }

    public function getError() {
        return $this->error;
    }
}
?>
