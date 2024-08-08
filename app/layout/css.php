  <!-- Tambahkan CSS DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/kasir_abdr/assets/Admin LTE/plugins/summernote/summernote-bs4.min.css">
  <!-- Sweet Alert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <script>
    $(document).ready(function() {
        // Load konten awal jika halaman dimuat pertama kali
        $('#content-wrapper').load('/kasir_abdr/app/page/dashboard/index.php');

        // Tangani klik menu
        $('.nav-link').on('click', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');

            // Load konten dari pageUrl
            $('#content-wrapper').load(pageUrl);
        });
    });
</script>