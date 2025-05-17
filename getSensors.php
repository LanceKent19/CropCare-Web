<?php
header('Content-Type: application/json');

$sensors = [
    'temperature' => file_get_contents('temperature.txt'),
    'moisture' => file_get_contents('moisture.txt'),
    'ph' => file_get_contents('ph.txt'),
    'humidity' => file_get_contents('humidity.txt'),
    'last_update' => max(
        filemtime('temperature.txt'),
        filemtime('moisture.txt'),
        filemtime('ph.txt'),
        filemtime('humidity.txt')
    )
];

echo json_encode($sensors);
?>