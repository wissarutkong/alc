<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';


if($_SERVER['REQUEST_METHOD'] === "POST"){
    $stmt = $conn->prepare("SELECT * fROM users WHERE username = :username") ;
    $stmt->execute(array(":username" => $_POST['username']));
    $row = $stmt->fetch(PDO::FETCH_OBJ);

if ( !empty($row) && password_verify($_POST['password'], $row->password) ){
    $_SESSION['AD_ID'] = $row->id;
    $_SESSION['AD_NAME'] = $row->name;
    $_SESSION['AD_USERNAME'] = $row->username;
    $_SESSION['AD_COMPANY'] = $row->company;
    $_SESSION['AD_PERMISSION'] = $row->permission;
    $_SESSION['AD_LOGIN'] = $row->updated_at;

    $count = $conn->exec("UPDATE users SET updated_at= now() WHERE id=$row->id ");
    if($count){
        http_response_code(200);
        echo json_encode(array('status' => true, 'message' => 'Login Success!'));
    }else{
        http_response_code(404);
        echo json_encode(array('status' => false, 'message' => 'updated Login Failed !'));
        }

}else{
    http_response_code(401);
    echo json_encode(array('status' => false, 'message' => 'Unauthorized!'));
    }
}else{
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
    
}

?>