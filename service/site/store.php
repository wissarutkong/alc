<?php
header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if($_SERVER['REQUEST_METHOD'] === "GET"){
    try{
        if( $_SESSION['AD_PERMISSION'] != 1 ){
            $company_id = $_SESSION['AD_COMPANY'];
            $stmt = $conn->prepare("SELECT * FROM site WHERE company_id = :company_id  ORDER BY id ASC") ;
            $stmt->execute([
                "company_id" => (int)$company_id
            ]);
            $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
        }else{
            if(!empty($_GET['company_id'])){
                $company_id = $_GET['company_id'];
                $stmt = $conn->prepare("SELECT * FROM site WHERE company_id = :company_id ORDER BY id ASC") ;
                $stmt->execute([
                    "company_id" => (int)$company_id
                ]);
                $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                $stmt = $conn->prepare("SELECT * FROM site ORDER BY id ASC") ;
                $stmt->execute();
                $res_data  = $stmt->fetchAll(PDO::FETCH_OBJ);
            }      
        }
        
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




  







