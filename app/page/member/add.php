<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

require_once '../../../database/koneksi.php';
require_once '../../../database/class/member.php';

$member = new Member($pdo); 
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_member = htmlspecialchars(trim($_POST['kode_member']));
    $nama_member = htmlspecialchars(trim($_POST['nama_member']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $no_telpon = htmlspecialchars(trim($_POST['no_telpon']));

    if (empty($kode_member) || empty($nama_member) || empty($alamat) || empty($no_telpon)) {
        header('Location: /kasir_abdr/app/index.php?page=member&error=' . urlencode('Email tidak valid.'));
        exit;
    } else {
        try {
            $member->addMember($kode_member, $nama_member, $alamat, $no_telpon);
            header('Location: /kasir_abdr/app/index.php?page=member&success=true');
            exit;
        } catch (Exception $e) {
            eader('Location: /kasir_abdr/app/index.php?page=member&error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}

$title = "Tambah Member";
include '../../layout/header.php';
?>

<!-- Sidebar -->
<?php include '../../layout/sidebar.php'; ?>
<?php include '../../layout/navbar.php'; ?>
<!-- Konten Utama -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Form Tambah Member</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=member">Home</a></li>
              <li class="breadcrumb-item active">Add Member</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content mt-3">
        <div class="card">
            <div class="card-header">
                <h3>Tambahkan Member</h3>
            </div>
            <div class="card-body bg-light">
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                <form action="add.php" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="kode_member">Kode Member</label>
                        <input type="text" class="form-control" id="kode_member" name="kode_member" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_member">Nama Member</label>
                        <input type="text" class="form-control" id="nama_member" name="nama_member" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="no_telpon">No Telepon</label>
                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="add" class="btn btn-success">Tambah Member</button>
                        <a href="/kasir_abdr/app/index.php?page=member" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
