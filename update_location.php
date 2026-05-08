<?php
require 'db.php';
header("Content-Type: application/json; charset=UTF-8");
if(session_status()===PHP_SESSION_NONE) session_start();

if(!isset($_SESSION['user_id'])){
    http_response_code(403);
    echo json_encode(["error"=>"Unauthorized"]); exit;
}

$data = json_decode(file_get_contents("php://input"),true);
$lat = $data['latitude'] ?? null;
$lng = $data['longitude'] ?? null;

if($lat===null || $lng===null){
    echo json_encode(["error"=>"Missing latitude or longitude"]); exit;
}

$stmt = $conn->prepare("
    INSERT INTO locations (user_id, latitude, longitude, location_updated_at)
    VALUES (?,?,?,NOW())
    ON DUPLICATE KEY UPDATE latitude=VALUES(latitude), longitude=VALUES(longitude), location_updated_at=NOW()
");
$stmt->bind_param("idd", $_SESSION['user_id'],$lat,$lng);
if($stmt->execute()){
    echo json_encode(["status"=>"success"]);
}else{
    echo json_encode(["error"=>"Database error"]);
}
?>
