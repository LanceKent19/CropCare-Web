<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CropCare</title>
    <link rel="icon" type="image/svg+xml" href="resrources/logo.svg">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
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
            margin-bottom: 30px;
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

        .faq-item {
            background: var(--light-gray);
            border-radius: var(--border-radius-sm);
            margin-bottom: 15px;
            overflow: hidden;
            transition: var(--transition);
        }

        .faq-item:last-child {
            margin-bottom: 0;
        }

        .faq-question {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
            transition: var(--transition);
        }

        .faq-question:hover {
            background: rgba(0, 197, 7, 0.05);
        }

        .faq-question .material-symbols-outlined {
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

        .faq-item.active .faq-question {
            color: var(--primary-dark);
        }

        .faq-item.active .faq-question .material-symbols-outlined {
            transform: rotate(180deg);
        }

        .faq-item.active .faq-answer {
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

            .faq-question {
                padding: 15px;
            }

            .faq-answer {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">CropCare</div>
            <h1>Frequently Asked Questions</h1>
            <p class="subtitle">Find answers to common questions about our service</p>
        </header>

        <div class="faq-container">
            <div class="faq-section">
                <div class="section-title">
                    <span class="material-symbols-outlined">help</span>
                    General Questions
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What is CropCare?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>CropCare is a comprehensive plant monitoring system that helps you track your plants' health, watering needs, and growth progress. Our system uses smart sensors and AI to provide personalized care recommendations for your plants.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How does CropCare work?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our system consists of three main components:</p>
                        <ol>
                            <li>Smart sensors that monitor soil moisture, light levels, and temperature</li>
                            <li>A mobile app that displays your plants' data and health status</li>
                            <li>AI-powered recommendations for optimal plant care</li>
                        </ol>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What plants are supported?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>CropCare currently supports over 200 common houseplants including:</p>
                        <ul>
                            <li>Succulents and cacti</li>
                            <li>Tropical plants (Monstera, Pothos, etc.)</li>
                            <li>Flowering plants (Orchids, African Violets)</li>
                            <li>Herbs and small vegetables</li>
                        </ul>
                        <p>We're constantly adding support for more plant types.</p>
                    </div>
                </div>
            </div>

            <div class="faq-section">
                <div class="section-title">
                    <span class="material-symbols-outlined">devices</span>
                    Device Setup
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How do I set up my CropCare device?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>Setting up your device is simple:</p>
                        <ol>
                            <li>Download the CropCare app from the App Store or Google Play</li>
                            <li>Create an account or log in</li>
                            <li>Insert the sensor into your plant's soil</li>
                            <li>Follow the in-app instructions to pair your device</li>
                            <li>Select your plant type from our database</li>
                        </ol>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How far can the sensor be from my phone?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>The sensor uses Bluetooth Low Energy (BLE) with a range of approximately 30 feet (10 meters) indoors. For continuous monitoring, we recommend keeping your plant within 20 feet of your smartphone or using our optional hub for whole-home coverage.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How often should I charge the sensor?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our sensors have a battery life of approximately 6 months with normal use. The app will notify you when battery levels are low. Charging takes about 2 hours using the included USB cable.</p>
                    </div>
                </div>
            </div>

            <div class="faq-section">
                <div class="section-title">
                    <span class="material-symbols-outlined">water_drop</span>
                    Crop Care
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        How accurate are the watering recommendations?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our watering recommendations are 95% accurate for supported plant types. The system considers:</p>
                        <ul>
                            <li>Soil moisture levels</li>
                            <li>Plant type and size</li>
                            <li>Current environmental conditions</li>
                            <li>Seasonal variations</li>
                        </ul>
                        <p>We recommend observing your plant's response for the first few weeks and adjusting the sensitivity in the app if needed.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What should I do if my plant isn't doing well?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>If your plant shows signs of distress:</p>
                        <ol>
                            <li>Check the app for any alerts or recommendations</li>
                            <li>Verify the sensor is properly inserted in the soil</li>
                            <li>Review the plant's care requirements in our database</li>
                            <li>Try moving the plant to a different location</li>
                            <li>Contact our plant care specialists through the app if issues persist</li>
                        </ol>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Can I use CropCare for outdoor plants?
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our standard sensors are designed for indoor use only. We offer weather-resistant outdoor sensors as a separate purchase. These can withstand rain and temperature fluctuations while providing the same accurate monitoring for your garden or patio plants.</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="profile.php" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Profile
        </a>
    </div>

    <script>
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentNode;
                item.classList.toggle('active');
                
                // Close other open items in the same section
                const section = item.parentNode;
                section.querySelectorAll('.faq-item').forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>