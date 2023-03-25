<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");

require_once 'service/db/cons.php';
require("service/phpMQTT.php");

ini_set('display_errors', 'On');

error_reporting(E_STRICT);
date_default_timezone_set('Asia/Bangkok');

$query1 = $_GET['query'];
$buffgsm = explode(",", $query1);

$dt = date("Y-m-d H:i:s");
$id_name = $buffgsm[0];                         // DataLoggerId
$Ai1 = floatval($buffgsm[1]);                     // Pressure1
$Ai2 = floatval($buffgsm[2]);                     // Pressure2
$io5_counter = floatval($buffgsm[5]);                //Flow forward insert into dma_last field io5_counter
$io5_acc = floatval($buffgsm[11]);            //Flow Total forward into dma_last field io5_acc
$io3 = floatval($buffgsm[15]);            //Temp on board insert into dma_last field io3
$CSQ = floatval($buffgsm[16]);                    //Signal Gsm 
$VBATT = floatval($buffgsm[17]);                //Battery Voltage
$SolarVoltage = floatval($buffgsm[18]);            //SolarVoltage
$dtd_now = $buffgsm[19];
$dtd = DateTime::createFromFormat('YmdHis', $dtd_now)->format('Y-m-d H:i:s');  // Date Logger To SQL DB
$fw_version = $buffgsm[20];                //fw version new field 


echo "@>None#";
echo ",";
echo "$dt";
echo "#";


try {
    $conmand = $conn->prepare("INSERT INTO realtime_data_1 (id_name,datetime,dtd,p_out,p_in,flowrate,flowtotal,CSQ,VBATT,SolarVoltage,temperature,fw_version) 
    VALUES (:id_name, :datetime, :dtd, :p_out, :p_in, :flowrate, :flowtotal, :CSQ, :VBATT, :SolarVoltage, :temperature , :fw_version)");

    $conmand->execute([
        "id_name" => (string)$id_name,
        "datetime" => $dt,
        "dtd" => $dtd,
        "p_out" => $Ai1,
        "p_in" => $Ai2,
        "flowrate" => $io5_counter,
        "flowtotal" => $io5_acc,
        "CSQ" => $CSQ,
        "VBATT" => $VBATT,
        "SolarVoltage" => $SolarVoltage,
        "temperature" => $io3,
        "fw_version" => $fw_version,
    ]);


    $topic = 'relogger/' . $id_name;
    $message = array(
        'id' => $id_name,
        'p_out' => $Ai1,
        'p_in' => $Ai2,
        'flow' => number_format($io5_counter, 2),
        'flowtotal' => number_format($io5_acc, 2),
        'datetime' => $dtd
    );

    publish_mqtt($topic, $message);


    $response = array(
        'success' => true,
        'unixtime' => strtotime($dt)
    );
    echo json_encode($response);

    http_response_code(200);
    // echo json_encode($response);
} catch (Exception $e) {
    echo json_encode($e->getMessage());
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
