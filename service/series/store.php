<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "GET"){
    try{
        $stmt = $conn->prepare("SELECT id , series_desc , created_by , created_date FROM series ORDER BY id ASC") ;
        $stmt->execute();
        $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
        $response = [
            'status' => true,
            'response' => $res_data,
            'message' => 'Get Data Success'
        ];
        http_response_code(200);
        echo json_encode($response);
    }catch(Throwable $e){
        http_response_code(404);
        echo json_encode( $e->getMessage());
        exit();
    }
}else{
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}




  







