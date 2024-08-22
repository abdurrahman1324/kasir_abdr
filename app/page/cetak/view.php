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
    default:
        include('barcodes.php');
}
