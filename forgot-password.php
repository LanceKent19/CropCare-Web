<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CropCare</title>
    <link rel="icon" type="image/svg+xml" href="resrources/logo.svg">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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

        .contact-container {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .contact-methods {
            display: flex;
            flex-wrap: wrap;
        }

        .contact-card {
            flex: 1 1 300px;
            text-align: center;
            transition: var(--transition);
        }

        .contact-card:hover {
            background: var(--primary-light);
        }

        .contact-icon {
            background: var(--primary-light);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: var(--primary-dark);
            font-size: 28px;
        }

        .contact-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-dark);
        }

        .contact-info {
            color: #666;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .contact-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            margin-top: 5px;
            transition: var(--transition);
        }

        .contact-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .contact-form-container {
            background: var(--light-gray);
            border-radius: var(--border-radius-sm);
            margin-top: 20px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
        }

        .form-title .material-symbols-outlined {
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius-sm);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            transition: var(--transition);
            background: transparent;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(0, 197, 7, 0.2);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: var(--border-radius-sm);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            transition: var(--transition);
        }

        .submit-btn:hover {
            background-color: var(--primary-dark);
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

            .contact-card {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">CropCare</div>
            <h1>Forgot Password?</h1>
            <p class="subtitle">Enter the email address you used when you joined and we’ll send you instructions to reset your password.</p>
        </header>

        <div class="contact-container">

            <div class="contact-form-container">
                <form id="contactForm" method="POST" action="send-reset-link.php">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>

        <a href="index.php" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Log In
        </a>
    </div>

  
</body>
</html>