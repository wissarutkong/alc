<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $id = $_POST['id'];
    $serial = $_POST['serial'];
    $device_id = $_POST['device_id'];
    $series_id = $_POST['select_ddl_series'];
    $company_id = $_POST['select_ddl_company_modal_device'];
    $updated_by = $_SESSION['AD_NAME'];

    $conmand = $conn->prepare(" UPDATE devicelist SET serial = :serial ,
    device_id = :device_id, series_id = :series_id , company_id = :company_id , updated_by = :updated_by , updated_date = now() where id = :id") ;

    $conmand->execute([
        "id" => (int)$id,
        "serial" => (string)$serial,
        "device_id" => (string)$device_id,
        "series_id" => (int)$series_id,
        "company_id" => (int)$company_id,
        "updated_by" => (string)$updated_by,
    ]);

    $response = [
        'status' => true,
        'message' => 'update device success'
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