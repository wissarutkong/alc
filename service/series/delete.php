<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $data = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM series s INNER JOIN devicelist d on s.id = d.series_id WHERE d.id  = :id ") ;
    $stmt->execute([
        "id" => (int)$data
    ]);
    $number_of_rows = $stmt->fetchColumn();

    if($number_of_rows > 0){
        http_response_code(404);
        echo json_encode(array('status' => false, 'message' => 'ลบไม่สำเร็จ! มีอุปกรณ์ผูกอยู่ในรุ่นนี้'));
    }else{
        $conmand = $conn->prepare("DELETE FROM series WHERE id = :id") ;

        $conmand->execute([
            "id" => (int)$data
        ]);
    
        $response = [
            'status' => true,
            'message' => 'Delete series success'
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