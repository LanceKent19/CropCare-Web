<?php
header('Content-Type: text/plain');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");

// Define the sensor files we'll be handling
$sensorFiles = [
    'temperature' => 'temperature.txt',
    'moistureSensor' => 'moisture.txt',
    'phSensor' => 'ph.txt',
    'humidity' => 'humidity.txt'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Parse the URL-encoded form data
    parse_str(file_get_contents("php://input"), $postData);
    
    // Get power state (default to 'on' if not specified)
    $powerState = strtolower($postData['powerState'] ?? 'on');
    
    // Handle system off state
    if ($powerState === 'off') {
        foreach ($sensorFiles as $file) {
            file_put_contents($file, '-');
            file_put_contents(str_replace('.txt', '_time.txt', $file), time());
        }
        echo "SYSTEM_OFF";
        exit;
    }
    
    // Process each sensor value
    $timestamp = time();
    $processedValues = [];
    
    foreach ($sensorFiles as $param => $file) {
        if (isset($postData[$param])) {
            $value = $postData[$param];
            
            // Handle "no reading" value
            if ($value === '-') {
                file_put_contents($file, '-');
                $processedValues[$param] = 'NO_READING';
                continue;
            }
            
            // Validate numeric values
            if (is_numeric($value)) {
                file_put_contents($file, $value);
                file_put_contents(str_replace('.txt', '_time.txt', $file), $timestamp);
                $processedValues[$param] = $value;
            } else {
                $processedValues[$param] = 'INVALID_DATA';
            }
        }
    }
    
    // If we received at least one valid value
    if (!empty($processedValues)) {
        echo "OK|" . json_encode($processedValues);
    } else {
        http_response_code(400);
        echo "NO_VALID_DATA";
    }
} else {
    http_response_code(405);
    echo "METHOD_NOT_ALLOWED";
}
?>