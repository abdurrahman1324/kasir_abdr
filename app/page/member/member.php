<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/member.php';

// Membuat objek Member
$member = new Member($pdo);
$members = $member->getAllMembers();

// Set page title
$title = "Manajemen Member";
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Member</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Member</li>
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
                <a href="page/member/add.php?" class="btn btn-success">Tambah Member</a>
            </div>
            <div class="card-body bg-light">
                <!-- Tabel Member -->
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Member</th>
                            <th>Nama Member</th>
                            <th>Alamat</th>
                            <th>No Telpon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($members) { 
                            $no = 1; 
                            foreach ($members as $member): 
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($member['kode_member']); ?></td>
                            <td><?php echo htmlspecialchars($member['nama_member']); ?></td>
                            <td><?php echo htmlspecialchars($member['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($member['no_telpon']); ?></td>
                            <td>
                                <a href="page/member/edit.php?edit=<?php echo urlencode($member['id_member']); ?>" class="btn btn-warning">Edit</a>
                                <a href="#" onclick="confirmDelete('<?php echo urlencode($member['id_member']); ?>')" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php 
                            endforeach; 
                        } else {
                            echo '<tr><td colspan="6">Gagal mengambil data member.</td></tr>';
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
            fetch('page/member/delete.php', {
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
            title: 'Member berhasil diubah!',
            text: 'Data Member telah diperbarui di dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('status');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (success === 'true') {
        Swal.fire({
            icon: 'success',
            title: 'Member berhasil ditambahkan!',
            text: 'Data Member telah ditambahkan ke dalam sistem.',
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('success');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }

    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal menambahkan Member!',
            text: decodeURIComponent(error),
            confirmButtonText: 'Oke'
        }).then(() => {
            urlParams.delete('error');
            window.history.replaceState({}, document.title, `${window.location.pathname}?${urlParams.toString()}`);
        });
    }
    const formEdit = document.getElementById('formEditMember');
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
                    $('#editMemberModal').modal('hide');
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
