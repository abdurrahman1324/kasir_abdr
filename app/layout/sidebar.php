 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
       <li class="nav-item menu-open">
         <a href="/kasir_abdr/app/index.php?page=dashboard" class="nav-link <?php echo $page == 'dashboard' ? 'active' : ''; ?>">
           <i class="nav-icon fas fa-tachometer-alt"></i>
           <p>
             Dashboard
           </p>
         </a>
       </li>
       <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
            Management
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="/kasir_abdr/app/index.php?page=barang" class="nav-link <?php echo $page == 'barang.php' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-inbox"></i>
                <p>Barang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/kasir_abdr/app/index.php?page=kasir" class="nav-link <?php echo $page == 'kasir' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-cash-register"></i>
                <p>Kasir</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/kasir_abdr/app/index.php?page=supplier" class="nav-link <?php echo $page == 'supplier' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-truck"></i>
                <p>Supplier</p>
            </a>
        </li>
    </ul>
</li>

       <li class="nav-header">USER</li>
       <li class="nav-item">
         <a href="#" class="nav-link">
           <i class="nav-icon fas fa-cog"></i>
           <p>
             Pengaturan
             <i class="fas fa-angle-left right"></i>
           </p>
         </a>
         <ul class="nav nav-treeview">
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