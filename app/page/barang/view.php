<?php
include "../database/class/barang.php";
include "../database/class/page.php";


$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {

        // Page User
    case 'create':
        include('add.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('delete.php');
        break;
    default:
        include('barang.php');
}
