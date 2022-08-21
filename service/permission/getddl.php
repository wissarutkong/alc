<?php 
header('Content-Type: application/json');
include_once '../authen.php';
require_once '../db/cons.php';

$_sql = $conn->prepare("SELECT id , permission_desc FROM permission ORDER BY id ASC");
$_sql->execute();
$res  = $_sql->fetchAll(PDO::FETCH_ASSOC);
$html = '<option value="">---โปรดระบุ---</option>';
foreach($res as $row){
    $html .= '<option value="' . $row['id'] . '">' . $row['permission_desc'] . '</option>';
}

http_response_code(200);
echo json_encode($html);

?>