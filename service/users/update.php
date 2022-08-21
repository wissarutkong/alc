<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $id = $_POST['id'];
    $username = $_POST['username'];
    // if(!empty($_POST['password'])){

    // }else{
    //     $password_hash = password_hash($_POST['password'] , null , []);
    // }
    $name = $_POST['select_ddl_company_name'];
    $company = $_POST['select_ddl_company'];
    $permission = $_POST['select_ddl_permission'];
    $updated_by = $_SESSION['AD_NAME'];

    $conmand = $conn->prepare(" UPDATE users SET username = :username,
    -- password = :pass_word,
    name = :name,
    company = :company,
    permission = :permission,
    updated_by = :updated_by where id = :id") ;

    $conmand->execute([
        "id" => (int)$id,
        "username" => (string)$username,
        // "pass_word" => (string)$password_hash,
        "name" => (string)$name,
        "company" => (int)$company,
        "permission" => (int)$permission,
        "updated_by" => (string)$updated_by,
    ]);

    $response = [
        'status' => true,
        'message' => 'update user '.$username.' success'
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