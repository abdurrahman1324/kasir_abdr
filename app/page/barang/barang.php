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

<div class="content-wrapper">
    <section class="content lg-12">
        <h2>Manajemen Barang</h2>
        <!-- Card -->
        <div class="card bg-primary">
            <div class="card-header">
                <a href="add.php" class="btn btn-success">Tambah Barang</a>
            </div>
            <div class="card-body bg-light">
                <!-- Tabel Barang -->
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No</th>
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
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td>
                                <?php if (!empty($row['gambar_barang'])): ?>
                                    <img src="<?php echo 'http://localhost/kasir_abdr/app/page/barang/gambar_barang/' . htmlspecialchars($row['gambar_barang']); ?>" alt="image" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <p>Gambar tidak tersedia</p>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['harga_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['jumlah_barang']); ?></td>
                            <td>
                                <a href="edit.php?edit=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-warning">Edit</a>
                                <a href="#" onclick="confirmDelete('<?php echo urlencode($row['id_barang']); ?>')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; 
                        } else {
                            echo '<tr><td colspan="6">Gagal mengambil data.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data ini akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Lakukan AJAX request untuk menghapus data
            fetch('delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'id': id
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.message,
                    icon: data.icon,
                    confirmButtonText: 'OK',
                    timer: 2000 // Menampilkan selama 2 detik
                });
                setTimeout(() => {
                    location.reload(); // Refresh halaman setelah beberapa detik
                }, 2000);
            })
            .catch(error => {
                Swal.fire({
                    title: 'Terjadi kesalahan!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}

// Menampilkan SweetAlert pada halaman load jika ada parameter di URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Barang berhasil ditambahkan!',
            text: 'Data barang telah ditambahkan ke dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            // Menghapus parameter success setelah ditampilkan
            urlParams.delete('success');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan barang!',
            text: decodeURIComponent(error),
            confirmButtonText: 'Oke'
        }).then(() => {
            // Menghapus parameter error setelah ditampilkan
            urlParams.delete('error');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }
});
</script>


<!-- Footer -->
<?php 
include '../../layout/footer.php';
?>
