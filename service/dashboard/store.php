<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    try {
        if(!empty($_GET['company_id'])){
            $company_id = $_GET['company_id'];
        }else{
            $company_id = $_SESSION['AD_COMPANY'];
        }

        $stmt = $conn->prepare("SELECT  s.id, s.site_desc FROM
devicelist d
INNER JOIN site s ON d.site_id = s.id
WHERE
site_id IS NOT NULL AND d.company_id = :company_id
GROUP BY
site_id
ORDER BY
site_id ASC");
        $stmt->execute([
            "company_id" => (int)$company_id
        ]);
        $res_data_site  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $mainlist = array();

        $stmt = $conn->prepare("SELECT id , device_desc , device_id , site_id FROM devicelist WHERE site_id is not NULL AND company_id = :company_id");
        $stmt->execute([
            "company_id" => (int)$company_id
        ]);
        $res_data  = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($res_data_site as $key => $val) {
            // echo $val['site_desc'];
            $key_main = 1;
            $temp = 1;
            $key_main = $key + 1;
            foreach ($res_data as $key_list => $val_list) {
                if ($val['id'] == $val_list['site_id']) {
                    $key_sub = $key_main . "." . $temp;
                    $mainlist[$key+1][$val['site_desc']][$key_list]['key'] = $key_sub;
                    $mainlist[$key+1][$val['site_desc']][$key_list]['device_id'] = $val_list['device_id'];
                    $mainlist[$key+1][$val['site_desc']][$key_list]['device_desc'] = $val_list['device_desc'];
                    $temp = $temp + 1;
                }
            }
        }

        $response = [
            'status' => true,
            'response' => $mainlist,
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
