<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

$device_id = trim($data["id"] ?? "");
$temp      = $data["temperature"] ?? null;
$humidity  = $data["humidity"] ?? null;
$air       = $data["airQuality"] ?? 0;
$table     = $data["table"] ?? "live";

if ($device_id === "" || $temp === null || $humidity === null) {
    echo json_encode(["success" => false, "error" => "필수 값 누락"]);
    exit;
}

switch ($table) {
    case "test":    $sensorTable = "sensor_data_test";    break;
    case "history": $sensorTable = "sensor_data_history"; break;
    default:        $sensorTable = "sensor_data";         break;
}

$stmt = $conn->prepare(
    "INSERT INTO $sensorTable (device_id, temperature, humidity, air_quality)
     VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $device_id, $temp, $humidity, $air);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();