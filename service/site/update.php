<?php

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {
        $id = $_POST['id'];
        $site_desc = $_POST['site_desc'];
        $updated_by = $_SESSION['AD_NAME'];

        if (!empty($_POST['select_ddl_company'])) {
            $company_id = $_POST['select_ddl_company'];
            $conmand = $conn->prepare(" UPDATE site SET site_desc = :site_desc , company_id = :company_id, updated_by = :updated_by , updated_date = now() where id = :id");

            $conmand->execute([
                "id" => (int)$id,
                "company_id" => (int)$company_id,
                "site_desc" => (string)$site_desc,
                "updated_by" => (string)$updated_by,
            ]);
        } else {
            $conmand = $conn->prepare(" UPDATE site SET site_desc = :site_desc , updated_by = :updated_by 
            , updated_date = now() where id = :id");

            $conmand->execute([
                "id" => (int)$id,
                "site_desc" => (string)$site_desc,
                "updated_by" => (string)$updated_by,
            ]);
        }

        $response = [
            'status' => true,
            'message' => 'update site ' . $site_desc . ' success'
        ];
        http_response_code(200);
        echo json_encode($response);
    } catch (PDOException $exception) {
        echo json_encode($exception->getMessage());
        http_response_code(404);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}
