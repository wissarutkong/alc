<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $serial = $_POST['serial'];
    $device_id = $_POST['device_id'];
    $series_id = $_POST['select_ddl_series'];
    $company_id = $_POST['select_ddl_company_modal_device'];
    $is_control = $_POST['is_control'];
    $created_by = $_SESSION['AD_NAME'];

    $sql = "INSERT INTO devicelist(company_id,series_id,serial,device_id, created_by,created_date,is_control)
    VALUES ('$company_id','$series_id','$serial','$device_id','$created_by',now(),'$is_control') ";

    $conmand = $conn->prepare($sql) ;

    $conmand->execute();

    $response = [
        'status' => true,
        'message' => 'Insert devicelist '.$serial.' success'
    ];
    http_response_code(200);
    echo json_encode($response);

}catch(PDOException $exception){
    echo json_encode( $exception->getMessage());
    http_response_code(404);
    exit();
}
}else{
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}

?>