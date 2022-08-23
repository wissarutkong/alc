<?php

require_once '../db/cons.php';
require("../phpMQTT.php");

$query1 = $_GET['query'];
$buffgsm = explode(",", $query1);

$dt = date("Y-m-d H:i:s");
$dtd_now = $buffgsm[0] . ' ' . $buffgsm[1];             // datetime
$id_name = $buffgsm[2];                                 // DataLoggerId
$Ai2 = floatval($buffgsm[3]);                                         // Pressure1
$Ai1 = floatval($buffgsm[4]);                                         // Pressure2
$io5_counter = floatval($buffgsm[6]);                             // FlowRate +
$io5_acc = floatval($buffgsm[8]);                                    // FlowAcc
$CSQ = floatval($buffgsm[9]);                                        // SignalGSM
$VBATT = floatval($buffgsm[10]);                                // BatteryVoltage
$SolarVoltage = floatval($buffgsm[11]);                        // SolarVoltage
$io3 = floatval($buffgsm[12]);                                        //Temp on board



try {
    $conmand = $conn->prepare("INSERT INTO realtime_data_1 (id_name,datetime,dtd,p_out,p_in,flowrate,flowtotal,CSQ,VBATT,SolarVoltage,temperature) 
    VALUES (:id_name, :datetime, :dtd, :p_out, :p_in, :flowrate, :flowtotal, :CSQ, :VBATT, :SolarVoltage, :temperature)");

    $conmand->execute([
        "id_name" => (string)$id_name,
        "datetime" => $dtd_now,
        "dtd" => $dt,
        "p_out" => $Ai1,
        "p_in" => $Ai2,
        "flowrate" => $io5_counter,
        "flowtotal" => $io5_acc,
        "CSQ" => $CSQ,
        "VBATT" => $VBATT,
        "SolarVoltage" => $SolarVoltage,
        "temperature" => $io3
    ]);


    $topic = 'relogger/' . $id_name;
    $message = array(
        'p_out' => $Ai1,
        'p_in' => $Ai2,
        'flow' => $io5_counter,
        'datetime' => $dtd_now
    );

    publish_mqtt($topic, $message);

    $response = [
        'status' => true,
        'message' => 'success'
    ];
    http_response_code(200);
    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode($e->getMessage());
}


function publish_mqtt($topic, $message)
{
    #$server  = "localhost";
    $server  = "35.187.251.120";
    $port  = 1883;
    $client_id = "Client-" . rand();
    $mqtt = new phpMQTT($server, $port, $client_id);
    if ($mqtt->connect(true, NULL)) {
        $mqtt->publish($topic, json_encode($message), 0);
        $mqtt->close();
    }
}
