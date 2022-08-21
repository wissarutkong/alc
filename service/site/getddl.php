<?php
header('Content-Type: application/json');
include_once '../authen.php';
require_once '../db/cons.php';

try {
    if ($_SESSION['AD_PERMISSION'] != 1) {
        $company_id = $_SESSION['AD_COMPANY'];
        $_sql = $conn->prepare("SELECT id , site_desc FROM site WHERE company_id = :company_id ORDER BY id ASC");
        $_sql->execute([
            "company_id" => (int)$company_id
        ]);
        $res  = $_sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        if (!empty($_POST['id'])) {
            $company_id = $_POST['id'];
            $_sql = $conn->prepare("SELECT
            s.id,
            s.site_desc
        FROM
            site s
        LEFT JOIN company c ON s.company_id = c.id
        WHERE s.company_id = :company_id
        ORDER BY
            id ASC");
            $_sql->execute([
                "company_id" => (int)$company_id
            ]);
            $res  = $_sql->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $_sql = $conn->prepare("SELECT
            s.id, 
                    CASE 
                            WHEN s.company_id is NOT NULL THEN CONCAT(c.company_desc,' => ',s.site_desc)
                            ELSE s.site_desc
                    END AS site_desc
        FROM
            site s
        LEFT JOIN company c ON s.company_id = c.id
        ORDER BY
            id ASC");
            $_sql->execute();
            $res  = $_sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} catch (Throwable $e) {
    http_response_code(404);
    echo json_encode($e->getMessage());
    exit();
}

if (count($res) > 0) {
    $html = '<option value="">---โปรดระบุ---</option>';
}else{
    $html = '<option value="">ไม่พบ Site</option>';
}

foreach ($res as $row) {
    $html .= '<option value="' . $row['id'] . '">' . $row['site_desc'] . '</option>';
}

http_response_code(200);
echo json_encode($html);
