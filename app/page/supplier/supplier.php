<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/supplier.php';

// Membuat objek Supplier
$supplier = new Supplier($pdo);
$suppliers = $supplier->getAllSuppliers();

// Set page title
$title = "Manajemen Supplier";
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Supplier</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Supplier</li>
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
                <a href="page/supplier/add.php?" class="btn btn-success">Tambah Supplier</a>
            </div>
            <div class="card-body bg-light">
                <!-- Tabel Supplier -->
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>Alamat</th>
                            <th>No Telpon</th>
                            <th>Email</th>
                            <th>NPWP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($suppliers) { 
                            $no = 1; 
                            foreach ($suppliers as $supplier): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($supplier['nama_supplier']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['no_telpon']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                            <td><?php echo htmlspecialchars($supplier['npwp']); ?></td>
                            <td>
                                <a href="page/supplier/edit.php?edit=<?php echo urlencode($supplier['id_supplier']); ?>" class="btn btn-warning">Edit</a>
                                <a href="#" onclick="confirmDelete('<?php echo urlencode($supplier['id_supplier']); ?>')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            endforeach; 
                        } else {
                            echo '<tr><td colspan="7">Gagal mengambil data supplier.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Script SweetAlert untuk konfirmasi penghapusan -->
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
            fetch('page/supplier/delete.php', {
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
            title: 'Supplier berhasil diubah!',
            text: 'Data supplier telah diperbarui di dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('status');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (success === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Supplier berhasil ditambahkan!',
            text: 'Data supplier telah ditambahkan ke dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('success');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan supplier!',
            text: decodeURIComponent(error),
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('error');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }
    const formEdit = document.getElementById('formEditSupplier');
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
                    $('#editSupplierModal').modal('hide');
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
});

</script>
