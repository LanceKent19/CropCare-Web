<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: application/json'); // Changed to JSON

$dataFile = 'humidity.txt';
$timestampFile = 'humidity_time.txt';

$humidityValue = @file_get_contents($dataFile) ?: '-';
$lastTime = @file_get_contents($timestampFile);

if ($lastTime === false || time() - intval($lastTime) > 5) {
    echo json_encode([
        "value" => "-",
        "condition" => "OFF"
    ]);
    exit;
}

$humidity = intval($humidityValue);
$condition = "";

if ($humidity < 20) {
    $condition = "Very Dry";
} else if ($humidity < 40) {
    $condition = "Dry";
} else if ($humidity < 60) {
    $condition = "Comfortable";
} else if ($humidity < 35) {
    $condition = "Warm";
} else if ($humidity <= 80) {
    $condition = "Humid";
} else if($humidity > 80) {
    $condition = "Very Humid";
}

echo json_encode([
    "value" => $humidity,
    "condition" => $condition
]);
?>
