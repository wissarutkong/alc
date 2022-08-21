<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $username = $_POST['username'];
    $password_hash = password_hash($_POST['password'] , null , []);
    $name = $_POST['select_ddl_company_name'];
    $company = $_POST['select_ddl_company'];
    $permission = $_POST['select_ddl_permission'];
    $created_by = $_SESSION['AD_NAME'];

    $sql = "INSERT INTO users(username, password,name,company,permission,created_by,created_at)
    VALUES ('$username', '$password_hash', '$name','$company','$permission','$created_by',now()) ";

    $conmand = $conn->prepare($sql) ;

    $conmand->execute();

    $response = [
        'status' => true,
        'message' => 'Insert user '.$username.' success'
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