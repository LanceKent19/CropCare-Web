<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: application/json'); // Changed to JSON

$dataFile = 'moisture.txt';
$timestampFile = 'moisture_time.txt';

$moistureValue = @file_get_contents($dataFile) ?: '-';
$lastTime = @file_get_contents($timestampFile);

if ($lastTime === false || time() - intval($lastTime) > 5) {
    echo json_encode([
        "value" => "-",
        "condition" => "OFF"
    ]);
    exit;
}

$moisture = intval($moistureValue);
$condition = "";

if ($moisture >= 30 && $moisture <= 40) {
    $condition = "Idle";
} else if ($moisture < 10) {
    $condition = "Very Dry";
} else if ($moisture < 30) {
    $condition = "Dry";
} else if ($moisture <= 60) {
    $condition = "Moist";
} else if ($moisture <= 90) {
    $condition = "Wet";
} else {
    $condition = "Submerged";
}

echo json_encode([
    "value" => $moisture,
    "condition" => $condition
]);
?>
