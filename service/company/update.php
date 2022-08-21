<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $id = $_POST['id'];
    $company_desc = $_POST['company'];

    $conmand = $conn->prepare(" UPDATE company SET company_desc = :company_desc where id = :id") ;

    $conmand->execute([
        "id" => (int)$id,
        "company_desc" => (string)$company_desc,
    ]);

    $response = [
        'status' => true,
        'message' => 'update company '.$company_desc.' success'
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