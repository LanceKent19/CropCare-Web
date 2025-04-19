<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: text/plain');

$dataFile = 'moisture.txt';
$timestampFile = 'moisture_time.txt';

$moistureValue = @file_get_contents($dataFile) ?: '-';
$lastTime = @file_get_contents($timestampFile);

if ($lastTime === false || time() - intval($lastTime) > 5) {
    echo "-"; // Consider system OFF
} else {
    echo $moistureValue;
}

?>