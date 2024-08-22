<?php
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/kasir_abdr/app/index.php?page=dashboard" class="brand-link">
        <img src="/kasir_abdr/assets/admin_lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><i>TO</i> _ <b>KO</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/kasir_abdr/assets/admin_lte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo htmlspecialchars($username); ?></a>
            </div>
        </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="/kasir_abdr/app/index.php?page=dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                </p>
                </a>
            </li>
            <!-- Management Menu -->
            <li class="nav-header">MASTER</li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=kategori" class="nav-link">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=barang" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=member" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Member</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=supplier" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Supplier</p>
                    </a>
                </li>
                <!-- Transactions -->
                <li class="nav-header">TRANSAKSI</li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=pengeluaran" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>Pengeluaran</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=pembelian" class="nav-link">
                        <i class="nav-icon fas fa-download"></i>
                        <p>Pembelian</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=transaksi_lama" class="nav-link">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>Transaksi Lama</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=transaksi_baru" class="nav-link">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>Transaksi Baru</p>
                    </a>
                </li>

                <!-- Report -->
                <li class="nav-item">
                    <a href="/kasir_abdr/app/index.php?page=laporan" class="nav-link">
                        <i class="fas fa-file-alt nav-icon"></i> <!-- Ganti dengan ikon yang sesuai -->
                        <p class="text">Laporan</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-header">SETTING</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Pengaturan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/kasir_abdr/app/auth/users.php" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p class="text">Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/kasir_abdr/app/auth/logout.php" class="nav-link">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <p class="text">Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>