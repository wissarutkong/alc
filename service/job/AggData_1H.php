<?php
require_once '../db/cons.php';


$dtd_now = date("Y-m-d H:i:s");
$dtd_rev = date("Y-m-d H:i:s", strtotime($dtd_now . '-1 hour'));
$date = new DateTime($dtd_rev);
$date->setTime($date->format('G'), 0); // Current hour, 0 minute, [0 second]
$datetime_from = $date->format('Y-m-d H:i:s');
$datetime_to = date("Y-m-d H:59:59", strtotime($date->format('Y-m-d H:i:s')));

$datestamp = new DateTime($dtd_now);
$datestamp->setTime($datestamp->format('G'), 0); // Current hour, 0 minute, [0 second]
$datetime_stamp = $datestamp->format('Y-m-d H:i:s');

// echo json_encode([$dtd_now, $datetime_stamp,  $datetime_from, $datetime_to]);

try {
    $stmt = $conn->prepare("SELECT id ,  device_id FROM devicelist");
    $stmt->execute();
    $res  = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row) {

        $stmt = $conn->prepare("SELECT
    AVG(DISTINCT flowrate) as flowrate_avg , AVG(DISTINCT p_out) as p_out_avg , AVG(DISTINCT flowtotal) as flowtotal_avg ,
    IF(SUM(CASE WHEN flowtotal IS NULL THEN 1 ELSE 0 END) < 5  ,MIN(CASE WHEN flowtotal IS NOT NULL THEN flowtotal END),0) AS flowtotal_min,
    IF(SUM(CASE WHEN flowtotal IS NULL THEN 1 ELSE 0 END) < 5  ,MAX(CASE WHEN flowtotal IS NOT NULL THEN flowtotal END),0) AS flowtotal_max
    FROM
    data_1min
    WHERE
    flag_agg = 0
    AND id_name = :id_name
    AND dtd BETWEEN '" . $datetime_from . "'
    AND '" . $datetime_to . "' ");
        $stmt->execute([
            "id_name" => (string)$row['device_id']
        ]);
        $res_2  = $stmt->fetch(PDO::FETCH_OBJ);

        $p_pressure_avg = $res_2->p_out_avg;
        $p_flow_avg = $res_2->flowrate_avg;
        $p_flowacc_sum = $res_2->flowtotal_avg;
        $p_volume_sum = $res_2->flowtotal_max - $res_2->flowtotal_min;
        // echo json_encode([$p_pressure_avg,$p_flow_avg,$res_2->flowtotal_max, $res_2->flowtotal_min,$p_volume_sum]);

        $conmand = $conn->prepare("INSERT INTO data_60 (id_name,datetime,p_pressure_avg,p_flow_avg,p_flowacc_sum,p_volume_sum) VALUES (
            :id_name , :datetime , :p_pressure_avg , :p_flow_avg , :p_flowacc_sum , :p_volume_sum
        )");

        $conmand->execute([
            "id_name" => (string)$row['device_id'],
            "datetime" => $datetime_stamp,
            "p_pressure_avg" => $p_pressure_avg,
            "p_flow_avg" => $p_flow_avg,
            "p_flowacc_sum" => $p_flowacc_sum,
            "p_volume_sum" => $p_volume_sum
        ]);
    }

    $response = [
        'status' => true,
        'message' => 'Agg 1 hour complete'
    ];
    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $exception) {
    echo json_encode($exception->getMessage());
    http_response_code(404);
    exit();
}
