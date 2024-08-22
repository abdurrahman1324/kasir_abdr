<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

require_once '../../../database/koneksi.php';
require_once '../../../database/class/supplier.php';

$supplier = new Supplier($pdo);
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_supplier = htmlspecialchars(trim($_POST['nama_supplier']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $no_telpon = htmlspecialchars(trim($_POST['no_telpon']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $npwp = htmlspecialchars(trim($_POST['npwp']));

    if (!$email) {
        header('Location: /kasir_abdr/app/index.php?page=supplier&error=' . urlencode('Email tidak valid.'));
        exit;
    } else {
        try {
            $supplier->addSupplier($nama_supplier, $alamat, $no_telpon, $email, $npwp);
            header('Location: /kasir_abdr/app/index.php?page=supplier&success=true');
            exit;
        } catch (Exception $e) {
            header('Location: /kasir_abdr/app/index.php?page=supplier&error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}

$title = "Tambah Supplier";
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
                    <h1 class="m-0">Form Tambah Supplier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=supplier">Home</a></li>
                        <li class="breadcrumb-item active">Add Supplier</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <section class="content mt-3">
        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h3>Tambahkan Supplier</h3>
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
                        <label for="nama_supplier">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telpon">No Telpon</label>
                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="add" class="btn btn-success">Tambah Supplier</button>
                        <a href="/kasir_abdr/app/index.php?page=supplier" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
