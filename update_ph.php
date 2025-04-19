<?php
// Define file paths
$dataFile = 'ph.txt';
$timestampFile = 'ph_time.txt';

// Create file with default "-" if it doesn't exist
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, '-');
}

// Set strict headers
header('Content-Type: text/plain');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawData = file_get_contents("php://input");
    $postData = [];
    parse_str($rawData, $postData);

    $phValue = $postData['phSensor'] ?? null;
    $powerState = strtolower($postData['powerState'] ?? 'off');

    // Handle system off state or no reading
    if ($powerState === 'off' || $phValue === '-') {
        file_put_contents($dataFile, '-');
        echo "OFF";
        exit;
    }

    // Handle valid reading
    if (is_numeric($phValue)) {
        file_put_contents($dataFile, $phValue);
        file_put_contents($timestampFile, time());  // Update timestamp only for valid values
        echo $phValue;
    } else {
        http_response_code(400);
        echo "Invalid data";
    }
} else {
    // Handle GET requests - just return current value
    echo file_exists($dataFile) ? file_get_contents($dataFile) : '-';
}
?>
