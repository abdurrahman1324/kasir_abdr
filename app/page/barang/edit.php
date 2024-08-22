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

    // Ambil data kategori untuk dropdown
    $kategoriSql = "SELECT * FROM kategori";
    $kategoriStmt = $pdo->prepare($kategoriSql);
    $kategoriStmt->execute();
    $kategoriList = $kategoriStmt->fetchAll(PDO::FETCH_ASSOC);

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_barang = filter_var($_POST['nama_barang'], FILTER_SANITIZE_STRING);
        $id_kategori = filter_var($_POST['id_kategori'], FILTER_VALIDATE_INT);
        $harga_jual = str_replace('.', '', $_POST['harga_jual']);
        $harga_jual = filter_var($harga_jual, FILTER_VALIDATE_FLOAT);
        $harga_beli = str_replace('.', '', $_POST['harga_beli']);
        $harga_beli = filter_var($harga_beli, FILTER_VALIDATE_FLOAT);
        $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);
        $gambar_lama = $_POST['gambar_lama'];

        // Proses upload gambar
        $gambar_baru = $gambar_lama; // Default gambar lama

        if (!empty($_FILES['gambar_barang']['name'])) {
            $gambar_baru = $barang->uploadGambar($_FILES['gambar_barang']);
            $gambarPathLama = 'gambar_barang/' . $gambar_lama;
            if (file_exists($gambarPathLama)) {
                unlink($gambarPathLama);
            }
        }

        if ($harga_jual !== false && $harga_beli !== false && $stok !== false && $id_kategori !== false) {
            try {
                // Update data barang
                $barang->updateBarang($id_barang, $id_kategori, $nama_barang, $gambar_baru, $harga_jual, $harga_beli, $stok);

                // Redirect ke halaman manajemen barang dengan status
                header('Location: /kasir_abdr/app/index.php?page=barang&status=updated');
                exit;
            } catch (Exception $e) {
                echo '<p>' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p>Data tidak valid.</p>';
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
<?php include '../../layout/navbar.php'; ?>

<div class="content-wrapper">
    <section class="content mt-3">
        <!-- Card -->
        <div class="card">
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
                        <label for="id_kategori">Nama Kategori</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            <?php foreach ($kategoriList as $kategori): ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>" <?php if ($kategori['id_kategori'] == $barangData['id_kategori']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gambar_barang">Gambar:</label>
                        <?php if (!empty($barangData['gambar_barang'])): ?>
                            <img src="gambar_barang/<?php echo htmlspecialchars($barangData['gambar_barang']); ?>" alt="image" style="width: 200px; height: auto;">
                        <?php endif; ?>
                        <input type="file" class="form-control" id="gambar_barang" name="gambar_barang">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($barangData['stok']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?php echo htmlspecialchars(number_format($barangData['harga_jual'], 0, '', '.')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli" value="<?php echo htmlspecialchars(number_format($barangData['harga_beli'], 0, '', '.')); ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="/kasir_abdr/app/index.php?page=barang" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>

<!-- JavaScript untuk Format Angka -->
<script>
    function formatNumberInput(input) {
        let value = input.value.replace(/\D/g, '');
        let formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        input.value = formattedValue;
    }

    document.getElementById('harga_jual').addEventListener('input', function() {
        formatNumberInput(this);
    });

    document.getElementById('harga_beli').addEventListener('input', function() {
        formatNumberInput(this);
    });
</script>
