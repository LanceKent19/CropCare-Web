<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: application/json'); // Changed to JSON

$dataFile = 'ph.txt';
$timestampFile = 'ph_time.txt';

$phValue = @file_get_contents($dataFile) ?: '-';
$lastTime = @file_get_contents($timestampFile);

if ($lastTime === false || time() - intval($lastTime) > 5) {
    echo json_encode([
        "value" => "-",
        "condition" => "OFF"
    ]);
    exit;
}

$ph = floatval($phValue);
$condition = "";

if ($ph < 5.5) {
    $condition = "Strongly Acidic";
} else if ($ph < 6.5) {
    $condition = "Moderately Acidic";
} else if ($ph < 7.3) {
    $condition = "Neutral";
} else if ($ph <= 8.4) {
    $condition = "Moderately Alkaline";
} else if($ph > 8.4) {
    $condition = "Strongly Alkaline";
}

echo json_encode([
    "value" => $ph,
    "condition" => $condition
]);
?>
