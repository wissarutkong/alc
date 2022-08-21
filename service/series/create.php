<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $series_desc = $_POST['series_desc'];
    $created_by = $_SESSION['AD_NAME'];

    $sql = "INSERT INTO series(series_desc, created_by,created_date)
    VALUES ('$series_desc','$created_by',now()) ";

    $conmand = $conn->prepare($sql) ;

    $conmand->execute();

    $response = [
        'status' => true,
        'message' => 'Insert series '.$series_desc.' success'
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