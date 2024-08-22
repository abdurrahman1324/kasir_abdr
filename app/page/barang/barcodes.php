<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/barang.php';
require_once __DIR__ . '/../../../assets/vendor/autoload.php'; // Autoload for Picqer and TCPDF

if (!class_exists('TCPDF')) {
    die('TCPDF class not found.');
}

use Picqer\Barcode\BarcodeGeneratorPNG;

// Buat objek PDF
$pdf = new TCPDF();
$pdo = Koneksi::connect();

// Ambil ID barang dari parameter URL
$ids = isset($_GET['ids']) ? json_decode($_GET['ids'], true) : [];

// Validasi ID barang
if (empty($ids) || !is_array($ids)) {
    die('Tidak ada barang yang dipilih untuk dicetak.');
}

// Ambil data barang dari database
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "SELECT id_barang, id_barang AS kode_barang, nama_barang, harga_jual FROM barang WHERE id_barang IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($ids);
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi Barcode Generator
$generator = new BarcodeGeneratorPNG();

// Mulai Output PDF
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 10);

$kolom = 3; // Jumlah kolom per baris
$lebarKolom = 70; // Lebar setiap kolom dalam mm (dilebarkan dari 60 menjadi 70)
$tinggiBaris = 50; // Tinggi setiap baris dalam mm
$spacing = 0; // Spacing between columns
$initialY = $pdf->GetY(); // Simpan posisi Y awal

foreach ($barang as $index => $item) {
    if ($index > 0 && $index % $kolom == 0) {
        $pdf->Ln($tinggiBaris); // Pindah ke baris baru setelah 3 kolom
        $initialY = $pdf->GetY();
    }

    // Posisi X untuk kolom saat ini
    $xPos = ($index % $kolom) * ($lebarKolom + $spacing);
    $yPos = $initialY;

    // Gambar kotak (card/container) putih
    $pdf->SetFillColor(255, 255, 255); // Putih
    $pdf->Rect($xPos + 5, $yPos + 5, $lebarKolom - 10, $tinggiBaris - 18, 'DF');

    // Tampilkan Nama Barang dan Harga di dalam kotak, di atas Barcode
    $pdf->SetXY($xPos + 10, $yPos + 10);
    $pdf->Cell($lebarKolom - 20, 5, $item['nama_barang'] . " - Rp. " . number_format($item['harga_jual']), 0, 1, 'C');

    // Generate Barcode
    $barcode = $generator->getBarcode('BRNG-' . str_pad($item['kode_barang'], 6, '0', STR_PAD_LEFT), $generator::TYPE_CODE_128);

    // Tambahkan Barcode ke dalam kotak
    $pdf->Image('@' . $barcode, $xPos + 5, $pdf->GetY() + 3, 60, 10, 'PNG'); // Lebar barcode diatur menjadi 60

    // Tampilkan Kode Barang di dalam kotak, di bawah Barcode
    $pdf->SetXY($xPos + 10, $pdf->GetY() + 13);
    $pdf->Cell($lebarKolom - 20, 5, 'BRNG-' . str_pad($item['kode_barang'], 6, '0', STR_PAD_LEFT), 0, 1, 'C');
}

// Output PDF
$pdf->Output('barcodes.pdf', 'I');
?>
