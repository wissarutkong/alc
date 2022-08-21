<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $id = $_POST['id'];
    $device_desc = $_POST['device_desc'];
    $site_id = $_POST['select_ddl_site_id'];
    $updated_by = $_SESSION['AD_NAME'];

    

    $conmand = $conn->prepare(" UPDATE devicelist SET device_desc = :device_desc 
    , site_id = :site_id , updated_by = :updated_by , updated_date = now() where id = :id") ;

    $conmand->execute([
        "id" => (int)$id,
        "device_desc" => (string)$device_desc,
        "site_id" => (int)$site_id,
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