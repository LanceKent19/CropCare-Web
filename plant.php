<?php
session_name('cropcare_session');
session_start();
require 'db/config.php';

// // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$plant_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM plants WHERE plant_id = :plant_id");
$stmt->execute([":plant_id" => $plant_id]);
$plant = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT
* FROM plant_disease_joint pd 
JOIN diseases d ON pd.disease_id = d.disease_id
WHERE plant_id = :plant_id");
$stmt->execute([":plant_id" => $plant_id]);
$diseases = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
        :root {
            --primary-color: #00c507;
            --primary-dark: #00a005;
            --primary-light: #e5ffe6;
            --text-color: #333;
            --light-gray: #f8f8f8;
            --white: #ffffff;
            --border-radius: 16px;
            --border-radius-sm: 12px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 10px;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 5px;
        }

        .subtitle {
            color: #666;
            font-size: 16px;
        }

        .faq-container {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 10px;
        }

        .faq-section {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .faq-section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-title .material-symbols-outlined {
            margin-right: 10px;
            font-size: 22px;
        }

        .disease-informations {
            background: var(--light-gray);
            border-radius: var(--border-radius-sm);
            margin-bottom: 15px;
            overflow: hidden;
            transition: var(--transition);
        }

        .disease-informations:last-child {
            margin-bottom: 0;
        }

        .disease-name {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
        }

        .disease-name:hover {
            background: rgba(0, 197, 7, 0.05);
        }

        .disease-name .material-symbols-outlined {
            font-size: 20px;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            font-size: 15px;
            color: #555;
            line-height: 1.7;
        }

        .disease-informations.active .disease-name {
            color: var(--primary-dark);
        }

        .disease-informations.active .disease-name .material-symbols-outlined {
            transform: rotate(180deg);
        }

        .disease-informations.active .faq-answer {
            padding: 0 20px 20px;
            max-height: 500px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            padding: 12px 20px;
            background: var(--white);
            color: var(--primary-dark);
            border-radius: var(--border-radius-sm);
            text-decoration: none;
            font-weight: 500;
            box-shadow: var(--shadow);
            transition: var(--transition);
            margin-top: 20px;
        }

        .back-btn:hover {
            background: var(--primary-light);
        }

        .back-btn .material-symbols-outlined {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .disease-name {
                padding: 15px;
            }

            .faq-answer {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php include_once("partials/header.php") ?>

    <!-- ===================plant=================== -->
     <section class="plant">

        <div class="name-classification">
            <div class="name poppins-medium"><?= htmlspecialchars($plant['name']) ?></div>
        </div>

        <div class="image-container">
            <img src="/resrources/<?= htmlspecialchars($plant['image']) ?>" alt="">
        </div>

        <div class="about">

            <div class="icon-text">
                <span class="material-symbols-outlined">
                    info
                </span>
                Info
            </div>

            <div class="text" ><?= htmlspecialchars($plant['description']) ?></div>

        </div>

        <?php if (!empty($diseases)) : ?>
            <div class="diseases">
                <div class="icon-text">
                    <span class="material-symbols-outlined">
                        microbiology
                    </span>
                    Diseases
                </div>

                <?php foreach ($diseases as $disease) : ?>
                  

                    <div class="faq-container">
                        <div class="faq-section">                        
                            <div class="disease-informations">
                                <div class="disease-name">
                                    <?= htmlspecialchars($disease['name']) ?>
                                    <span class="material-symbols-outlined">expand_more</span>
                                </div>
                               
                                <div class="faq-answer">
                                     <p><?= htmlspecialchars($disease['description']) ?></p>
                                    <br>
                                    <div class="img-container-disease">
                                        <img src="/resrources/<?= htmlspecialchars($disease['image']) ?>" alt="">
                                    </div>
                                    <br>
                                    <p class="poppins-semibold">Prevention</p>
                                    <p><?= htmlspecialchars($disease['prevention']) ?></p>
                                    <br>
                                    <p class="poppins-semibold">Solution</p>
                                    <p><?= htmlspecialchars($disease['solution']) ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach ?>

              


            </div>
        <?php endif ?>

     </section>
     
     


    <!-- ===================navigation=================== -->

    <?php include_once("partials/navigation.php") ?>


        

    <script src="script.js"></script>
    <script>
        document.querySelectorAll('.disease-name').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentNode;
                item.classList.toggle('active');
                
                // Close other open items in the same section
                const section = item.parentNode;
                section.querySelectorAll('.disease-informations').forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
            });
        });

    </script>
</body>
</html>