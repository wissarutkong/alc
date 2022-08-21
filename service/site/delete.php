<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $data = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM devicelist d INNER JOIN site s ON d.site_id = s.id WHERE s.id = :id ") ;
    $stmt->execute([
        "id" => (int)$data
    ]);
    $number_of_rows = $stmt->fetchColumn();

    if($number_of_rows > 0){
        http_response_code(404);
        echo json_encode(array('status' => false, 'message' => 'ลบไม่สำเร็จ! มีอุปกรณ์ผูกกับ site นี้อยู่'));
    }else{
        $conmand = $conn->prepare("DELETE FROM site WHERE id = :id") ;

        $conmand->execute([
            "id" => (int)$data
        ]);
    
        $response = [
            'status' => true,
            'message' => 'Delete site success'
        ];
        http_response_code(200);
        echo json_encode($response);
    }




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