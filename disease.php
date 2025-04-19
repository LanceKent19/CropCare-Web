<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session for storing results
session_name('cropcare_session');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Database connection
require 'db/config.php';

// Handle session results
if (isset($_SESSION['results'])) {
    extract($_SESSION['results']);
    unset($_SESSION['results']);
}

// ✅ Set Your API Key
$api_key = "3l8JS5DTyc4osZOTDSSNAxVBxpWt7xBrbHv2cFSUARgv9U1ygz";

// ✅ Create uploads directory if it doesn't exist
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// ✅ Function to query DeepSeek API
function queryDeepSeek($disease_name, $deepseek_api_key) {
    $url = "https://api.deepseek.com/v1/chat/completions";
    
    $messages = [
        [
            "role" => "system",
            "content" => "You are a helpful plant disease expert. Provide concise, accurate information about plant diseases, their symptoms, treatments, and prevention methods."
        ],
        [
            "role" => "user",
            "content" => "Tell me everything I need to know about the plant disease: $disease_name. Include symptoms, treatments, and prevention methods."
        ]
    ];
    
    $data = [
        "model" => "deepseek-chat",
        "messages" => $messages,
        "temperature" => 0.7,
        "max_tokens" => 1000
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $deepseek_api_key"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $response_data = json_decode($response, true);
    
    if (isset($response_data['choices'][0]['message']['content'])) {
        return $response_data['choices'][0]['message']['content'];
    }
    
    return "Could not retrieve information from DeepSeek. Please try again later.";
}

function cleanDeepSeekOutput($response) {
    $cleaned = preg_replace('/^#+\s*(.*)$/m', '$1', $response);
    $cleaned = preg_replace('/(?<!\w)#(?!\w)/', '', $cleaned);
    $cleaned = preg_replace('/\*\*(.*?)\*\*/', '$1', $cleaned);
    $cleaned = preg_replace('/__(.*?)__/', '$1', $cleaned);
    $cleaned = strip_tags($cleaned);
    $cleaned = preg_replace('/^\s*[\-\*\+]\s*/m', '• ', $cleaned);
    $cleaned = preg_replace('/\n{3,}/', "\n\n", $cleaned);
    $cleaned = trim($cleaned);
    $cleaned = nl2br($cleaned);
    return $cleaned;
}

// Function to insert disease result into database
function insertDiseaseResult($pdo, $disease_name, $result, $image_path, $confidence) {
    try {
        $stmt = $pdo->prepare("INSERT INTO disease_result (name, result, image, user_id) VALUES (:name, :result, :image, :user_id)");
        $stmt->execute([
            ':name' => $disease_name,
            ':result' => $result,
            ':image' => $image_path,
            ':user_id' => $_SESSION['user_id']
        ]);
        
        // Get the inserted ID
        $disease_result_id = $pdo->lastInsertId();
        
        // Insert confidence percentage (assuming this would be in another table)
        // You might need to adjust this based on your exact database structure

        return $disease_result_id;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

$result_html = "";
$deepseek_response = "";
$uploaded_image_path = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["plant_image"])) {
    if ($_FILES["plant_image"]["error"] !== UPLOAD_ERR_OK) {
        $result_html = "<p class='error'>❌ Error uploading file. Try again.</p>";
    } else {
        $target_dir = "uploads/";
        // Create uploads directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["plant_image"]["name"], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if (move_uploaded_file($_FILES["plant_image"]["tmp_name"], $target_file)) {
            // Store only the filename in the database, not the full path
            $uploaded_image_path = $new_filename;
            
            $image_data = file_get_contents($target_file);
            $image_base64 = base64_encode($image_data);

            $url = "https://api.plant.id/v2/health_assessment";

            $data = json_encode([
                "images" => [$image_base64],
                "modifiers" => ["health_only"],
                "organs" => ["leaf"]
            ]);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Api-Key: $api_key"
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($ch);

            if ($response === false) {
                $result_html = "<p class='error'>❌ API connection failed: " . curl_error($ch) . "</p>";
            } else {
                $response_data = json_decode($response, true);

                if (isset($response_data['health_assessment']['diseases']) && !empty($response_data['health_assessment']['diseases'])) {
                    $diseases = $response_data['health_assessment']['diseases'];

                    usort($diseases, function ($a, $b) {
                        return $b['probability'] <=> $a['probability'];
                    });
                    $top_disease = $diseases[0];

                    $disease_name = $top_disease['name'];
                    $confidence = round($top_disease['probability'] * 100, 2) . "%";
                    
                    $deepseek_api_key = "sk-476784d644564c60a7d0f1e879673f81";
                    $deepseek_response = queryDeepSeek($disease_name, $deepseek_api_key);
                    $cleaned_response = cleanDeepSeekOutput($deepseek_response);

                    $other_diseases = [];
                    foreach ($diseases as $disease) {
                        if ($disease['name'] !== $disease_name) {
                            $other_diseases[] = $disease['name'] . " - " . round($disease['probability'] * 100, 2) . "%";
                        }
                    }

                    // Insert into database
                    $inserted = insertDiseaseResult($pdo, $disease_name, $cleaned_response, $uploaded_image_path, $confidence);
                    
                    if (!$inserted) {
                        error_log("Failed to insert disease result into database");
                    }

                    // Store results in session - still use full path for display purposes
                    $_SESSION['results'] = [
                        'disease_name' => $disease_name,
                        'confidence' => $confidence,
                        'cleaned_response' => $cleaned_response,
                        'other_diseases' => $other_diseases,
                        'image_path' => $target_file, // Full path for display
                        'result_html' => $result_html,
                        'disease_result_id' => $inserted
                    ];
                    
                    // Redirect to prevent form resubmission
                    header("Location: ".$_SERVER['PHP_SELF']);  
                    exit();
                } else {
                    $result_html = "<p class='success'>🌿 No disease detected. Your plant is healthy!</p>";
                }
            }
            curl_close($ch);
        } else {
            $result_html = "<p class='error'>❌ Error saving uploaded file.</p>";
        }
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
    <style>
        /* Loading overlay styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            display: none;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #4CAF50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        
        .loading-text {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            color: #333;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Image preview styles */
        .img-container img {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin: 0 auto;
        }
        
        /* Form during loading */
        .form-loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body>

<?php include_once("partials/header.php") ?>

    <form id="uploadForm" action="" method="POST" enctype="multipart/form-data" class="upload-photo">
        <div class="img-container">
            <img id="imagePreview" src="<?= isset($image_path) ? $image_path : '' ?>" 
                 style="<?= isset($image_path) ? '' : 'display:none;' ?>">
        </div>
        <label for="imageInput">Please select an image</label>
        <input type="file" name="plant_image" accept="image/*" id="imageInput" required>
        <button type="submit" class="detect-button">
            <span class="material-symbols-outlined">
                image_search
            </span>
            Detect Disease
        </button>
    </form>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">Analyzing your plant...</div>
    </div>

    <!-- ===================diseases information=================== -->
    <?php if (!empty($disease_name)) : ?>
        <section class="sample-information-container">
            <h1 class="poppins-semibold"><?= htmlspecialchars($disease_name) . " - " . htmlspecialchars($confidence) ?></h1>
            <p><?= $cleaned_response ?></p>

            <div class="diseases">
                <div class="icon-text">
                    <span class="material-symbols-outlined">
                        microbiology
                    </span>
                    Other Diseases
                </div>

                <?php if (!empty($other_diseases)) : ?>
                    <?php foreach($other_diseases as $disease) : ?>
                        <div class="disease expandableText">
                            <div class="name poppins-medium"><?= htmlspecialchars($disease) ?></div>
                        </div>
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </section>
    <?php elseif (!empty($result_html)) : ?>
        <?= $result_html ?>
    <?php endif ?>

    <?php include_once("partials/navigation.php") ?>

    <script>
        // Preview image before upload
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Loading animation handling
        document.getElementById('uploadForm').addEventListener('submit', function() {
            // Show loading overlay
            const loadingOverlay = document.getElementById('loadingOverlay');
            loadingOverlay.style.display = 'flex';
            
            // Disable form during processing
            this.classList.add('form-loading');
        });

        // Hide loading screen if results are already displayed
        window.addEventListener('load', function() {
            if (document.querySelector('.sample-information-container')) {
                document.getElementById('loadingOverlay').style.display = 'none';
            }
        });
    </script>
</body>
</html>