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
function fetchTemperature() {
    fetch('getTemp.php')
        .then(response => response.text())
        .then(data => {
            const tempDisplay = document.getElementById('tempSensor');
            if (data === '-') {
                tempDisplay.innerText = "OFF";
                tempDisplay.style.color = "#ff4444";
                tempDisplay.style.fontStyle = "italic";
            } else {
                tempDisplay.innerText = data + '%';
                tempDisplay.style.color = "";
                tempDisplay.style.fontStyle = "";
            }
        })
        .catch(error => {
            console.error('Error fetching Temperature Value:', error);
            document.getElementById('tempSensor').innerText = "ERR";
        });
}
function fetchMoisture() {
    fetch('getMoisture.php')
        .then(response => response.json())
        .then(data => {
            const moistureDisplay = document.getElementById('moistureSensor');  // existing percentage
            const moistureStatus = document.getElementById('moistureStatus');    // condition in notification

            if (data.value === "-") {
                moistureDisplay.innerText = "OFF";
                moistureDisplay.style.color = "#ff4444";
                moistureDisplay.style.fontStyle = "italic";
                moistureStatus.innerText = "OFF";
            } else {
                moistureDisplay.innerText = data.value + '%';
                moistureDisplay.style.color = "";
                moistureDisplay.style.fontStyle = "";
                moistureStatus.innerText = data.condition;
            

             // Apply color based on condition
             let color = "";
                switch (data.condition) {
                    case "Very Dry":
                    case "Dry":
                        color = "#8E1616"; 
                        break;
                    case "Moist":
                        color = "#00C851"; 
                        break;
                    case "Wet":
                        color = "#33b5e5"; 
                        break;
                    case "Submerged":
                        color = "#8E1616"; 
                        break;
                    case "Idle":
                        color = "#706D54"; 
                        break;
                    default:
                        color = "#000"; 
                }

                moistureStatus.style.color = color;
                moistureStatus.style.fontStyle = "normal";
            }
        })
        .catch(error => {
            console.error('Error fetching Soil Moisture Value:', error);
            document.getElementById('moistureSensor').innerText = "ERR";
            document.getElementById('moistureStatus').innerText = "ERR";
        });
}

function fetchPh() {
    fetch('getPh.php')
        .then(response => response.text())
        .then(data => {
            const phDisplay = document.getElementById('phSensor');
            if (data === '-') {
                phDisplay.innerText = "OFF";
                phDisplay.style.color = "#ff4444";
                phDisplay.style.fontStyle = "italic";
            } else {
                phDisplay.innerText = data + '%';
                phDisplay.style.color = "";
                phDisplay.style.fontStyle = "";
            }
        })
        .catch(error => {
            console.error('Error fetching Ph Level:', error);
            document.getElementById('phSensor').innerText = "ERR";
        });
}
function fetchHumidity() {
    fetch('getHumidity.php')
        .then(response => response.text())
        .then(data => {
            const humidityDisplay = document.getElementById('humiditySensor');
            if (data === '-') {
                humidityDisplay.innerText = "OFF";
                humidityDisplay.style.color = "#ff4444";
                humidityDisplay.style.fontStyle = "italic";
            } else {
                humidityDisplay.innerText = data + '%';
                humidityDisplay.style.color = "";
                humidityDisplay.style.fontStyle = "";
            }
        })
        .catch(error => {
            console.error('Error fetching Humidity Level:', error);
            document.getElementById('humiditySensor').innerText = "ERR";
        });
}

// Initial fetch on page load
window.onload = () => {
    fetchTemperature();
    fetchMoisture();
    fetchPh();
    fetchHumidity();

    // Delay interval polling slightly
    setTimeout(() => {
        setInterval(fetchTemperature, 500);
        setInterval(fetchMoisture, 500);
        setInterval(fetchPh, 500);
        setInterval(fetchHumidity, 500);
    }, 300);
};
</script>
    <script src="script.js"></script>
</body>
</html>