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

if (!empty($_GET['datetime'])) {
    $dtd_now = $_GET['datetime'];
} else {
    $dtd_now = date("Y-m-d H:i:s");
}

$dtd_rev = date("Y-m-d H:i:s", strtotime($dtd_now . '-1 hour'));
$date = new DateTime($dtd_rev);
$date->setTime($date->format('G'), 0); // Current hour, 0 minute, [0 second]
$datetime_from = $date->format('Y-m-d H:i:s');
$datetime_to = date("Y-m-d H:59:59", strtotime($date->format('Y-m-d H:i:s')));

$datestamp = new DateTime($dtd_now);
$datestamp->setTime($datestamp->format('G'), 0); // Current hour, 0 minute, [0 second]
$datetime_stamp = $datestamp->format('Y-m-d H:i:s');

// echo json_encode([$dtd_now, $datetime_stamp,  $datetime_from, $datetime_to]);

try {
    $stmt = $conn->prepare("SELECT id ,  device_id FROM devicelist");
    $stmt->execute();
    $res  = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($res as $row) {

        $stmt = $conn->prepare("SELECT
    AVG(DISTINCT flowrate) as flowrate_avg , AVG(DISTINCT p_out) as p_out_avg , AVG(DISTINCT flowtotal) as flowtotal_avg ,
    IF(SUM(CASE WHEN flowtotal IS NULL THEN 1 ELSE 0 END) < 5  ,MIN(CASE WHEN flowtotal IS NOT NULL THEN flowtotal END),NULL) AS flowtotal_min,
    IF(SUM(CASE WHEN flowtotal IS NULL THEN 1 ELSE 0 END) < 5  ,MAX(CASE WHEN flowtotal IS NOT NULL THEN flowtotal END),NULL) AS flowtotal_max
    FROM
    data_1min
    WHERE
    flag_agg = 0
    AND id_name = :id_name
    AND dtd BETWEEN '" . $datetime_from . "'
    AND '" . $datetime_to . "' ");
        $stmt->execute([
            "id_name" => (string)$row['device_id']
        ]);
        $res_2  = $stmt->fetch(PDO::FETCH_OBJ);

        $p_pressure_avg = $res_2->p_out_avg;
        $p_flow_avg = $res_2->flowrate_avg;
        $p_flowacc_sum = $res_2->flowtotal_avg;
        $p_volume_sum = $res_2->flowtotal_max - $res_2->flowtotal_min;
        // echo json_encode([$p_pressure_avg,$p_flow_avg,$res_2->flowtotal_max, $res_2->flowtotal_min,$p_volume_sum]);

        $conmand = $conn->prepare("INSERT INTO data_60 (id_name,datetime,p_pressure_avg,p_flow_avg,p_flowacc_sum,p_volume_sum) VALUES (
                :id_name , :datetime , :p_pressure_avg , :p_flow_avg , :p_flowacc_sum , :p_volume_sum
            )");


        if ($conmand->execute([
            "id_name" => (string)$row['device_id'],
            "datetime" => $datetime_stamp,
            "p_pressure_avg" => $p_pressure_avg,
            "p_flow_avg" => $p_flow_avg,
            "p_flowacc_sum" => $p_flowacc_sum,
            "p_volume_sum" => $p_volume_sum
        ])) {
            // success
            $conmand = $conn->prepare("UPDATE data_1min SET flag_agg = 1 WHERE id_name = :id_name AND dtd BETWEEN '" . $datetime_from . "'AND '" . $datetime_to . "' ");
            $conmand->execute([
                "id_name" => (string)$row['device_id']
            ]);
        } else {
            echo json_encode($exception->getMessage());
            http_response_code(404);
            exit();
        }
    }
    $response = [
        'status' => true,
        'message' => 'Agg 1 hour complete',
    ];
    http_response_code(200);
    echo json_encode($response);
} catch (PDOException $exception) {
    echo json_encode($exception->getMessage());
    http_response_code(404);
    exit();
}
