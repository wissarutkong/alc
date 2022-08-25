<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    if (!empty($_GET['select_ddl_devices']) && !empty($_GET['datetime_from']) && !empty($_GET['datetime_to'])) {
        $ArrGraph = array();

        $id_name = $_GET['select_ddl_devices'];
        $datetime_from = $_GET['datetime_from'];
        $datetime_to = $_GET['datetime_to'];

        $stmt = $conn->prepare("SELECT
        r.datetime as date , if(SIGN(p_out)<>-1,p_out,0) as p_out  , flowrate  , CSQ , VBATT , SolarVoltage
    FROM
        realtime_data_1 r INNER JOIN devicelist d ON d.device_id = r.id_name
    WHERE
        d.id = '" . $id_name . "'
    AND r.datetime BETWEEN '" . $datetime_from . "'
    AND '" . $datetime_to . "' 
    ORDER BY
        datetime ASC");
        $stmt->execute();
        $res  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // foreach ($res as $row) {
        //     // $district_id = $row['district_id'];
        //     // if ($district_id == 11) $district_name = 'กทป.';
        //     // else $district_name = 'เขต' . $district_id;
        //     $ArrGraph[] = array(
        //         'date' => $row['datetime_from'],
        //         'pressure' => $row['p_pressure_avg'],
        //         'flow' => $row['p_flow_avg'],
        //         'csq' => $row['p_csq_avg'],
        //         'volt' => $row['p_volt_avg']
        //     );
        // }

        // foreach ($res as $key => $row) {
        //     $ArrGraph[$key] = $row;
        // }

        $res_data['chartdata'][] = $res;

        $columnsNames = array_keys($res[0]);
        //Remove a specific element 
        $val = "date";
        $key = array_search($val, $columnsNames, true);
        if ($key !== false) {
            array_splice($columnsNames, $key, 1);
        }

        $res_data['columndata'][] = $columnsNames;

        $response = [
            'status' => true,
            'response' => $res_data,
            'message' => 'Get Data Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}
