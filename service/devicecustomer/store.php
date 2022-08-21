<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if($_SERVER['REQUEST_METHOD'] === "GET"){
    $id = $_SESSION['AD_COMPANY'];
    $site_id = $_GET['site_id'];
    try{
        if( $_SESSION['AD_PERMISSION'] != 1 ){
            if(!empty($site_id)){
                $stmt = $conn->prepare("SELECT
                d.id, d.device_desc , d.device_id , d.serial , s.series_desc ,c.company_desc , st.site_desc , d.updated_by , d.updated_date
                FROM
                    devicelist d
                INNER JOIN company c ON d.company_id = c.id
                INNER JOIN series s ON d.series_id = s.id
                LEFT OUTER JOIN site st ON d.site_id = st.id
                WHERE d.company_id = :company_id and d.site_id = :site_id
                ORDER BY
                d.id ASC ") ;
                $stmt->execute([
                    "company_id" => (int)$id,
                    "site_id" => (int)$site_id,
                ]);
            }else{
                $stmt = $conn->prepare("SELECT
                d.id, d.device_desc , d.device_id , d.serial , s.series_desc ,c.company_desc , st.site_desc , d.updated_by , d.updated_date
                FROM
                    devicelist d
                INNER JOIN company c ON d.company_id = c.id
                INNER JOIN series s ON d.series_id = s.id
                LEFT OUTER JOIN site st ON d.site_id = st.id
                WHERE d.company_id = :company_id
                ORDER BY
                d.id ASC ") ;
                $stmt->execute([
                    "company_id" => (int)$id
                ]);
            }     
            $res_data = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
            if(!empty($site_id)){
                $stmt = $conn->prepare("SELECT
                d.id, d.device_desc , d.device_id , d.serial , s.series_desc , st.site_desc , d.updated_by , d.updated_date
                FROM
                    devicelist d
                INNER JOIN company c ON d.company_id = c.id
                INNER JOIN series s ON d.series_id = s.id
                LEFT OUTER JOIN site st ON d.site_id = st.id
                WHERE d.site_id = :site_id
                ORDER BY
                d.id ASC ") ;
                $stmt->execute([
                    "site_id" => (int)$site_id
                ]);
            }else{
                $stmt = $conn->prepare("SELECT
                d.id, d.device_desc , d.device_id , d.serial , s.series_desc , st.site_desc , d.updated_by , d.updated_date
                FROM
                    devicelist d
                INNER JOIN company c ON d.company_id = c.id
                INNER JOIN series s ON d.series_id = s.id
                LEFT OUTER JOIN site st ON d.site_id = st.id
                ORDER BY
                d.id ASC ") ;
                $stmt->execute();
            }

            $res_data = $stmt->fetchAll(PDO::FETCH_OBJ);
        }
     
        $response = [
            'status' => true,
            'response' => $res_data,
            'message' => 'Get Data Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    }catch(Throwable $e){
        http_response_code(404);
        echo json_encode( $e->getMessage());
        exit();
    }
}else{
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}




  







