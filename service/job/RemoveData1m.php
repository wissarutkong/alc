<?php

session_start();
error_reporting(E_ALL);
// error_reporting(0); 
date_default_timezone_set('Asia/Bangkok');

/** Class Database สำหรับติดต่อฐานข้อมูล */
class Database
{
    /**
     * กำหนดตัวแปรแบบ private
     * Method Connect ใช้สำหรับการเชื่อมต่อ Database
     *
     * @var string|null
     * @return PDO
     */
    #private $host = "localhost";
    private $host = "35.187.251.120";
    private $dbname = "alc_system";
    private $username = "stdesign";
    private $password = "fugvH,gv#91753";
    private $conn = null;

    public function connect()
    {
        try {
            /** PHP PDO */
            $this->conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname . ';', $this->username,  $this->password);
            $this->conn->exec("SET CHARACTER SET utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ไม่สามารถเชื่อมต่อฐานข้อมูลได้: " . $exception->getMessage();
            exit();
        }
        return $this->conn;
    }
}

$Database = new Database();
$conn = $Database->connect();
$date_limit = date('Y-m-d H:i:s', strtotime('-1 year'));
try {

    $sql = "DELETE FROM realtime_data_1 WHERE datetime < :date_limit";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['date_limit' => $date_limit]);


    $sql2 = "DELETE FROM data_1min WHERE datetime < :date_limit";
    $stmt = $conn->prepare($sql2);
    $stmt->execute(['date_limit' => $date_limit]);


    $response = [
        'status' => true,
        'message' => "Deleted old data before " . $date_limit
    ];
    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $exception) {
    echo json_encode($exception->getMessage());
    http_response_code(404);
    exit();
}
