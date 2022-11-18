<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    try {

        $select_ddl_devices = $_GET['select_ddl_devices'];
        $date_search_from = $_GET['date_search'];
        $date_search_to = date("Y-m-d", strtotime($date_search_from . '+1 day'));
        $agg_type = $_GET['select_ddl_aggtype'];

        $stmt = $conn->prepare("SELECT * FROM devicelist WHERE id = :id ");
        $stmt->execute([
            "id" => $select_ddl_devices
        ]);
        $res  = $stmt->fetch(PDO::FETCH_OBJ);


        if ($agg_type == "15m") {
            $stmt = $conn->prepare("SELECT
            DATE(datetime) as date , TIME(datetime) as time , p_pressure_avg , p_flow_avg , p_flowacc_sum , p_volume_sum
        FROM_15
        WHERE
            data
            id_name = :id_name
        AND datetime BETWEEN '$date_search_from 08:00:00'
        AND '$date_search_to 08:00:00'
        ORDER BY
            datetime ASC");
            $stmt->execute([
                "id_name" => $res->device_id
            ]);

            $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
        } elseif ($agg_type == "1H") {
            $stmt = $conn->prepare("SELECT
            DATE(datetime) as date , TIME(datetime) as time , p_pressure_avg , p_flow_avg , p_flowacc_sum , p_volume_sum
        FROM
            data_60
        WHERE
            id_name = :id_name
        AND datetime BETWEEN '$date_search_from 08:00:00'
        AND '$date_search_to 08:00:00'
        ORDER BY
            datetime ASC");
            $stmt->execute([
                "id_name" => $res->device_id
            ]);

            $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
        }





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
