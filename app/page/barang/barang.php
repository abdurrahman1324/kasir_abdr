<?php 
require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();

// Set page title
$title = "Manajemen Barang";
include '../../layout/header.php';
?>

<!-- Sidebar -->
<?php include '../../layout/sidebar.php'; ?>

<!-- Konten Utama -->
<!-- Konten Utama -->
<div class="content-wrapper">
    <section class="content">

        <h2> Manajemen Barang</h2>
        <!-- Card -->
        <div class="card bg-primary">
            <div class="card-header">
                <a href="add.php" class="btn btn-light">Tambah Barang</a>
            </div>
            <div class="card-body bg-light">
                <!-- Tabel Barang -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Gambar</th>
                            <th>Harga Barang</th>
                            <th>Jumlah Barang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT * FROM barang";
                        $stmt = $pdo->query($sql);



                        if ($stmt) { // Pastikan query berhasil
                            $no = 1; 
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo htmlspecialchars($row['id_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td>
                                <img src="../gambar_barang/<?php echo htmlspecialchars($row['gambar_barang']); ?>" alt="image" style="width: 100px; height: auto;">
                            </td>
                            <td><?php echo htmlspecialchars($row['harga_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah_barang']); ?></td>
                            <td>
                                <a href="edit.php?edit=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?delete=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; 
                        } else {
                            echo '<tr><td colspan="8">Gagal mengambil data.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
