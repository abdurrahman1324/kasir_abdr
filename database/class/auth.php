<?php
class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }


    public function login($username, $password) {
        // Ganti dengan logika validasi pengguna dari database
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
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
}
?>
