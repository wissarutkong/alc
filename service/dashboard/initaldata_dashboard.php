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
        a.id_name,a.p_out , a.p_in , a.flowrate , a.flowtotal , a.datetime
   FROM
       data_1min AS a INNER JOIN devicelist d on d.device_id = a.id_name
   WHERE d.company_id = :company_id AND
       a.datetime = (
           SELECT
               MAX(datetime)
           FROM
               realtime_data_1 AS b
           WHERE
               b.id_name = a.id_name
       )");
        $stmt->execute([
            "company_id" => (int)$company_id
        ]);
        $res  = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($res) > 0) {
            foreach ($res as $key => $val) {
                $topic = 'relogger/' . $val['id_name'];
                $message = array(
                    'id' => $val['id_name'],
                    'p_out' => $val['p_out'],
                    'p_in' => $val['p_in'],
                    'flow' => number_format($val['flowrate'], 2),
                    'flowtotal' => number_format($val['flowtotal'], 2),
                    'datetime' => $val['datetime']
                );

                publish_mqtt($topic, $message);
            }
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
