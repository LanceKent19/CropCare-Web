<?php
require 'db/config.php';
$error = "";
$emailError = "";
$usernameError = "";
$passwordError = "";
$email = $username = $password = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if email and username exist
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
    $stmt->execute([':email' => $email, ':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['email'] === $email) {
            $emailError = "Email is already in use";
            $email = "";
        }
        if ($user['username'] === $username) {
            $usernameError = "Username is already in use";
            $username = "";
        }
    }

    // Check if password meets requirements
    if (strlen($password) < 8) {
        $passwordError = "Password must be at least 8 characters long";
    } elseif ($password !== $confirm_password) {
        $passwordError = "Passwords do not match";
    }

    // Insert data if no error is found
    if (!$emailError && !$usernameError && !$passwordError) {
        // Hash password 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $stmt->execute([
            ':email' => $email,
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
        header("Location: index.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rum+Raisin&display=swap" rel="stylesheet">
    <title>PlantCam</title>
</head>
<body>
   <section class="signin-container">
    <div class="image-container">
        <img src="resrources/signup-bg.png" alt="">
    </div>
    <h1 class="welcome">
        Mabuhay, QCians please create your account
    </h1>
    <form  method="POST">
        <input type="email" name="email" placeholder="Email" value="<?= $emailError ? '' :  htmlspecialchars($email); ?>" required >
        <small class="error"><?php echo $emailError; ?></small>

        <input type="text" name="username" placeholder="Username" value="<?= $emailError ? '' :  htmlspecialchars($username); ?>" >
        <small class="error"><?php echo $usernameError; ?></small>

        <input type="password" name="password" placeholder="Password" required >
        <small class="error"></small>

        <input type="password" name="confirm_password" placeholder="Confirm Password" >
        <small class="error"><?php echo $passwordError; ?></small>

        <button type="submit" class="button-anchor">Sign Up</button>
        <small class="signup-link">Already have an account?<a href="index.php"> Sign In</a></small>
    </form>
   </section>
</body>
</html>