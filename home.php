<?php
session_name('cropcare_session');
session_start();
require 'db/config.php';

// // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM plants");
$stmt->execute();
$plants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$weatherApiKey = 'fee4072366634e9d86b220551250904'; 
$defaultLocation = 'San Bartolome, Novaliches, Philippines'; 
$weatherData = null;

function getWeatherData($apiKey, $location) {
    $url = "http://api.weatherapi.com/v1/current.json?key=" . $apiKey . "&q=" . urlencode($location) . "&aqi=no";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

$cacheFile = 'weather_cache.json';
$cacheTime = 30 * 60; 

if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
    $weatherData = json_decode(file_get_contents($cacheFile), true);
} else {
    try {
        $weatherData = getWeatherData($weatherApiKey, $defaultLocation);
        if ($weatherData && !isset($weatherData['error'])) {
            file_put_contents($cacheFile, json_encode($weatherData));
        }
    } catch (Exception $e) {
        error_log("Weather API error: " . $e->getMessage());
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/svg+xml" href="resrources/logo.svg">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rum+Raisin&display=swap" rel="stylesheet">
    <title>CropCare</title>
</head>
<body>

<?php include_once("partials/header.php") ?>

    <section class="informations">
        <!-- ===================weather=================== -->
        <div class="container-20 weather-info">
            <div class="info">
                <div class="location poppins-regular">
                    <?php 
                    if ($weatherData && isset($weatherData['location']['name'])) {
                        echo htmlspecialchars($weatherData['location']['name']) . ', ' . 
                            htmlspecialchars($weatherData['location']['country']);
                    } else {
                        echo htmlspecialchars($defaultLocation);
                    }
                    ?>
                </div>
                <div class="temperature poppins-medium">
                    <?php 
                    if ($weatherData && isset($weatherData['current']['temp_c'])) {
                        echo round($weatherData['current']['temp_c']) . '°C';
                    } else {
                        echo '--°C';
                    }
                    ?>
                </div>
                <div class="weather-condition poppins-regular">
                    <?php 
                    if ($weatherData && isset($weatherData['current']['condition']['text'])) {
                        echo htmlspecialchars($weatherData['current']['condition']['text']);
                    } else {
                        echo 'Weather data unavailable';
                    }
                    ?>
                </div>
                <div class="weather-details">
                    <?php if ($weatherData && isset($weatherData['current'])): ?>
                        <small>Wind: <?= $weatherData['current']['wind_kph'] ?? '--' ?> km/h</small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="image-container">
                <?php if ($weatherData && isset($weatherData['current']['condition']['icon'])): ?>
                    <img src="<?= htmlspecialchars($weatherData['current']['condition']['icon']) ?>" 
                        alt="<?= htmlspecialchars($weatherData['current']['condition']['text'] ?? 'Weather icon') ?>">
                <?php else: ?>
                    <img src="resrources/Weather.png" alt="Default weather icon">
                <?php endif; ?>
            </div>
        </div>

        <!-- ===================infos from esp=================== -->

        <div class="cards-container">
            <div class="container-20">
                <span class="material-symbols-outlined">
                    humidity_percentage
                </span>
                <div class="card-info">
                    <div class="title poppins-medium">
                        Humidity
                    </div>
                    <div class="number poppins-medium" id="humiditySensor">
                        Loading...
                    </div>
                </div>
            </div>

            <div class="container-20">
                <span class="ph material-symbols-outlined">
                    water_ph
                </span>
                <div class="card-info">
                    <div class="title poppins-medium">
                        pH Level
                    </div>
                    <div class="number poppins-medium" id="phSensor">
                        Loading...
                    </div>
                </div>
            </div>

            <div class="container-20">
                <span class=" moisture material-symbols-outlined">
                    psychiatry
                </span>
                <div class="card-info">
                    <div class="title poppins-medium">
                       Moisture
                    </div>
                    <div class="number poppins-medium" id="moistureSensor">
                        Loading...
                    </div>
                </div>
            </div>
            <div class="container-20">
                <span class="material-symbols-outlined">
                    thermostat
                </span>
                <div class="card-info">
                    <div class="title poppins-medium">
                        Temp
                    </div>
                    <div class="number poppins-medium" id="tempSensor">
                        Loading...
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================my plants=================== -->
         <?php if (!empty($plants)) : ?>
            <div class="cards-container-plants">
                <div class="heading poppins-regular">
                    Plants
                </div>
                <div class="cards-slider">
                    <?php foreach ($plants as $plant) : ?>
                        <a href="plant.php?id=<?= htmlspecialchars($plant['plant_id']) ?>" class="card">
                            <div class="filter"></div>
                            <div class="image-container">
                                <img src="resrources/<?= htmlspecialchars($plant['image'])?>" alt="">
                            </div>
                            <div class="title">
                                <small class="poppins--medium-bold"><?= htmlspecialchars($plant['name']) ?></small>
                            </div>
                        </a>
                    <?php endforeach ?>                  

                </div>


            </div>
            
        <?php endif ?>

        


        <!-- ===================inspect for diseases=================== -->

        <div class="inspect-diseases">
            <div class="heading poppins-regular">
                Inspect for diseases
            </div>

            <div class="container-20">
                <div class="headings">
                    <div class="texts">
                        <div class="heading1 poppins-bold">
                            Take a picture of your plant
                        </div>
                        <div class="heading poppins-regular">
                            Simply snap a photo of your plant to begin the diagnosis. 
                        </div>
                    </div>
                    <div class="image-container">
                        <img src="resrources/recycling-icon-design.png" alt="">
                    </div>
                </div>
                <a href="disease.php" class="button-container">
                    <div class="button">
                        <div class="text">
                            Start scanning now
                        </div>
                        <span class="material-symbols-outlined">
                            arrow_forward_ios
                        </span>
                    </div>

                </a>
            </div>

        </div>





    </section>

    <?php include_once("partials/navigation.php") ?>
    <script>
    const globalConditions = {
    temperature: null,
    moisture: null,
    ph: null,
    humidity: null
};
const colorPriority = {
    '#8E1616': 4,   // Dark Red (Highest)
    '#EA7300': 3,   // Orange
    '#FFD63A': 2,   // Yellow
    '#33b5e5': 1,   // Blue (Green class)
    '#706D54': 0     // Grey
};

const colorToClass = {
    '#8E1616': 'status-red',
    '#EA7300': 'status-orange',
    '#FFD63A': 'status-yellow',
    '#33b5e5': 'status-green',
    '#706D54': 'status-grey'
};
const sensorConfig = {
    temperature: {
        valueElement: 'tempSensor',
        statusElement: 'temperatureStatus',
        unit: '°C',
        conditions: {
            "Very Cold": "#8E1616",
            "Cold": "#8E1616",
            "Normal": "#33b5e5",
            "Warm": "#FFD63A",
            "Hot": "#EA7300",
            "Very Hot": "#8E1616",
            "OFF": "#ff4444"
        }
    },
    moisture: {
        valueElement: 'moistureSensor',
        statusElement: 'moistureStatus',
        unit: '%',
        conditions: {
            "Very Dry": "#8E1616",
            "Dry": "#8E1616",
            "Submerged": "#8E1616",
            "Moist": "#FFD63A",
            "Wet": "#33b5e5",
            "Idle": "#706D54",
            "OFF": "#ff4444"
    }
},
    ph: {
        valueElement: 'phSensor',
        statusElement: 'phStatus',
        unit: '%',
        conditions: {
            "Strongly Acidic": "#8E1616",
            "Moderately Acidic": "#EA7300",
            "Neutral": "#33b5e5",
            "Moderately Alkaline": "#FFD63A",
            "Strongly Alkaline": "#8E1616",
            "Idle": "#706D54",
            "OFF": "#ff4444"
        }
    },
    humidity: {
        valueElement: 'humiditySensor',
        statusElement: 'humidityStatus',
        unit: '%',
        conditions: {
            "Very Dry": "#8E1616",
            "Dry": "#8E1616",
            "Comfortable": "#33b5e5",
            "Humid": "#FFD63A",
            "Very Humid": "#EA7300",
            "Idle": "#706D54",
            "OFF": "#ff4444"
        }
    }
};

// Unified fetch function
function fetchAllSensors() {
    fetch('sensor_data.php')
        .then(response => {
            if (!response.ok) throw new Error('Network error');
            return response.json();
        })
        .then(data => {
            Object.keys(sensorConfig).forEach(sensor => {
                updateSensorDisplay(sensor, data[sensor] || {value: "-", condition: "OFF"});
            });
            updateNotificationDot();
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Object.keys(sensorConfig).forEach(sensor => {
                const config = sensorConfig[sensor];
                document.getElementById(config.valueElement).innerText = "ERR";
                document.getElementById(config.statusElement).innerText = "ERR";
                globalConditions[sensor] = null;
            });
            updateNotificationDot();
        });
}
// Unified display update
function updateSensorDisplay(sensor, data) {
    const config = sensorConfig[sensor];
    const valueElement = document.getElementById(config.valueElement);
    const statusElement = document.getElementById(config.statusElement);

    if (data.value === "-") {
        valueElement.innerText = "OFF";
        valueElement.style.color = config.conditions["OFF"];
        valueElement.style.fontStyle = "italic";
        statusElement.innerText = "OFF";
        globalConditions[sensor] = null;
    } else {
        valueElement.innerText = data.value + config.unit;
        valueElement.style.color = "";
        valueElement.style.fontStyle = "";
        statusElement.innerText = data.condition;
        
        const color = config.conditions[data.condition] || "#000";
        statusElement.style.color = color;
        statusElement.style.fontStyle = "normal";
        globalConditions[sensor] = color;
    }
}


function updateNotificationDot() {
    const notificationDot = document.getElementById('notificationDot');
    let highestPriority = -1;
    let highestColor = null;

    Object.values(globalConditions).forEach(color => {
        if (color && colorPriority[color] !== undefined) {
            const priority = colorPriority[color];
            if (priority > highestPriority) {
                highestPriority = priority;
                highestColor = color;
            }
        }
    });

    notificationDot.className = 'status-dot'; // Reset classes

    if (highestColor !== null) {
        notificationDot.classList.add(colorToClass[highestColor], 'show');
        notificationDot.style.display = 'block';
    } else {
        notificationDot.style.display = 'none';
    }
}

// Initialize with WebSocket-like polling
let sensorUpdateInterval;
const POLL_INTERVAL = 1000; // 1 second

function initSensorUpdates() {
    fetchAllSensors(); // Initial fetch
    
    // Set up efficient polling
    sensorUpdateInterval = setInterval(fetchAllSensors, POLL_INTERVAL);
    
    // Clean up when page unloads
    window.addEventListener('beforeunload', () => {
        clearInterval(sensorUpdateInterval);
    });
}

// Add this at the top of your script
const performance = window.performance || Date;
const sensorCache = {};

// Modify the message event handler
eventSource.addEventListener('message', (event) => {
    const receiveTime = performance.now();
    try {
        const data = JSON.parse(event.data);
        const processStart = performance.now();
        
        // Only process if data actually changed
        let needsUpdate = false;
        Object.keys(sensorConfig).forEach(sensor => {
            if (data.hasOwnProperty(sensor) && data[sensor] !== sensorCache[sensor]) {
                needsUpdate = true;
                sensorCache[sensor] = data[sensor];
            }
        });

        if (needsUpdate) {
            Object.keys(sensorConfig).forEach(sensor => {
                if (data.hasOwnProperty(sensor)) {
                    const condition = getConditionForSensor(sensor, data[sensor]);
                    updateSensorDisplay(sensor, {
                        value: data[sensor],
                        condition: condition
                    });
                }
            });
            updateNotificationDot();
            
            // Performance tracking
            const serverTime = data.timestamp * 1000; // Convert to ms
            const totalLatency = receiveTime - serverTime;
            const processingTime = performance.now() - processStart;
            
            console.log(`Latency: ${totalLatency.toFixed(1)}ms (Processing: ${processingTime.toFixed(1)}ms)`);
        }
    } catch (e) {
        console.error('Error processing SSE message:', e);
    }
});
</script>
    <script src="script.js"></script>
</body>
</html>