<?php
session_name('cropcare_session');
session_start();
require 'db/config.php';

// // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$disease_info = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM disease_result WHERE disease_result_id = :disease_result_id");
$stmt->execute([':disease_result_id' => $disease_info]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

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
            <img id="imagePreview" src="uploads/<?= htmlspecialchars($result['image']) ?>">
        </div>
    </form>

    <!-- ===================diseases information=================== -->
        <section class="sample-information-container">
            <h1 class="poppins-semibold"><?= htmlspecialchars($result['name']) ?></h1>
            <p><?= $result['result'] ?></p>
        </section>

    <?php include_once("partials/navigation.php") ?>

</body>
</html>