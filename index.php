<?php

session_name('cropcare_session');
session_start();
require 'db/config.php';

$usernameError = "";
$passwordError = "";
$username = "";

if ($_SERVER['REQUEST_METHOD']  === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt =$pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {

            // store user's info in session
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: home.php");
            exit;
            
        } else {
            $passwordError = "wrong password";
            $usernameError = "";
        }

    } else {
        $usernameError = "username not found";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rum+Raisin&display=swap" rel="stylesheet">
    <title>PlantCam</title>
</head>
<body>
   <section class="signin-container">
    <div class="image-container">
        <img src="resrources/signin-bg.png" alt="">
    </div>
    <h1 class="welcome">
        Mabuhay, QCians please log in to your account
    </h1>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username"  value="<?= $usernameError ? '' :  htmlspecialchars($username); ?>" required>
        <small class="error"><?php echo $usernameError; ?></small>

        <input type="password" name="password" placeholder="Password" required>
        <small class="error"><?php echo $passwordError; ?></small>
        
        <small class="forgot-password"><a href="forgot-password.php">Forgot password?</a></small>
        <button class="button-anchor" >Sign In</button>
        <small class="signup-link">Don't have an account?<a href="signup.php"> Sign Up</a></small>
    </form>
   </section>
</body>
</html>