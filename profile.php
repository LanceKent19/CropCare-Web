<?php
session_name('cropcare_session');
session_start();
require 'db/config.php';

// // Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute([":user_id" => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$error = "";
// Fetch user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

$user_fname = $userData['fname'];
$user_lname = $userData['lname'];
$user_name = $userData['username'];
$user_email = $userData['email'];

$error = "";
$usernameError = "";
$emailError = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Convert empty inputs to NULL
    $firstname = $firstname === "" ? NULL : $firstname;
    $lastname = $lastname === "" ? NULL : $lastname;

    // Check if username exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND user_id != :user_id");
    $stmt->execute([
        ':username' => $username,
        ':user_id' => $_SESSION['user_id']
    ]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND user_id != :user_id");
    $stmt->execute([
        ':email' => $email,
        ':user_id' => $_SESSION['user_id']
    ]);
    $userEmail = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $usernameError = "Username is already in use";
    } else if ($userEmail) {
        $usernameError = "Email already exists";
    } else {
        $stmt = $pdo->prepare("UPDATE users SET fname = :firstname, lname = :lastname, username = :username, email = :email
            WHERE user_id = :user_id");
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':username' => $username,
            ':user_id' => $_SESSION['user_id'],
            ':email' => $email
        ]);

        header("Location: profile.php");
        exit;
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
        /* Add these styles to your existing CSS */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: flex-end;
        }

        * {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Add a subtle scale effect to the close button */
        .close-modal {
            transition: transform 0.2s ease;
        }

        .close-modal:hover {
            transform: scale(1.2);
            color: #00c507;
        }

        /* Error message animation */
        .error {
            display: block;
            color: #ff4444;
            height: 0;
            overflow: hidden;
            transition: height 0.3s ease;
            margin-bottom: 0;
        }

        .error.show {
            height: 20px;
            margin-bottom: 15px;
        }

        .account-modal {
            background-color: white;
            width: 100%;
            max-height: 80vh;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 20px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transform: translateY(100%);
            transition: transform 0.3s ease-out;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-overlay.active .account-modal {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .save-btn {
            background-color: #00c507;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-size: 1rem;
            margin-top: 10px;
            cursor: pointer;
        }

        .save-btn:hover {
            background-color: #00a005;
        }
    </style>
</head>
<body>


<?php include_once("partials/header.php") ?>

    <!-- ===================PROFILE CONTAINER=================== -->
    <section class="profile-container">
        <div class="profile-background"></div>

        <div class="image-info-container">
            <div class="image-container">
                <img src="resrources/default_profile.jpg" alt="">
            </div>
            <div class="info-container">
                <div class="username"><?= htmlspecialchars($user['username']) ?></div>
                <small><?= htmlspecialchars($user['email']) ?></small>
            </div>
        </div>

        <div class="settings-container">
            <div class="settings poppins-medium" id="accountSettingsBtn">
                <span class="material-symbols-outlined">
                    person
                </span>
                Update Account
            </div>
            <a href="faq.php" class="settings poppins-medium">
                <span class="material-symbols-outlined">
                    live_help
                </span>
                Frequently Asked Questions
            </a>
            <a href="message-us.php" class="settings poppins-medium">
                <span class="material-symbols-outlined">
                    forum
                </span>
                Get In Touch With Us
            </a>
            <a href="terms-of-use.php" class="settings poppins-medium">
                <span class="material-symbols-outlined">
                    policy
                </span>
                Terms Of Use
            </a>
        </div>

        <a href="logout.php" class="logout-btn">
            <span class="material-symbols-outlined">
                logout
            </span>
            Sign Out
        </a>

    </section>

    <!-- ===================navigation=================== -->

    <?php include_once("partials/navigation.php") ?>

    
    <!-- Account Settings Modal -->
    <div class="modal-overlay" id="accountModal">
        <div class="account-modal">
            <div class="modal-header">
                <div class="modal-title">Update Account </div>
                <button class="close-modal" id="closeModal">&times;</button>
            </div>
            <form method="POST" id="accountForm">
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstname" value="<?= htmlspecialchars($user['fname']) ?>" placeholder="Enter Firstname">
                </div>
                <small></small>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastname" value="<?= htmlspecialchars($user['lname']) ?>" placeholder="Enter lastname">
                </div>
                <small></small>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <small class="error"><?= $usernameError; ?></small>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"  required>
                </div>
                <small class="error"><?= $emailError; ?></small>
                <button type="submit" class="save-btn">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        const accountSettingsBtn = document.getElementById('accountSettingsBtn');
        const accountModal = document.getElementById('accountModal');
        const closeModal = document.getElementById('closeModal');
        const accountForm = document.getElementById('accountForm');

        accountSettingsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            accountModal.style.display = 'flex';
            setTimeout(() => {
                accountModal.classList.add('active');
            }, 10); 
            document.body.style.overflow = 'hidden';
        });

        function closeModalFunction() {
            accountModal.classList.remove('active');
            setTimeout(() => {
                accountModal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300); 
        }

        closeModal.addEventListener('click', closeModalFunction);

        accountModal.addEventListener('click', function(e) {
            if (e.target === accountModal) {
                closeModalFunction();
            }
        });

        // Add animation to form inputs when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-group input');
            inputs.forEach((input, index) => {
                // Set a small delay for each input to create a staggered effect
                input.style.transitionDelay = `${index * 0.05}s`;
            });
        });

        // Add animation to form submission
        accountForm.addEventListener('submit', function(e) {
            const saveBtn = this.querySelector('.save-btn');
            saveBtn.textContent = 'Saving...';
            saveBtn.style.backgroundColor = '#008a05';
            
            // You could add additional animations here for successful save
        });

        document.querySelectorAll(".expandableText").forEach(element => {
            element.addEventListener("click", function() {
                this.classList.toggle("expanded");
            });
        });

        <?php if (!empty($usernameError)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                const errorElement = document.querySelector('.error');
                errorElement.classList.add('show');
            });
        <?php endif; ?>
    </script>
</body>
</html>