<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Disable buffering for Nginx

// Global variable to track last sent data
$lastSentData = null;

while (true) {
    // Get current sensor data
    $currentData = [
        'temperature' => @file_get_contents('temperature.txt') ?: '-',
        'moisture' => @file_get_contents('moisture.txt') ?: '-',
        'ph' => @file_get_contents('ph.txt') ?: '-',
        'humidity' => @file_get_contents('humidity.txt') ?: '-',
        'timestamp' => time()
    ];
    
    // Only send if data changed
    if ($lastSentData !== json_encode($currentData)) {
        echo "data: " . json_encode($currentData) . "\n\n";
        ob_flush();
        flush();
        $lastSentData = json_encode($currentData);
    }
    
    // Sleep briefly to reduce CPU usage
    usleep(300000); // 300ms
}
?>