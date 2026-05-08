<?php
header("Content-Type: application/json");

// Example response
$data = [
    "message" => "Hello from PHP backend!",
    "time" => date("Y-m-d H:i:s")
];

echo json_encode($data);
