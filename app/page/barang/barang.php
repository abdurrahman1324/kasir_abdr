<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/barang.php';

$pdo = Koneksi::connect();
$title = "Manajemen Barang";
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barang</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Barang</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content lg-12">
        <!-- Card -->
        <div class="card">      
            <div class="card-header">
                <a href="page/barang/add.php?add" class="btn btn-success">Tambah Barang</a>
                <button id="delete-selected" class="btn btn-danger">Hapus Terpilih</button>
                <button id="print-barcodes" class="btn btn-primary">Cetak Barcode</button>
            </div>
            <div class="card-body bg-light">
                <!-- Tabel Barang -->
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Gambar</th>
                            <th>Stok</th>
                            <th>Harga Jual</th>
                            <th>Harga Beli</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sql = "SELECT barang.id_barang, barang.nama_barang, barang.id_kategori, barang.gambar_barang, barang.stok, barang.harga_jual, barang.harga_beli, kategori.nama_kategori 
                                FROM barang 
                                JOIN kategori ON barang.id_kategori = kategori.id_kategori
                                ORDER BY barang.id_barang DESC";
                        $stmt = $pdo->query($sql);

                        if ($stmt) { 
                            $no = 1; 
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                        ?>
                        <tr>
                            <td><input type="checkbox" class="select-item" value="<?php echo htmlspecialchars($row['id_barang']); ?>"></td>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <span style="background-color: #28a745; color: white; padding: 3px 5px; border-radius: 3px;">
                                <?php
                                    echo 'BRNG-' . str_pad(htmlspecialchars($row['id_barang']), 6, '0', STR_PAD_LEFT);
                                ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                            <td>
                                <?php if (!empty($row['gambar_barang'])): ?>
                                    <img src="<?php echo '/kasir_abdr/app/page/barang/gambar_barang/' . htmlspecialchars($row['gambar_barang']); ?>" alt="Gambar Barang" style="width: 100px; height: auto;">
                                <?php else: ?>
                                    <p>Gambar tidak tersedia</p>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['stok']); ?></td>
                            <td><?php echo 'Rp ' . number_format((int) str_replace('.', '', $row['harga_jual']), 0, ',', '.') . ',-'; ?></td>
                            <td><?php echo 'Rp ' . number_format((int) str_replace('.', '', $row['harga_beli']), 0, ',', '.') . ',-'; ?></td>
                            <td>
                                <a href="page/barang/edit.php?edit=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                <a href="#" onclick="confirmDelete('<?php echo urlencode($row['id_barang']); ?>')" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        } else {
                            echo '<tr><td colspan="10">Gagal mengambil data barang.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            fetch('page/barang/delete.php', {
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
                    title: data.message || 'Data berhasil dihapus!',
                    icon: data.icon || 'success',
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
                    text: 'Tidak dapat menghapus data. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (status === 'updated') {
        Swal.fire({
            icon: 'success',
            title: 'Barang berhasil diubah!',
            text: 'Data barang telah diperbarui di dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('status');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (success === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Barang berhasil ditambahkan!',
            text: 'Data barang telah ditambahkan ke dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
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
            urlParams.delete('error');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }
});

// Handle select all checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const isChecked = this.checked;
    document.querySelectorAll('.select-item').forEach(checkbox => checkbox.checked = isChecked);
});

// Handle delete selected items
document.getElementById('delete-selected').addEventListener('click', function() {
    const selectedItems = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
    if (selectedItems.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Silakan pilih item yang ingin dihapus.',
            confirmButtonText: 'Oke'
        });
        return;
    }

    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data yang dipilih akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('page/barang/delete_all.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'ids': JSON.stringify(selectedItems)
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.message || 'Data berhasil dihapus!',
                    icon: data.icon || 'success',
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
                    text: 'Tidak dapat menghapus data. Silakan coba lagi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
});

// Handle print barcodes
document.getElementById('print-barcodes').addEventListener('click', function() {
    const selectedItems = Array.from(document.querySelectorAll('.select-item:checked')).map(cb => cb.value);
    if (selectedItems.length < 3) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Silakan pilih minimal 3 item untuk mencetak barcode.',
            confirmButtonText: 'Oke'
        });
        return;
    }

    window.open('page/barang/barcodes.php?' + new URLSearchParams({
        'ids': JSON.stringify(selectedItems)
    }), '_blank');
});
</script>
