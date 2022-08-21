<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $company_id = $_GET['company_id'];
    try {
        if (!empty($company_id)) {
            $stmt = $conn->prepare("SELECT
        d.id, d.device_desc , d.device_id , d.serial , s.series_desc , c.company_desc , st.site_desc , d.created_by , d.created_date 
    FROM
        devicelist d
    INNER JOIN company c ON d.company_id = c.id
    INNER JOIN series s ON d.series_id = s.id
    LEFT OUTER JOIN site st ON d.site_id = st.id
    WHERE d.company_id = :company_id
    ORDER BY
        d.id ASC");
            $stmt->execute([
                "company_id" => (int)$company_id,
            ]);
        } else {
            $stmt = $conn->prepare("SELECT
        d.id, d.device_desc , d.device_id , d.serial , s.series_desc , c.company_desc , st.site_desc , d.created_by , d.created_date 
    FROM
        devicelist d
    INNER JOIN company c ON d.company_id = c.id
    INNER JOIN series s ON d.series_id = s.id
    LEFT OUTER JOIN site st ON d.site_id = st.id
    ORDER BY
        d.id ASC");
            $stmt->execute();
        }


        $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = [
            'status' => true,
            'response' => $res_data,
            'message' => 'Get Data Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    } catch (Throwable $e) {
        http_response_code(404);
        echo json_encode($e->getMessage());
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}
