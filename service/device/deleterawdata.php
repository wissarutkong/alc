<?php

header('Content-Type: application/json');
require_once '../db/cons.php';
include_once '../authen.php';
include_once '../permission.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    try {

        if (!empty($_POST['id']) && !empty($_POST['datetime_from']) && !empty($_POST['datetime_to'])) {
            $id = $_POST['id'];
            $datetime_from = $_POST['datetime_from'];
            $datetime_to = $_POST['datetime_to'];

            $stmt = $conn->prepare("SELECT device_id FROM devicelist WHERE id = :id ");
            $stmt->execute(array(":id" => $id));
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if (!empty($row)) {
                $conmand = $conn->prepare("DELETE FROM realtime_data_1 WHERE id_name = :id_name AND dtd BETWEEN '" . $datetime_from . "' AND '" . $datetime_to . "'");

                $conmand->execute([
                    "id_name" => $row->device_id
                ]);

                $response = [
                    'status' => true,
                    'msg' => $conmand,
                    'message' => 'Delete rawdata success'
                ];
                http_response_code(200);
                echo json_encode($response);
            }
        } else {
            http_response_code(404);
            echo json_encode(array('status' => false, 'message' => 'parameter invalid'));
        }
    } catch (PDOException $exception) {
        echo json_encode($exception->getMessage());
        http_response_code(404);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(array('status' => false, 'message' => 'Medthod not Allowed!!'));
}
