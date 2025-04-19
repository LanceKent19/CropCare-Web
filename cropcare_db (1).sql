-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 08:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cropcare_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `disease_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prevention` varchar(255) DEFAULT NULL,
  `solution` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`disease_id`, `name`, `description`, `prevention`, `solution`, `image`) VALUES
(1, 'Late Blight', 'A fungal disease that affects potatoes and tomatoes, causing dark spots on leaves and fruit rot.', 'Use resistant varieties and avoid overhead watering.', 'Apply fungicides and remove infected plants.', 'late-blight.jpg'),
(2, 'Powdery Mildew', 'A white or gray powdery growth on leaves and stems caused by fungal spores.', 'Ensure good air circulation and avoid high humidity.', 'Use sulfur-based fungicides or neem oil.', 'powdery-mildew.jpg'),
(3, 'Leaf Spot', 'Brown or black spots appear on leaves due to fungal or bacterial infection.', 'Avoid wetting the foliage and remove debris around plants.', 'Apply appropriate fungicide and remove affected leaves.', 'leaf-spot.jpg'),
(4, 'Root Rot', 'Caused by overwatering and poor drainage, leading to decayed roots and plant wilting.', 'Use well-draining soil and avoid excessive watering.', 'Remove infected roots and treat soil with fungicide.', 'root-rot.jpg'),
(5, 'Bacterial Wilt', 'Causes sudden wilting and yellowing of leaves due to bacterial infection.', 'Control insect vectors and use resistant varieties.', 'Remove and destroy infected plants immediately.', 'bacterial-wilt.jpg'),
(6, 'Downy Mildew', 'Causes yellow patches and fuzzy growth on the undersides of leaves.', 'Ensure good air flow and water early in the day.', 'Use copper-based fungicides and remove infected leaves.', 'downy-mildew.jpg'),
(7, 'Anthracnose', 'Dark, sunken lesions on fruits, stems, and leaves caused by fungal pathogens.', 'Plant resistant varieties and use crop rotation.', 'Apply fungicides at early signs and prune infected parts.', 'anthracnose.jpg'),
(8, 'Mosaic Virus', 'Causes mottled patterns on leaves and stunted growth.', 'Control aphids and other insect carriers.', 'Remove and destroy infected plants; no cure exists.', 'mosaic-virus.jpg'),
(9, 'Rust', 'Orange or rust-colored spots on leaves caused by fungi.', 'Avoid overhead watering and plant resistant varieties.', 'Apply fungicides and remove infected leaves.', 'rust.jpg'),
(10, 'Fusarium Wilt', 'Fungal disease that causes yellowing and wilting, particularly in tomatoes.', 'Use resistant varieties and rotate crops.', 'Remove infected plants and treat soil with fungicides.', 'furasium-wilt.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `disease_result`
--

CREATE TABLE `disease_result` (
  `disease_result_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `result` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `other_disease_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disease_result`
--

INSERT INTO `disease_result` (`disease_result_id`, `name`, `result`, `image`, `other_disease_id`, `user_id`, `created_at`) VALUES
(8, 'Abiotic', 'Abiotic Plant Disorders (Non-Infectious Diseases)  <br />\nAbiotic disorders are plant problems caused by non-living (environmental, chemical, or physical) factors rather than pathogens (bacteria, fungi, viruses, etc.).  <br />\n• --<br />\n<br />\nCommon Causes & Symptoms  <br />\n<br />\n1. Environmental Stressors  <br />\n• Drought: Wilting, leaf scorch, stunted growth.  <br />\n• Excess Water (Waterlogging): Yellowing leaves, root rot, poor growth.  <br />\n• Temperature Extremes:  <br />\n• Heat: Leaf burn, wilting, sunscald.  <br />\n• Cold/Frost: Blackened leaves, dieback, cracked bark.  <br />\n<br />\n2. Soil & Nutrient Issues  <br />\n• Poor Soil pH (Too Acidic/Alkaline): Nutrient lockout, yellowing (chlorosis).  <br />\n• Nutrient Deficiencies:  <br />\n• Nitrogen (N): Yellow older leaves.  <br />\n• Phosphorus (P): Purple/reddish leaves, stunted growth.  <br />\n• Potassium (K): Brown leaf edges, weak stems.  <br />\n• Salt Toxicity (Fertilizer/Water): Leaf burn, white crust on soil.  <br />\n<br />\n3. Chemical Damage  <br />\n• Herbicide/Pesticide Overuse: Leaf curling, discoloration, death.  <br />\n• Air Pollution: Ozone damage (stippling, bronzing).  <br />\n<br />\n4. Physical Damage  <br />\n• Mechanical Injury: Broken stems, bark damage.  <br />\n• Compacted Soil: Poor root growth, water runoff.  <br />\n• --<br />\n<br />\nTreatment & Prevention  <br />\n<br />\n1. Correct Environmental Issues  <br />\n• Watering: Adjust irrigation (deep watering for drought, improve drainage for waterlogging).  <br />\n• Temperature Protection: Use mulch, shade cloth, or frost covers.  <br />\n<br />\n2. Improve Soil Health  <br />\n• Test soil pH & amend (lime for acidic, sulfur for alkaline soils).  <br />\n• Use balanced fertilizers & organic matter (compost).  <br />\n<br />\n3. Avoid Chemical Stress  <br />\n• Follow label instructions for pesticides/fertilizers.  <br />\n• Flush soil with water if salt buildup occurs.  <br />\n<br />\n4. Physical Care  <br />\n• Avoid root disturbance, aerate compacted soil.  <br />\n• Prune damaged tissue carefully.  <br />\n• --<br />\n<br />\nKey Takeaway  <br />\nAbiotic disorders are preventable with proper plant care. Monitor growing conditions, test soil, and adjust practices to reduce stress. Unlike infectious diseases, they do not spread but can weaken plants, making them susceptible to pathogens.  <br />\n<br />\nWould you like help diagnosing a specific issue?', '67f798c8e0440.jpg', NULL, 2, '2025-04-10 10:09:46'),
(11, 'Fungi', 'Fungal Plant Diseases: Overview, Symptoms, Treatments & Prevention  <br />\n<br />\nFungal diseases are among the most common plant pathogens, affecting foliage, roots, stems, and fruits. They thrive in humid, warm conditions and spread via spores.  <br />\n<br />\nCommon Symptoms of Fungal Infections  <br />\n• Leaf Spots (circular, discolored lesions, often with yellow halos)  <br />\n• Powdery Mildew (white, powdery coating on leaves)  <br />\n• Downy Mildew (yellow patches on top, fuzzy gray growth underneath)  <br />\n• Rust (orange, brown, or yellow pustules on leaves/stems)  <br />\n• Root Rot (wilting, dark mushy roots, stunted growth)  <br />\n• Blight (rapid wilting, dark lesions on leaves/stems)  <br />\n• Anthracnose (sunken, dark spots on leaves/fruits)  <br />\n<br />\nTreatment Options  <br />\n1. Fungicides  <br />\n• Copper-based (for blights, anthracnose)  <br />\n• Sulfur-based (powdery mildew, rust)  <br />\n• Systemic fungicides (e.g., azoxystrobin, tebuconazole for severe cases)  <br />\n<br />\n2. Organic/Natural Remedies  <br />\n• Neem oil (broad-spectrum antifungal)  <br />\n• Baking soda spray (1 tbsp baking soda + 1 tsp oil + 1 gallon water for mildew)  <br />\n• Hydrogen peroxide (diluted for root rot)  <br />\n<br />\n3. Cultural Practices  <br />\n• Remove and destroy infected plant parts.  <br />\n• Improve air circulation (prune dense foliage).  <br />\n• Avoid overhead watering (use drip irrigation).  <br />\n<br />\nPrevention Methods  <br />\n• Plant Resistant Varieties (when available).  <br />\n• Crop Rotation (prevents soil-borne fungi buildup).  <br />\n• Sterilize Tools (prevent cross-contamination).  <br />\n• Proper Spacing (reduces humidity around plants).  <br />\n• Mulching (prevents soil splashback onto leaves).  <br />\n• Water Early (allows leaves to dry before night).  <br />\n<br />\nKey Takeaway  <br />\nFungal diseases spread quickly but can be managed with early detection, proper sanitation, and preventive care. If infections persist, targeted fungicides may be necessary.  <br />\n<br />\nWould you like details on a specific fungal disease?', '67ff2e53bde5e.jpg', NULL, 1, '2025-04-16 04:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE `plants` (
  `plant_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`plant_id`, `name`, `description`, `image`) VALUES
(1, 'Tomato', 'Tomatoes are warm-season annuals that thrive in full sun and well-drained, fertile soil. They prefer daytime temperatures between 70–85°F (21–29°C) and night temperatures above 55°F (13°C). Tomatoes require consistent watering, especially during fruiting,', 'tomato.jpg'),
(2, 'Potato', 'Potatoes grow best in cool climates with full sun and loose, well-drained soil rich in organic matter. They prefer temperatures between 60–70°F (15–21°C). Hill the soil around the stems as the plant grows to protect tubers from sunlight and encourage bett', 'potato.jpg'),
(3, 'Eggplant', 'Eggplants thrive in hot weather and need full sunlight for at least 6–8 hours a day. They grow well in rich, well-drained soil with a pH between 5.5 and 7.0. Ideal growing temperatures are 70–85°F (21–29°C) with moderate to high humidity. Water deeply and', 'eggplant.jpg'),
(4, 'Bell Pepper', 'Bell peppers prefer a long growing season with warm days and cool nights. They need full sun and fertile, well-drained soil with a pH between 6.0 and 6.8. Keep the soil evenly moist but not soggy, and mulch to retain moisture and control weeds. Temperatur', 'bell-pepper.jpg'),
(5, 'Chili', 'Chili peppers grow best in warm, sunny climates with temperatures between 75–85°F (24–29°C). They require full sun and well-drained, sandy-loam soil with good organic content. Keep soil moist but not waterlogged; overwatering can stress the plants. Chili ', 'chili-pepper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `plant_disease_joint`
--

CREATE TABLE `plant_disease_joint` (
  `plant_disease_id` int(11) NOT NULL,
  `plant_id` int(11) DEFAULT NULL,
  `disease_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plant_disease_joint`
--

INSERT INTO `plant_disease_joint` (`plant_disease_id`, `plant_id`, `disease_id`) VALUES
(1, 1, 1),
(2, 1, 10),
(3, 1, 5),
(4, 1, 7),
(5, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Ronan', 'Sanico', 'firstuser', 'firstuser@gmail.com', '$2y$10$jFnwj.rh9YQiCkyA1BidOu4Fi/4FZY4qiLOZcCSUT4yI7PfyhL9vS', '2025-04-09 11:52:44'),
(2, NULL, NULL, 'sample', 'sampleemail@gmail.com', '$2y$10$7TZGdroXvxI6zKG/khJdWOurdGdinbDKOi9hJrR6Ny3vJbjBSxlXG', '2025-04-10 10:08:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`disease_id`);

--
-- Indexes for table `disease_result`
--
ALTER TABLE `disease_result`
  ADD PRIMARY KEY (`disease_result_id`),
  ADD KEY `fk_other_disease` (`other_disease_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`plant_id`);

--
-- Indexes for table `plant_disease_joint`
--
ALTER TABLE `plant_disease_joint`
  ADD PRIMARY KEY (`plant_disease_id`),
  ADD KEY `plant_id` (`plant_id`),
  ADD KEY `disease_id` (`disease_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `disease_result`
--
ALTER TABLE `disease_result`
  MODIFY `disease_result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `plant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `plant_disease_joint`
--
ALTER TABLE `plant_disease_joint`
  MODIFY `plant_disease_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `disease_result`
--
ALTER TABLE `disease_result`
  ADD CONSTRAINT `fk_other_disease` FOREIGN KEY (`other_disease_id`) REFERENCES `other_disease` (`other_disease_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `plant_disease_joint`
--
ALTER TABLE `plant_disease_joint`
  ADD CONSTRAINT `plant_disease_joint_ibfk_1` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`plant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `plant_disease_joint_ibfk_2` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`disease_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
