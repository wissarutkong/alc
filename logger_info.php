<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *");
require_once 'service/db/cons.php';

ini_set('display_errors', 'On');

error_reporting(E_STRICT);
date_default_timezone_set('Asia/Bangkok');

$query1 = $_GET['query'];
$buffgsm = explode(",", $query1);

$DataLogger_Id = $buffgsm[0];
$Logger_Brand = $buffgsm[1];
$Logger_model = $buffgsm[2];
$gsm_module = $buffgsm[3];
$gsm_firmware_version = $buffgsm[4];
$ip_address = $buffgsm[5];
$iccid = $buffgsm[6];
$operator = $buffgsm[7];
$latitude = $buffgsm[8];
$logtitude = $buffgsm[9];
$option = $buffgsm[10];
$dt = date("Y-m-d H:i:s");

echo "@>None#";
echo ",";
echo "$dt";
echo ",";
echo "#";
