<?php
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-purple">
       <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button" style="color: white;"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link" style="color: white;">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link" style="color: white;">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- User Info with Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="/kasir_abdr/assets/admin_lte/dist/img/user2-160x160.jpg" class="img-circle elevation-2 mr-2" alt="User Image" style="width: 30px; height: 30px;">
            <?php echo htmlspecialchars($username); ?>
          </a>
          <div id="notificationCard" class="dropdown-menu">
            <a href="#" class="dropdown-item">
              <i class="fas fa-user"></i> Profil
            </a>
            <a href="#" class="dropdown-item" onclick="document.getElementById('logout-form').submit(); return false;">
              <i class="fas fa-sign-out-alt"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Logout form -->
    <form action="/kasir_abdr/app/auth/logout.php" method="post" id="logout-form" style="display: none;"></form>

  </div>

</body>
