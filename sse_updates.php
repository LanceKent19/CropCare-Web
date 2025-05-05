<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Disable buffering for Nginx

// Global variable to track last sent data
$lastSentData = null;

// Configuration - use in-memory cache for last values
$SENSOR_FILES = [
    'temperature' => __DIR__.'/temperature.txt',
    'moisture' => __DIR__.'/moisture.txt',
    'ph' => __DIR__.'/ph.txt',
    'humidity' => __DIR__.'/humidity.txt'
];

// Use shared memory for last values (more efficient than file checks)
$lastValues = [];
$lastModified = 0;

// Reduce sleep time to 50ms (minimum practical value)
$sleepMicroseconds = 50000;

while (true) {
    $currentData = [];
    $changed = false;
    
    // Fast check if any file changed (directory modification time)
    $dirModified = filemtime(__DIR__);
    if ($dirModified > $lastModified) {
        foreach ($SENSOR_FILES as $sensor => $file) {
            $value = @file_get_contents($file);
            if ($value === false) {
                $value = '-';
            } else {
                $value = trim($value);
            }
            
            if (!isset($lastValues[$sensor])) {
                $changed = true;
            } elseif ($value !== $lastValues[$sensor]) {
                $changed = true;
            }
            
            $currentData[$sensor] = $value;
            $lastValues[$sensor] = $value;
        }
        $lastModified = $dirModified;
    }
    
    if ($changed || empty($lastValues)) {
        $currentData['timestamp'] = microtime(true); // More precise timestamp
        echo "data: ".json_encode($currentData)."\n\n";
        ob_flush();
        flush();
    }
    
    usleep($sleepMicroseconds);
    
    if (connection_aborted()) break;
}
?>