<?php

require_once '../../../database/koneksi.php';
require_once '../../../database/class/supplier.php';

// Membuat objek Koneksi
$pdo = Koneksi::connect();
$supplier = new Supplier($pdo);

// Cek apakah parameter `edit` ada di URL
if (isset($_GET['edit'])) {
    $id_supplier = $_GET['edit'];
    
    // Ambil data supplier berdasarkan ID
    $supplierData = $supplier->getSupplierById($id_supplier);

    if (!$supplierData) {
        echo "Data tidak ditemukan.";
        exit;
    }

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_supplier = filter_var($_POST['nama_supplier'], FILTER_SANITIZE_STRING);
        $alamat = filter_var($_POST['alamat'], FILTER_SANITIZE_STRING);
        $no_telpon = filter_var($_POST['no_telpon'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $npwp = filter_var($_POST['npwp'], FILTER_SANITIZE_STRING);

        if ($nama_supplier && $alamat && $no_telpon && $email && $npwp) {
            try {
                // Update data supplier
                $supplier->updateSupplier($id_supplier, $nama_supplier, $alamat, $no_telpon, $email, $npwp);

                // Redirect ke halaman manajemen supplier dengan status
                header('Location: /kasir_abdr/app/index.php?page=supplier&status=updated');
                exit;
            } catch (Exception $e) {
                echo '<p>' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p>Data tidak valid.</p>';
        }
    }
} else {
    echo "ID supplier tidak ditemukan.";
    exit;
}

// Set page title
$title = "Edit Supplier";
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
                <h2>Edit Supplier</h2>
            </div>
            <div class="card-body bg-light">
                <form action="edit.php?edit=<?php echo urlencode($id_supplier); ?>" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="nama_supplier">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?php echo htmlspecialchars($supplierData['nama_supplier']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($supplierData['alamat']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telpon">No Telepon</label>
                        <input type="text" class="form-control" id="no_telpon" name="no_telpon" value="<?php echo htmlspecialchars($supplierData['no_telpon']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($supplierData['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="npwp">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" value="<?php echo htmlspecialchars($supplierData['npwp']); ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="/kasir_abdr/app/index.php?page=supplier" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
