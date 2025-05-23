<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
require("../phpMQTT.php");

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    try {

        if (!empty($_GET['company_id'])) {
            $company_id = $_GET['company_id'];
        } else {
            $company_id = $_SESSION['AD_COMPANY'];
        }

        $stmt = $conn->prepare("SELECT
    a.id_name,
    a.p_out,
    a.p_in,
    a.flowrate,
    a.flowtotal,
    a.datetime
FROM
    (
        SELECT
            id_name,
            MAX(datetime) AS max_datetime
        FROM
            data_1min
        GROUP BY
            id_name
    ) AS latest
JOIN data_1min a
    ON a.id_name = latest.id_name AND a.datetime = latest.max_datetime
JOIN devicelist d
    ON d.device_id = a.id_name
WHERE
    d.company_id = :company_id");
        $stmt->execute([
            "company_id" => (int)$company_id
        ]);
        $res  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0) {
            // foreach ($res as $key => $val) {
            //     // $topic = 'relogger/' . $val['id_name'];
            //     $message[$val['id_name']][] = array(
            //         'id' => $val['id_name'],
            //         'p_out' => number_format($val['p_out'], 2),
            //         'p_in' => number_format($val['p_in'], 2),
            //         'flow' => number_format($val['flowrate'], 2),
            //         'flowtotal' => number_format($val['flowtotal'], 2),
            //         'datetime' => $val['datetime']
            //     );

            //     // publish_mqtt($topic, $message);
            // }


            $response = [
                'status' => true,
                'response' => $res,
                'message' => 'Get Data Success'
            ];
            http_response_code(200);
            echo json_encode($response);
        }
    } catch (Throwable $e) {
        http_response_code(404);
        echo json_encode($e->getMessage());
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}



function publish_mqtt($topic, $message)
{
    $server  = "localhost";
    // $server  = "35.187.251.120";
    $port  = 1883;
    $client_id = "Client-" . rand();
    $mqtt = new phpMQTT($server, $port, $client_id);
    if ($mqtt->connect(true, NULL)) {
        $mqtt->publish($topic, json_encode($message), 0);
        $mqtt->close();
    }
}
