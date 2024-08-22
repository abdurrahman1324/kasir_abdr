<?php
require_once __DIR__ . '/../../../database/koneksi.php';
require_once __DIR__ . '/../../../database/class/supplier.php';

$member = new Member($pdo);
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_member = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id_member !== false) {
        try {
            $member->deleteMember($id_member);
            $response['success'] = true;
            $response['message'] = 'Data berhasil dihapus!';
        } catch (Exception $e) {
            $response['message'] = $e->getMessage();
        }
    } else {
        $response['message'] = 'ID tidak valid.';
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
