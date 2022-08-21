<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $data = $_POST['id'];

    $conmand = $conn->prepare("DELETE FROM users WHERE id = :id") ;

    $conmand->execute([
        "id" => (int)$data
    ]);

    $response = [
        'status' => true,
        'message' => 'Delete user success'
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