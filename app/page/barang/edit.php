<?php
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();
$barang = new Barang();

// Cek apakah parameter `edit` ada di URL
if (isset($_GET['edit'])) {
    $id_barang = $_GET['edit'];
    
    // Ambil data barang berdasarkan ID
    $sql = "SELECT * FROM barang WHERE id_barang = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_barang]);
    $barangData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$barangData) {
        echo "Data tidak ditemukan.";
        exit;
    }

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_barang = $_POST['nama_barang'];
        $harga_barang = $_POST['harga_barang'];
        $jumlah_barang = $_POST['jumlah_barang'];
        $gambar_lama = $_POST['gambar_lama'];

        // Proses upload gambar
        $gambar_baru = $gambar_lama; // Default gambar lama

        if (!empty($_FILES['gambar_barang']['name'])) {
            $gambar_baru = $barang->uploadGambar($_FILES['gambar_barang']);
            // Hapus gambar lama jika ada
            $gambarPathLama = 'gambar_barang/' . $gambar_lama;
            if (file_exists($gambarPathLama)) {
                unlink($gambarPathLama);
            }
        }

        try {
            // Update data barang
            $barang->updateBarang($id_barang, $nama_barang, $gambar_baru, $harga_barang, $jumlah_barang);

            // Redirect ke halaman manajemen barang dengan status
            header('Location: barang.php?status=updated');
            exit;
        } catch (Exception $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }
} else {
    echo "ID barang tidak ditemukan.";
    exit;
}

// Set page title
$title = "Edit Barang";
include '../../layout/header.php';
?>

<!-- Sidebar -->
<?php include '../../layout/sidebar.php'; ?>

<div class="content-wrapper">
    <section class="content mt-3">
        <!-- Card -->
        <div class="card bg-primary">
            <div class="card-header">
                <h2>Edit Barang</h2>
            </div>
            <div class="card-body bg-light">
                <form action="edit.php?edit=<?php echo urlencode($id_barang); ?>" method="POST" class="mb-4" enctype="multipart/form-data">
                    <input type="hidden" name="gambar_lama" value="<?php echo htmlspecialchars($barangData['gambar_barang']); ?>">
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($barangData['nama_barang']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gambar_barang">Gambar  : </label>
                        <?php if (!empty($barangData['gambar_barang'])): ?>
                            <img src="gambar_barang/<?php echo htmlspecialchars($barangData['gambar_barang']); ?>" alt="image" style="width: 200px; height: auto;">
                        <?php endif; ?>
                        <input type="file" class="form-control" id="gambar_barang" name="gambar_barang">
                    </div>
                    <div class="form-group">
                        <label for="harga_barang">Harga Barang</label>
                        <input type="number" class="form-control" id="harga_barang" name="harga_barang" step="0.01" value="<?php echo htmlspecialchars($barangData['harga_barang']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_barang">Jumlah Barang</label>
                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" value="<?php echo htmlspecialchars($barangData['jumlah_barang']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
