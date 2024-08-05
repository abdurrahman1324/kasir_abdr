<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /kasir_abdr/app/auth/login.php');
    exit;
}

include("C:/laragon/www/kasir_abdr/app/layout/css.php");
include("C:/laragon/www/kasir_abdr/app/layout/header.php");
include("C:/laragon/www/kasir_abdr/app/layout/sidebar.php");
include("C:/laragon/www/kasir_abdr/app/layout/footer.php");
include("C:/laragon/www/kasir_abdr/app/layout/js.php"); 
?>
