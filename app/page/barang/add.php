<?php
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();
$barang = new Barang();
$barang->addBarang('Nama Barang', 'gambar.jpg', 10000, 50, 1);

// Set page title
$title = "Manajemen Barang";
include '../../layout/header.php';
?>

<!-- Sidebar -->
<?php include '../../layout/sidebar.php'; ?>

<!-- Konten Utama -->
<div class="content-wrapper">
    <section class="content">
        <div class="container mt-7">
            <!-- Card -->
            <div class="card bg-primary">
                <div class="card-body bg-light">
                    <!-- Form Tambah Barang -->
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
                        <button type="submit" name="add" class="btn btn-primary">Tambah Barang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
