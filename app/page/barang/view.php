<?php

$page = filter_input(INPUT_GET, 'act', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

switch ($page) {
    case 'create':
        include('add.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('delete.php');
        break;
    case 'delete_all':
        include('delete_all.php');
        break;
    default:
        include('barang.php');
}
