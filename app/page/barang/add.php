<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

require_once '../../../database/koneksi.php';
require_once '../../../database/class/barang.php';

$barang = new Barang();
$error = '';
$success = '';

// Menghasilkan kode barang baru
$kode_barang = $barang->generateKodeBarang();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gunakan kode_barang yang dihasilkan dan jangan menimpanya dengan input
    $id_kategori = filter_var($_POST['id_kategori'], FILTER_VALIDATE_INT);
    $nama_barang = htmlspecialchars(trim($_POST['nama_barang']));
    $harga_jual = str_replace('.', '', $_POST['harga_jual']);
    $harga_jual = filter_var($harga_jual, FILTER_VALIDATE_FLOAT);
    $harga_beli = str_replace('.', '', $_POST['harga_beli']);
    $harga_beli = filter_var($harga_beli, FILTER_VALIDATE_FLOAT);
    $stok = filter_var($_POST['stok'], FILTER_VALIDATE_INT);

    if (isset($_FILES['gambar_barang']) && $_FILES['gambar_barang']['error'] === UPLOAD_ERR_OK) {
        try {
            $gambar_barang = $barang->uploadGambar($_FILES['gambar_barang']);
            $barang->addBarang($kode_barang, $id_kategori, $nama_barang, $gambar_barang, $harga_jual, $harga_beli, $stok);
            header('Location: /kasir_abdr/app/index.php?page=barang&success=true');
            exit;
        } catch (Exception $e) {
            header('Location: /kasir_abdr/app/index.php?page=barang&error=' . urlencode($e->getMessage()));
            exit;
        }
    } else {
        // Tangani kasus di mana file tidak diupload dengan benar
        $error = "Gagal mengupload gambar.";
    }
    
}

$title = "Tambah Barang";
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
            <h1 class="m-0">Form Tambah</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/kasir_abdr/app/index.php?page=barang&">Home</a></li>
              <li class="breadcrumb-item active">Add Barang</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content mt-3">
        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h3>Tambahkan Barang</h3>
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
                <form action="add.php" method="POST" class="mb-4" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?php echo htmlspecialchars($kode_barang); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            $sql = "SELECT * FROM kategori";
                            $stmt = $pdo->query($sql);

                            if ($stmt) {
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . htmlspecialchars($row['id_kategori']) . '">' . htmlspecialchars($row['nama_kategori']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gambar_barang">Gambar</label>
                        <input type="file" class="form-control" id="gambar_barang" name="gambar_barang" required>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="text" class="form-control" id="harga_beli" name="harga_beli" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" name="add" class="btn btn-success">Tambah Barang</button>
                        <a href="/kasir_abdr/app/index.php?page=barang" class="btn btn-warning">Batal</a>
                    </div>
                </form>
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
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include '../../layout/footer.php'; ?>
