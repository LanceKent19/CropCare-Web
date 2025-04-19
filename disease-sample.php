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

    <section class="sidebar-container">
        <div class="logo-container">
            PLlantCare
        </div>
        <ul>
            <li><a href="home.html"><span class="material-symbols-outlined">home</span>Home</a></li>
            <li><a href="history.html"><span class="material-symbols-outlined">history</span>History</a></li>
            <li><a href="profile.html"><span class="material-symbols-outlined">settings</span>Settings</a></li>
        </ul>
    
    </section>
<!-- ===================header=================== -->
<section class="header">
    <div class="logo poppins-regular">
        PlantCare
    </div>
</section>

    <form action="" method="POST" enctype="multipart/form-data" class="upload-photo sample-disease-form">
        <div class="img-container">
            <img src="resrources/bacterial_leafSpot.jpg" id="imagePreview">
        </div>
        <!-- <input type="file" name="image" accept="image/*" id="imageInput" accept="image/*" required>
        <button type="submit" class="detect-button">
            <span class="material-symbols-outlined">
                image_search
            </span>
            Detect Disease
        </button> -->
    </form>
<!-- ===================sample information=================== -->

<section class="sample-information-container">
    <h1 class="poppins-semibold">Bacterial leaf spot - 70%</h1>
    <p> Creates raised, scabby lesions on fruits and small, angular leaf spots with yellow halos. The bacteria spread rapidly during rainstorms and overhead irrigation.</p>
    <h2 class="poppins-semibold">Prevention</h2>
    <ul>
        <li> Start with Clean Seeds & Seedlings
            Use certified disease-free seeds (hot water treatment at 50°C for 25 minutes can kill bacteria).
        </li>
        <li>Improve Growing Conditions
            Drip irrigation (not overhead watering) to keep leaves dry.

            Proper spacing (60 cm between plants) for better airflow.

            Mulch (rice straw or plastic) to reduce soil splash onto leaves.
        </li>
    </ul>
    <h2 class="poppins-semibold">Treatment</h2>
    <ul>
        <li> Copper-Based Bactericides
            Copper hydroxide (Kocide®) or copper oxychloride sprays every 7–10 days.
             Mix with mancozeb (e.g., Mancozeb + Copper) to improve effectiveness.
        </li>
        <li>. Organic & Home Remedies
            Baking soda spray (1 tbsp baking soda + 1 tsp vegetable oil + 1 liter water) – Reduces bacterial spread.
            Neem oil (acts as an antibacterial and insect repellent).
        </li>
    </ul>

    <div class="diseases">
        <div class="icon-text">
            <span class="material-symbols-outlined">
                microbiology
            </span>
             Other Diseases
        </div>

        <div class="disease expandableText">
            <div class="name poppins-medium">Bacterial Spot -  20%</div>
                Creates raised, scabby lesions on fruits and small, angular leaf spots with yellow halos. The bacteria spread rapidly during rainstorms and overhead irrigation.
        </div>

        <div class="disease expandableText">
            <div class="name poppins-medium">Tomato Leaf Curl Virus  -  15%</div>
                Transmitted by whiteflies, this virus causes severe upward leaf curling, stunting, and dramatically reduced fruit set. Infected plants often produce small, deformed fruits that fail to mature properly.
        </div>

        <div class="disease expandableText">
            <div class="name poppins-medium">Early Blight -  13%</div>
                This aggressive fungus appears as small, dark brown spots with concentric rings on older leaves, eventually causing defoliation. The disease spreads upward, weakening plants and reducing fruit size and yield by up to 50%.
        </div>

        <div class="disease expandableText">
            <div class="name poppins-medium">Fusarium Wilt  -  10%</div>
                This soil-borne pathogen causes yellowing and wilting that typically begins on one side of the plant. Vascular browning is visible when stems are cut open, and the fungus can survive in soil for over 10 years.
        </div>

    </div>
</section>


    <!-- ===================navigation=================== -->
    <div class="navigation">

        <a href="history.html" class="nav-item">
            <span class="material-symbols-outlined">
                history
            </span>
            <div class="text">
                History
            </div>
        </a>
        
        <a href="home.html" class="nav-item">
            <span class="material-symbols-outlined">
                home
            </span>
            <div class="text">
                Home
            </div>
        </a>
        
        <a href="profile.html" class="nav-item">
            <span class="material-symbols-outlined">
                settings
            </span>
            <div class="text">
                Settings
            </div>
        </a>
        
    </div>
        

    <script src="script.js"></script>
    <script>
        document.querySelectorAll(".expandableText").forEach(element => {
             element.addEventListener("click", function() {
                 this.classList.toggle("expanded");
             });
         });
 
     </script>
</body>
</html>