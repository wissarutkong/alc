<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $data = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM users u INNER JOIN company c on c.id = u.company WHERE c.id = :id ") ;
    $stmt->execute([
        "id" => (int)$data
    ]);
    $number_of_rows = $stmt->fetchColumn();

    if($number_of_rows > 0){
        http_response_code(404);
        echo json_encode(array('status' => false, 'message' => 'ลบไม่สำเร็จ! มีผู้ใช้งานผูกอยู่ในบริษัทนี้'));
    }else{
        $conmand = $conn->prepare("DELETE FROM company WHERE id = :id") ;

        $conmand->execute([
            "id" => (int)$data
        ]);
    
        $response = [
            'status' => true,
            'message' => 'Delete company success'
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