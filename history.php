<?php
session_name('cropcare_session');
session_start();
require 'db/config.php';

// // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD']  === 'POST') {
    $disease_id = trim($_POST['disease_id']);

    $stmt =$pdo->prepare("DELETE FROM disease_result WHERE disease_result_id = :disease_result_id");
    $stmt->execute([':disease_result_id' => $disease_id]);

    header( "location: history.php");
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM disease_result WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$histories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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


    <!-- ===================navigation=================== -->
     <section class="history">
        <div class="icon-text">
            <span class="material-symbols-outlined">
                history
            </span>
            History
        </div>

        <div class="cards-container">
            <?php if (!empty($histories)) : ?>
                <?php foreach ($histories as $history) : ?>
                    <div class="card">
                        <form action="" method="POST">
                            <div class="delete-icon">
                                <input type="hidden" name="disease_id" value="<?= htmlspecialchars($history['disease_result_id']) ?>">
                                <button type="submit">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </button>
                                
                            </div>
                        </form>
                        
                        <div class="date poppins-semibold"><?= htmlspecialchars(date('F j, Y', strtotime($history['created_at']))) ?></div>
                        <div class="card-container">
                            <div class="img-container">
                                <img src="uploads/<?= htmlspecialchars($history['image']) ?>" alt="">
                            </div>
                            <a href="history-page.php?id=<?= htmlspecialchars($history['disease_result_id']) ?>" class="text-container">
                                <div class="disease-name"><?= htmlspecialchars($history['name']) ?></div>
                                <div class="disease-description"><?= ($history['result']) ?></div>
                            </a>
                        </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="no-history-container">
                    <p class="poppins-medium">Why So Empty?</p>
                    <div class="img-container">
                        <img src="resrources/lazy-cat.png" alt="">
                    </div>
                </div>
                
            <?php endif; ?>


        </div>
     </section>

  


    <!-- ===================navigation=================== -->

    <?php include_once("partials/navigation.php") ?>

    <script src="script.js"></script>
</body>
</html>