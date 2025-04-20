<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: application/json'); // Changed to JSON

$dataFile = 'temperature.txt';
$timestampFile = 'temperature_time.txt';

$temperatureValue = @file_get_contents($dataFile) ?: '-';
$lastTime = @file_get_contents($timestampFile);

if ($lastTime === false || time() - intval($lastTime) > 5) {
    echo json_encode([
        "value" => "-",
        "condition" => "OFF"
    ]);
    exit;
}

$temperature = intval($temperatureValue);
$condition = "";

if ($temperature < 10) {
    $condition = "Very Cold";
} else if ($temperature < 20) {
    $condition = "Cold";
} else if ($temperature < 30) {
    $condition = "Normal";
} else if ($temperature < 35) {
    $condition = "Warm";
} else if ($temperature <= 40) {
    $condition = "Hot";
} else if($temperature > 40) {
    $condition = "Very Hot";
}

echo json_encode([
    "value" => $temperature,
    "condition" => $condition
]);
?>
