<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: application/json');

// Sensor configuration
$sensors = [
    'temperature' => [
        'data_file' => 'temperature.txt',
        'time_file' => 'temperature_time.txt',
        'conditions' => [
            ['max' => 10, 'label' => 'Very Cold'],
            ['max' => 20, 'label' => 'Cold'],
            ['max' => 30, 'label' => 'Normal'],
            ['max' => 35, 'label' => 'Warm'],
            ['max' => 40, 'label' => 'Hot'],
            ['max' => PHP_FLOAT_MAX, 'label' => 'Very Hot']
        ]
    ],
    'moisture' => [
        'data_file' => 'moisture.txt',
        'time_file' => 'moisture_time.txt',
        'conditions' => [
            ['max' => 10, 'label' => 'Very Dry'],
            ['max' => 30, 'label' => 'Dry'],
            ['max' => 69, 'label' => 'Moist'],
            ['max' => 90, 'label' => 'Wet'],
            ['max' => PHP_FLOAT_MAX, 'label' => 'Submerged']
        ]
    ],
    'ph' => [
        'data_file' => 'ph.txt',
        'time_file' => 'ph_time.txt',
        'conditions' => [
            ['max' => 5.5, 'label' => 'Strongly Acidic'],   
            ['max' => 6.5, 'label' => 'Moderately Acidic'],
            ['max' => 7.3, 'label' => 'Neutral'],
            ['max' => 8.4, 'label' => 'Moderately Alkaline'],
            ['max' => PHP_FLOAT_MAX, 'label' => 'Strongly Alkaline']
        ]
    ],'humidity' => [
        'data_file' => 'humidity.txt',
        'time_file' => 'humidity_time.txt',
        'conditions' => [
            ['max' => 20, 'label' => 'Very Dry'],
            ['max' => 30, 'label' => 'Dry'],
            ['max' => 60, 'label' => 'Comfortable'],
            ['max' => 80, 'label' => 'Humid'],
            ['max' => PHP_FLOAT_MAX, 'label' => 'Very Humid']
        ]
    ]
];

$response = [];

foreach ($sensors as $sensor => $config) {
    $value = @file_get_contents($config['data_file']) ?: '-';
    $lastTime = @file_get_contents($config['time_file']);
    
    if ($lastTime === false || time() - intval($lastTime) > 5   ) {
        $response[$sensor] = ["value" => "-", "condition" => "OFF"];
        continue;
    }
    
    $condition = "Unknown";
    $numericValue = floatval($value);
    
    foreach ($config['conditions'] as $range) {
        if ($numericValue <= $range['max']) {
            $condition = $range['label'];
            break;
        }
    }
    
    $response[$sensor] = [
        "value" => $value,
        "condition" => $condition
    ];
}

echo json_encode($response);
?>