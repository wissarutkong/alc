<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';

$username = "wissarut";
$password_hash = password_hash("wissarut1" , null , []);
$name = "wissarutkong";
$company = "1";
$permission = "1";
$created_by = "admin";

$sql = "INSERT INTO users(username, password,name,company,permission,created_by,created_at)
 VALUES ('$username', '$password_hash', '$name','$company','$permission','$created_by',now()) ";

$update_user = $conn->prepare($sql) ;
try{
    $update_user->execute();
}catch(PDOException $exception){
    echo $exception->getMessage();
    exit();
}


$response = [
    'status' => true,
    'message' => 'Insert Success'
];
http_response_code(200);
echo json_encode($response);


?>