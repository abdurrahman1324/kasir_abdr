<?php
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

$barang = new Barang();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan sanitasi
    $nama_barang = filter_var($_POST['nama_barang'], FILTER_SANITIZE_STRING);
    $harga_barang = filter_var($_POST['harga_barang'], FILTER_VALIDATE_FLOAT);
    $jumlah_barang = filter_var($_POST['jumlah_barang'], FILTER_VALIDATE_INT);
    
    if ($harga_barang === false || $jumlah_barang === false) {
        header('Location: barang.php?error=' . urlencode('Harga atau jumlah tidak valid.'));
        exit;
    }
    
    // Proses upload gambar
    try {
        $gambar_barang = $barang->uploadGambar($_FILES['gambar_barang']);
        
        // Tambahkan barang ke database
        $barang->addBarang($nama_barang, $gambar_barang, $harga_barang, $jumlah_barang);
        
        // Redirect dengan parameter untuk SweetAlert
        header('Location: barang.php?success=true');
        exit;
    } catch (Exception $e) {
        // Redirect dengan pesan error
        header('Location: barang.php?error=' . urlencode($e->getMessage()));
        exit;
    }
}

// Set page title
$title = "Tambah Barang";
include '../../layout/header.php';
?>

<!-- Sidebar -->
<?php include '../../layout/sidebar.php'; ?>

<!-- Konten Utama -->
<div class="content-wrapper">
    <section class="content mt-3">
        <!-- Card -->
        <div class="card bg-primary">
            <div class="card-header">
                <h2>Tambahkan Barang</h2>
            </div>
            <div class="card-body bg-light">
                <form action="add.php" method="POST" class="mb-4" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar_barang">Gambar</label>
                        <input type="file" class="form-control" id="gambar_barang" name="gambar_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_barang">Harga Barang</label>
                        <input type="number" class="form-control" id="harga_barang" name="harga_barang" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_barang">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="add" class="btn btn-primary">Tambah Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
