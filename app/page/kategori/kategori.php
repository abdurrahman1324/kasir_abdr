<?php
$activePage = 'kategori';
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/kategori.php';


$kategori = new Kategori($pdo);

// Ambil semua kategori
$sql = "SELECT * FROM kategori";
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori</title>
    <!-- Tambahkan CSS dan JS sesuai kebutuhan -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="content-wrapper">
        <section class="content mt-2">
            <h2 style="margin-bottom: 20px;">Daftar Kategori</h2>
            <!-- Card -->
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addCategoryModal">Tambah Kategori</button>
                </div>
                <div class="card-body bg-light">
                    <!-- Tabel Kategori -->
                    <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($stmt): // Pastikan query berhasil
                                $no = 1;
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                                <td>
                                <button class="btn btn-warning btn-edit" data-id="<?php echo $row['id_kategori']; ?>"data-nama="<?php echo htmlspecialchars($row['nama_kategori']); ?>">Edit</button>
                                    <a href="#" onclick="confirmDelete('<?php echo urlencode($row['id_kategori']); ?>')" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile;
                            else: ?>
                            <tr><td colspan="3">Gagal mengambil data.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAddCategory" action="page/kategori/add.php" method="POST">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditCategory" action="page/kategori/edit.php" method="POST">
                        <input type="hidden" id="id_kategori" name="id_kategori">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori_edit" name="nama_kategori" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
            fetch('page/kategori/delete.php', {
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
                    timer: 2000
                });
                setTimeout(() => {
                    location.reload();
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
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi untuk menampilkan modal edit dengan data kategori
    function showEditModal(id, nama_kategori) {
        document.getElementById('id_kategori').value = id;
        document.getElementById('nama_kategori_edit').value = nama_kategori;
        $('#editCategoryModal').modal('show');
    }

    // Event listener untuk tombol edit
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const nama_kategori = this.dataset.nama;
            showEditModal(id, nama_kategori);
        });
    });

    // Menangani submit form tambah kategori
    const formAdd = document.getElementById('formAddCategory');
    formAdd.addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form melakukan submit secara default

        const formData = new FormData(formAdd);

        fetch(formAdd.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.icon,
                title: data.message,
                confirmButtonText: 'OK',
                timer: 2000
            }).then(() => {
                if (data.icon === 'success') {
                    $('#addCategoryModal').modal('hide');
                    location.reload();
                }
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan!',
                text: 'Gagal mengirim data ke server.',
                confirmButtonText: 'OK'
            });
        });
    });

    // Menangani submit form edit kategori
    const formEdit = document.getElementById('formEditCategory');
    formEdit.addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form melakukan submit secara default

        const formData = new FormData(formEdit);

        fetch(formEdit.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.icon,
                title: data.message,
                confirmButtonText: 'OK',
                timer: 2000
            }).then(() => {
                if (data.icon === 'success') {
                    $('#editCategoryModal').modal('hide');
                    location.reload();
                }
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan!',
                text: 'Gagal mengirim data ke server.',
                confirmButtonText: 'OK'
            });
        });
    });

    // Menampilkan notifikasi jika ada parameter status di URL
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const message = urlParams.get('message');

    if (success !== null) {
        Swal.fire({
            icon: success === 'true' ? 'success' : 'error',
            title: message,
            confirmButtonText: 'OK',
            timer: 2000
        });
    }
});

    </script>
</body>
</html>
