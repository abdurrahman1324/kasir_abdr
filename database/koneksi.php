<?php
class Koneksi {
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo === null) {
            $host = 'localhost';
            $db = 'kasir';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
                // Uncomment the line below for debugging purposes only
                // echo "Koneksi berhasil";
            } catch (\PDOException $e) {
                // Log the error or handle it
                error_log("Koneksi gagal: " . $e->getMessage());
                throw new Exception("Koneksi gagal, silakan coba lagi nanti.");
            }
        }
        return self::$pdo;
    }
}

$pdo = Koneksi::connect();
?>
