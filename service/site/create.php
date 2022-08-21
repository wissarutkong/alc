<?php 

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';

if($_SERVER['REQUEST_METHOD'] === "POST"){
try{
    $site_desc = $_POST['site_desc'];
    if(!empty($_POST['select_ddl_company'])){
        $company_id = $_POST['select_ddl_company'];
    }else{
        $company_id = $_SESSION['AD_COMPANY'];
    }
    
    $created_by = $_SESSION['AD_NAME'];

    $sql = "INSERT INTO site(site_desc,company_id,created_by,created_date)
    VALUES ('$site_desc','$company_id','$created_by',now()) ";

    $conmand = $conn->prepare($sql) ;

    $conmand->execute();

    $response = [
        'status' => true,
        'message' => 'Insert site '.$site_desc.' success'
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