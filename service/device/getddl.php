<?php
header('Content-Type: application/json');
include_once '../authen.php';
require_once '../db/cons.php';

try {
    if (!empty($_POST['id'])) {
        $site_id = $_POST['id'];
        $_sql = $conn->prepare("SELECT id , device_desc FROM devicelist WHERE site_id = :site_id ORDER BY id asc");
        $_sql->execute([
            "site_id" => (int)$site_id
        ]);
        $res  = $_sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        http_response_code(404);
        echo json_encode($e->getMessage());
        exit();
    }
} catch (Throwable $e) {
    http_response_code(404);
    echo json_encode($e->getMessage());
    exit();
}

if (count($res) > 0) {
    $html = '<option value="">---โปรดระบุ---</option>';
} else {
    $html = '<option value="">ไม่พบอุปกรณ์</option>';
}

foreach ($res as $row) {
    $html .= '<option value="' . $row['id'] . '">' . $row['device_desc'] . '</option>';
}

http_response_code(200);
echo json_encode($html);
