-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2021 at 05:09 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pettertogether`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartId`, `userId`, `total`) VALUES
(18, 7, 0),
(19, 30, 0),
(20, 55, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `cartItemId` int(11) NOT NULL,
  `petId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `cartId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cartitem`
--

INSERT INTO `cartitem` (`cartItemId`, `petId`, `productId`, `cartId`, `quantity`, `subtotal`, `status`) VALUES
(65, NULL, 27, 18, 2, 43.8, 0),
(78, NULL, 27, 20, 1, 21, 0),
(79, NULL, 2, 20, 1, 20, 0),
(80, NULL, 25, 20, 10, 722, 0),
(81, NULL, 3, 20, 10, 205, 0),
(82, NULL, 20, 20, 2, 39, 0),
(83, NULL, 2, 20, 3, 61, 0),
(84, NULL, 2, 20, 25, 512, 0),
(85, NULL, 3, 20, 10, 205, 0),
(86, NULL, 1, 20, 1, 25, 0),
(87, NULL, 1, 20, 1, 25, 0),
(89, NULL, 2, 20, 5, 102, 0),
(91, NULL, 26, 20, 1, 50, 0),
(97, NULL, 25, 18, 1, 72.2, 0),
(98, 6, NULL, 18, 1, 2800, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `orderItemId` int(11) NOT NULL,
  `petId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `orderId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`orderItemId`, `petId`, `productId`, `orderId`, `quantity`, `subtotal`) VALUES
(18, 6, NULL, 11, 1, 2800),
(19, NULL, 27, 11, 2, 43.8),
(20, NULL, 25, 11, 1, 72.2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `paymentMethod` varchar(255) NOT NULL,
  `deliveryMethod` varchar(255) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `paymentMethod`, `deliveryMethod`, `paymentDate`, `total`) VALUES
(11, 7, 'Banking - Maybank', 'J&T', '2021-11-13 16:26:39', 2931);

-- --------------------------------------------------------

--
-- Table structure for table `petcategory`
--

CREATE TABLE `petcategory` (
  `petCatId` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petcategory`
--

INSERT INTO `petcategory` (`petCatId`, `category`, `description`) VALUES
(1, 'Dog', 'Man\'s best friend will be by your side whether you\'re having a good day or down in the dumps. Their playfulness and affection will surely cheer you up. '),
(2, 'Cat', 'These felines are for those who want a more elegant and sophisticated companion to join their family. Their affection will help make every day a brighter one for you.'),
(3, 'Hamster', 'These little furballs are literal balls of joy when raised by owners in a loving environment. You\'ll find it fun to watch and take care of them.');

-- --------------------------------------------------------

--
-- Table structure for table `petimage`
--

CREATE TABLE `petimage` (
  `petImageId` int(11) NOT NULL,
  `petId` int(11) NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `imageType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petimage`
--

INSERT INTO `petimage` (`petImageId`, `petId`, `imageName`, `imagePath`, `imageType`) VALUES
(1, 1, 'Husky_1_Card_319_409', './Images/Dog/Husky/Card/Husky_1_Card_319_409.jpg', 'Card'),
(2, 1, 'Husky_1_Gallery_550_550', './Images/Dog/Husky/Gallery/Husky_1_Gallery_550_550.jpg', 'Gallery'),
(3, 1, 'Husky_2_Gallery_550_550', './Images/Dog/Husky/Gallery/Husky_2_Gallery_550_550.jpg', 'Gallery'),
(6, 2, 'Poodle_1_Card_319_409', './Images/Dog/Poodle/Card/Poodle_1_Card_319_409.jpg', 'Card'),
(7, 2, 'Poodle_1_Gallery_550_550', './Images/Dog/Poodle/Gallery/Poodle_1_Gallery_550_550.jpg', 'Gallery'),
(8, 2, 'Poodle_2_Gallery_550_550', './Images/Dog/Poodle/Gallery/Poodle_2_Gallery_550_550.jpg', 'Gallery'),
(11, 3, 'Retriever_1_Card_319_409', './Images/Dog/Retriever/Card/Retriever_1_Card_319_409.jpg', 'Card'),
(12, 3, 'Retriever_1_Gallery_550_550', './Images/Dog/Retriever/Gallery/Retriever_1_Gallery_550_550.jpg', 'Gallery'),
(13, 3, 'Retriever_2_Gallery_550_550', './Images/Dog/Retriever/Gallery/Retriever_2_Gallery_550_550.jpg', 'Gallery'),
(16, 4, 'Rottweiler_Card_319_409', './Images/Dog/Rottweiler/Card/Rottweiler_Card_319_409.jpg', 'Card'),
(17, 4, 'Rottweiler_Gallery_550_550', './Images/Dog/Rottweiler/Gallery/Rottweiler_Gallery_550_550.jpg', 'Gallery'),
(19, 5, 'Shih_Tzu_1_Card_319_409', './Images/Dog/Shih_Tzu/Card/Shih_Tzu_1_Card_319_409.jpg', 'Card'),
(20, 5, 'Shih_Tzu_1_Gallery_550_550', './Images/Dog/Shih_Tzu/Gallery/Shih_Tzu_1_Gallery_550_550.jpg', 'Gallery'),
(22, 6, 'Bengal_1_Card_319_409', './Images/Cat/Bengal/Card/Bengal_1_Card_319_409.jpg', 'Card'),
(23, 6, 'Bengal_1_Gallery_550_550', './Images/Cat/Bengal/Gallery/Bengal_1_Gallery_550_550.jpg', 'Gallery'),
(24, 6, 'Bengal_2_Gallery_550_550', './Images/Cat/Bengal/Gallery/Bengal_2_Gallery_550_550.jpg', 'Gallery'),
(27, 7, 'Maine_Coon_1_Card_319_409', './Images/Cat/Maine_Coon/Card/Maine_Coon_1_Card_319_409.jpg', 'Card'),
(28, 7, 'Maine_Coon_1_Gallery_550_550', './Images/Cat/Maine_Coon/Gallery/Maine_Coon_1_Gallery_550_550.jpg', 'Gallery'),
(30, 8, 'Persian_Card_319_409', './Images/Cat/Persian/Card/Persian_Card_319_409.jpg', 'Card'),
(31, 8, 'Persian_Gallery_550_550', './Images/Cat/Persian/Gallery/Persian_Gallery_550_550.jpg', 'Gallery'),
(32, 8, 'Persian_2_Gallery_550_550', './Images/Cat/Persian/Gallery/Persian_2_Gallery_550_550.jpg', 'Gallery'),
(33, 8, 'Persian_3_Gallery_550_550', './Images/Cat/Persian/Gallery/Persian_3_Gallery_550_550.jpg', 'Gallery'),
(37, 9, 'Ragdoll_1_Card_319_409', './Images/Cat/Ragdoll/Card/Ragdoll_1_Card_319_409.jpg', 'Card'),
(38, 9, 'Ragdoll_1_Gallery_550_550', './Images/Cat/Ragdoll/Gallery/Ragdoll_1_Gallery_550_550.jpg', 'Gallery'),
(40, 10, 'Scottish_Fold_1_Card_319_409', './Images/Cat/Scottish_Fold/Card/Scottish_Fold_1_Card_319_409.jpg', 'Card'),
(41, 10, 'Scottish_Fold_1_Gallery_550_550', './Images/Cat/Scottish_Fold/Gallery/Scottish_Fold_1_Gallery_550_550.jpg', 'Gallery'),
(42, 10, 'Scottish_Fold_2_Gallery_550_550', './Images/Cat/Scottish_Fold/Gallery/Scottish_Fold_2_Gallery_550_550.jpg', 'Gallery'),
(45, 11, 'Chinese_Hamster_1_Card_319_409', './Images/Hamster/Chinese/Card/Chinese_Hamster_1_Card_319_409.jpg', 'Card'),
(46, 11, 'Chinese_Hamster_1_Gallery_550_550', './Images/Hamster/Chinese/Gallery/Chinese_Hamster_1_Gallery_550_550.jpg', 'Gallery'),
(47, 11, 'Chinese_Hamster_2_Gallery_550_550', './Images/Hamster/Chinese/Gallery/Chinese_Hamster_2_Gallery_550_550.jpg', 'Gallery'),
(50, 12, 'Common_1_Card_319_409', './Images/Hamster/Common/Card/Common_1_Card_319_409.jpg', 'Card'),
(51, 12, 'Common_1_Gallery_550_550', './Images/Hamster/Common/Gallery/Common_1_Gallery_550_550.jpg', 'Gallery'),
(53, 13, 'Roborovsky_1_Card_319_409', './Images/Hamster/Roborovsky/Card/Roborovsky_1_Card_319_409.jpg', 'Card'),
(54, 13, 'Roborovsky_1_Gallery_550_550', './Images/Hamster/Roborovsky/Gallery/Roborovsky_1_Gallery_550_550.jpg', 'Gallery'),
(56, 14, 'Short_Dwarf_1_Card_319_409', './Images/Hamster/Short_Dwarf/Card/Short_Dwarf_1_Card_319_409.jpg', 'Card'),
(57, 14, 'Short_Dwarf_1_Gallery_550_550', './Images/Hamster/Short_Dwarf/Gallery/Short_Dwarf_1_Gallery_550_550.jpg', 'Gallery'),
(59, 15, 'Syrian_1_Card_319_409', './Images/Hamster/Syrian/Card/Syrian_1_Card_319_409.jpg', 'Card'),
(60, 15, 'Syrian_1_Gallery_550_550', './Images/Hamster/Syrian/Gallery/Syrian_1_Gallery_550_550.jpg', 'Gallery');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `petId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `birthDate` date NOT NULL,
  `weight` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `petCondition` varchar(255) NOT NULL,
  `vaccinated` varchar(5) NOT NULL,
  `dewormed` varchar(5) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `petCatId` int(11) NOT NULL,
  `staffId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`petId`, `name`, `price`, `status`, `gender`, `birthDate`, `weight`, `color`, `petCondition`, `vaccinated`, `dewormed`, `createdAt`, `updatedAt`, `petCatId`, `staffId`) VALUES
(1, 'Siberian Husky', 25000, 1, 'male', '2020-06-25', '20kg', 'Black, White', 'Healthy', 'Yes', 'Yes', '2021-10-11 14:58:05', '2021-11-04 06:32:15', 1, NULL),
(2, 'Poodle', 1900, 1, 'Male', '2020-11-30', '11kg', 'Cream, White', 'Healthy', 'Yes', 'Yes', '2021-10-11 14:58:24', '2021-10-17 11:55:07', 1, NULL),
(3, 'Golden Retriever', 4800, 1, 'Female', '2021-07-12', '15kg', 'Golden', 'Healthy', 'Yes', 'Yes', '2021-10-11 14:51:24', '2021-10-17 11:55:07', 1, NULL),
(4, 'Rottweiler', 1200, 1, 'Female', '2019-07-20', '18kg', 'Black', 'Healthy', 'Yes', 'Yes', '2021-10-11 14:51:24', '2021-10-17 11:55:07', 1, NULL),
(5, 'Shih Tzu', 1400, 1, 'Male', '2020-07-27', '6kg', 'White', 'Healthy', 'Yes', 'Yes', '2021-10-11 14:51:24', '2021-10-17 11:55:07', 1, NULL),
(6, 'Bengal', 2800, 0, 'Male', '2018-02-14', '3.1kg', 'Brown', 'Healthy', 'Yes', 'Yes', '2021-10-11 15:03:55', '2021-11-13 16:26:39', 2, NULL),
(7, 'Maine Coon + Ragdoll', 1200, 1, 'Female', '2021-04-03', '2.3kg', 'White, Black, Golden', 'Healthy', 'Yes', 'Yes', '2021-10-11 15:03:55', '2021-10-17 11:55:07', 2, NULL),
(8, 'Persian', 850, 1, 'Male', '2019-01-29', '3.2kg', 'Golden', 'Healthy', 'Yes', 'Yes', '2021-10-11 15:03:55', '2021-10-17 11:55:07', 2, NULL),
(9, 'Ragdoll', 1800, 1, 'Male', '2020-03-05', '5.2kg', 'Cream, White, Brown', 'Healthy', 'Yes', 'Yes', '2021-10-11 15:03:55', '2021-10-17 11:55:07', 2, NULL),
(10, 'Scottish Fold', 1000, 1, 'Male', '2019-04-10', '2.3kg', 'Gray, White', 'Healthy', 'No', 'No', '2021-10-11 15:03:55', '2021-10-17 11:55:42', 2, NULL),
(11, 'Chinese + Syrian / Golden', 36, 1, 'Female', '2020-01-02', '89g', 'Brown, White', 'Healthy', 'Yes', 'Yes', '2021-10-11 15:08:26', '2021-10-17 11:55:07', 3, NULL),
(12, 'Common + Striped', 10, 1, 'Female', '2020-12-23', '31g', 'Gray', 'Healthy', 'No', 'No', '2021-10-11 15:08:26', '2021-10-17 11:55:42', 3, NULL),
(13, 'Roborovsky', 15, 1, 'Male', '2021-10-09', '24g', 'Brown, Gray', 'Healthy', 'No', 'No', '2021-10-11 15:08:26', '2021-10-17 11:55:42', 3, NULL),
(14, 'Short Dwarf', 15, 1, 'Male', '2021-07-17', '80g', 'Gray', 'Healthy', 'No', 'No', '2021-10-11 15:08:26', '2021-10-17 11:55:42', 3, NULL),
(15, 'Syrian / Golden', 15, 1, 'Male', '2021-07-29', '109g', 'Brown, White', 'Healthy', 'No', 'No', '2021-10-11 15:08:26', '2021-10-17 11:55:42', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `productCatId` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productcategory`
--

INSERT INTO `productcategory` (`productCatId`, `category`, `description`) VALUES
(1, 'Dog Food', 'Good nutrition is feeding your dog the building blocks and energy components that allow them to grow, develop to their potential and stay active throughout their life. We offer different kinds of food with many dietary benefits to choose from to feed your dog.'),
(2, 'Dog Accessories', 'Whether it be collars and leashes, dog toys, or even clothes and costumes, we offer a wide range of high-quality accessories for you and your dog\'s leisure.'),
(3, 'Dog Care Products', 'Just like you, good general care of your dog is important to keep your dog healthy throughout its life. With our careful selection of dog care products, rest assured your dog will live their best life using these products.'),
(4, 'Cat Food', 'Cats can be finicky eaters around, so we go to great lengths to provide high-quality, balanced nutrition they can\'t resist. Take a look at the cat food varieties we have to offer your furry friend.'),
(5, 'Cat Accessories', 'Check out our cat accessories selection for the very best in quality, suitable for cats from kitten to large cats. Between litter boxes, beds, scratchers, and trees, cats need a lot of stuff. These are our picks. '),
(6, 'Cat Care Products', 'The health of a cat is closely intertwined with its quality of life. Check out the cat care products selection for the best care products from supplements to skin care for your cats. These products would be our best pick for your cats\' health.'),
(7, 'Hamster Food', 'Hamsters like to eat seeds, grains, nuts, cracked corn, fruits and vegetables. A captive hamster\'s diet should be at least 16 percent protein and 5 percent fat, according to Canadian Federation of Humane Societies. These will be our pick for your hamsters.'),
(8, 'Hamster Accessories', 'Hamsters, both dwarf and Syrian, are active creatures. They need a variety of toys and other items to provide them with opportunities for exercise, exploration, and play. While they do appreciate time outside of the cage to explore in a hamster-safe environment, there products are what we recommended for you to put into the cage for them!'),
(9, 'Hamster Care Products', 'Promote the health of your hamster with our assortment of wellness supplies such as supplements, vitamin drops, mineral chews, and more.');

-- --------------------------------------------------------

--
-- Table structure for table `productimage`
--

CREATE TABLE `productimage` (
  `productImageId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `imageName` varchar(255) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `imageType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productimage`
--

INSERT INTO `productimage` (`productImageId`, `productId`, `imageName`, `imagePath`, `imageType`) VALUES
(1, 1, 'ALPO_Dry_Adult_Dog_Food_Pack_1_Card_319_409', './Images/Dog_Food/ALPO_Dry_Adult_Dog_Food_Pack/Card/ALPO_Dry_Adult_Dog_Food_Pack_1_Card_319_409.jpg', 'Card'),
(2, 1, 'ALPO_Dry_Adult_Dog_Food_Pack_1_Gallery_550_550', './Images/Dog_Food/ALPO_Dry_Adult_Dog_Food_Pack/Gallery/ALPO_Dry_Adult_Dog_Food_Pack_1_Gallery_550_550.jpg', 'Gallery'),
(3, 1, 'ALPO_Dry_Adult_Dog_Food_Pack_2_Gallery_550_550', './Images/Dog_Food/ALPO_Dry_Adult_Dog_Food_Pack/Gallery/ALPO_Dry_Adult_Dog_Food_Pack_2_Gallery_550_550.jpg', 'Gallery'),
(4, 1, 'ALPO_Dry_Adult_Dog_Food_Pack_3_Gallery_550_550', './Images/Dog_Food/ALPO_Dry_Adult_Dog_Food_Pack/Gallery/ALPO_Dry_Adult_Dog_Food_Pack_3_Gallery_550_550.jpg', 'Gallery'),
(8, 2, 'CESAR_Dog_Food_Beef_x6_Wet_Food_1_Card_319_409', './Images/Dog_Food/CESAR_Dog_Food_Beef_x6_Wet_Food/Card/CESAR_Dog_Food_Beef_x6_Wet_Food_1_Card_319_409.jpg', 'Card'),
(9, 2, 'CESAR_Dog_Food_Beef_x6_Wet_Food_1_Gallery_550_550', './Images/Dog_Food/CESAR_Dog_Food_Beef_x6_Wet_Food/Gallery/CESAR_Dog_Food_Beef_x6_Wet_Food_1_Gallery_550_550.jpg', 'Gallery'),
(10, 2, 'CESAR_Dog_Food_Beef_x6_Wet_Food_2_Gallery_550_550', './Images/Dog_Food/CESAR_Dog_Food_Beef_x6_Wet_Food/Gallery/CESAR_Dog_Food_Beef_x6_Wet_Food_2_Gallery_550_550.jpg', 'Gallery'),
(11, 2, 'CESAR_Dog_Food_Beef_x6_Wet_Food_3_Gallery_550_550', './Images/Dog_Food/CESAR_Dog_Food_Beef_x6_Wet_Food/Gallery/CESAR_Dog_Food_Beef_x6_Wet_Food_3_Gallery_550_550.jpg', 'Gallery'),
(15, 3, 'CESAR_Naturally_Crafted_Aust_Beef_1_Card_319_409', './Images/Dog_Food/CESAR Naturally Crafted Aust Beef X6 Dog Wet Food/Card/CESAR_Naturally_Crafted_Aust_Beef_1_Card_319_409.jpg', 'Card'),
(16, 3, 'CESAR_Naturally_Crafted_Aust_Beef_1_Gallery_550_550', './Images/Dog_Food/CESAR Naturally Crafted Aust Beef X6 Dog Wet Food/Gallery/CESAR_Naturally_Crafted_Aust_Beef_1_Gallery_550_550.jpg', 'Gallery'),
(17, 3, 'CESAR_Naturally_Crafted_Aust_Beef_2_Gallery_550_550', './Images/Dog_Food/CESAR Naturally Crafted Aust Beef X6 Dog Wet Food/Gallery/CESAR_Naturally_Crafted_Aust_Beef_2_Gallery_550_550.jpg', 'Gallery'),
(18, 3, 'CESAR_Naturally_Crafted_Aust_Beef_3_Gallery_550_550', './Images/Dog_Food/CESAR Naturally Crafted Aust Beef X6 Dog Wet Food/Gallery/CESAR_Naturally_Crafted_Aust_Beef_3_Gallery_550_550.jpg', 'Gallery'),
(22, 4, 'GREENIES_Treatpak_Pette_1_Card_319_409', './Images/Dog_Food/GREENIES Treatpak Petite Dog Denta Care/Card/GREENIES_Treatpak_Pette_1_Card_319_409.jpg', 'Card'),
(23, 4, 'GREENIES_Treatpak_Pette_1_Gallery_550_550', './Images/Dog_Food/GREENIES Treatpak Petite Dog Denta Care/Gallery/GREENIES_Treatpak_Pette_1_Gallery_550_550.jpg', 'Gallery'),
(24, 4, 'GREENIES_Treatpak_Pette_2_Gallery_550_550', './Images/Dog_Food/GREENIES Treatpak Petite Dog Denta Care/Gallery/GREENIES_Treatpak_Pette_2_Gallery_550_550.jpg', 'Gallery'),
(25, 4, 'GREENIES_Treatpak_Pette_3_Gallery_550_550', './Images/Dog_Food/GREENIES Treatpak Petite Dog Denta Care/Gallery/GREENIES_Treatpak_Pette_3_Gallery_550_550.jpg', 'Gallery'),
(29, 5, 'IAMS_Proactive_Health_1_Card_319_409', './Images/Dog_Food/IAMS Proactive Health/Card/IAMS_Proactive_Health_1_Card_319_409.jpg', 'Card'),
(30, 5, 'IAMS_Proactive_Health_1_Gallery_550_550', './Images/Dog_Food/IAMS Proactive Health/Gallery/IAMS_Proactive_Health_1_Gallery_550_550.jpg', 'Gallery'),
(32, 6, 'PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_1_Card_319_409', './Images/Dog_Food/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken/Card/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_1_Card_319_409.jpg', 'Card'),
(33, 6, 'PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_1_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken/Gallery/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_1_Gallery_550_550.jpg', 'Gallery'),
(34, 6, 'PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_2_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken/Gallery/PEDIGREE_Can_Dog_Wet_Food_Adult_Chicken_2_Gallery_550_550.jpg', 'Gallery'),
(37, 7, 'PEDIGREE_Medium_Dog_Treats_1_Card_319_409', './Images/Dog_Food/PEDIGREE_Medium_Dog_Treats/Card/PEDIGREE_Medium_Dog_Treats_1_Card_319_409.jpg', 'Card'),
(38, 7, 'PEDIGREE_Medium_Dog_Treats_1_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Medium_Dog_Treats/Gallery/PEDIGREE_Medium_Dog_Treats_1_Gallery_550_550.jpg', 'Gallery'),
(39, 7, 'PEDIGREE_Medium_Dog_Treats_2_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Medium_Dog_Treats/Gallery/PEDIGREE_Medium_Dog_Treats_2_Gallery_550_550.jpg', 'Gallery'),
(42, 8, 'PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_1_Card_319_409', './Images/Dog_Food/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable/Card/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_1_Card_319_409.jpg', 'Card'),
(43, 8, 'PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_1_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable/Gallery/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_1_Gallery_550_550.jpg', 'Gallery'),
(44, 8, 'PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_2_Gallery_550_550', './Images/Dog_Food/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable/Gallery/PEDIGREE_Dog_Dry_Food_Chicken_Vegetable_2_Gallery_550_550.jpg', 'Gallery'),
(47, 9, 'PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_1_Card_319_409', './Images/Dog_Food/PEDIGREE Dog Dry Food Puppy Chicken, Egg & Milk/Card/PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_1_Card_319_409.jpg', 'Card'),
(48, 9, 'PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_1_Gallery_550_550', './Images/Dog_Food/PEDIGREE Dog Dry Food Puppy Chicken, Egg & Milk/Gallery/PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_1_Gallery_550_550.jpg', 'Gallery'),
(49, 9, 'PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_2_Gallery_550_550', './Images/Dog_Food/PEDIGREE Dog Dry Food Puppy Chicken, Egg & Milk/Gallery/PEDIGREE_Dog_Dry_Food_Chicken_Egg_Milk_2_Gallery_550_550.jpg', 'Gallery'),
(52, 10, 'SUPERCOAT_Chicken_Dry_Dog_Food_1_Card_319_409', './Images/Dog_Food/SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food/Card/SUPERCOAT_Chicken_Dry_Dog_Food_1_Card_319_409.jpg', 'Card'),
(53, 10, 'SUPERCOAT_Chicken_Dry_Dog_Food_1_Gallery_550_550', './Images/Dog_Food/SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food/Gallery/SUPERCOAT_Chicken_Dry_Dog_Food_1_Gallery_550_550.jpg', 'Gallery'),
(54, 10, 'SUPERCOAT_Chicken_Dry_Dog_Food_2_Gallery_550_550', './Images/Dog_Food/SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food/Gallery/SUPERCOAT_Chicken_Dry_Dog_Food_2_Gallery_550_550.jpg', 'Gallery'),
(55, 10, 'SUPERCOAT_Chicken_Dry_Dog_Food_3_Gallery_550_550', './Images/Dog_Food/SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food/Gallery/SUPERCOAT_Chicken_Dry_Dog_Food_3_Gallery_550_550.jpg', 'Gallery'),
(56, 10, 'SUPERCOAT_Chicken_Dry_Dog_Food_4_Gallery_550_550', './Images/Dog_Food/SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food/Gallery/SUPERCOAT_Chicken_Dry_Dog_Food_4_Gallery_550_550.jpg', 'Gallery'),
(61, 11, '5M_Dog_Leash_1_Card_319_409', './Images/Dog_Accessories/5M Retractable Dog Leash/Card/5M_Dog_Leash_1_Card_319_409.jpg', 'Card'),
(62, 11, '5M_Dog_Leash_1_Gallery_550_550', './Images/Dog_Accessories/5M Retractable Dog Leash/Gallery/5M_Dog_Leash_1_Gallery_550_550.jpg', 'Gallery'),
(63, 11, '5M_Dog_Leash_2_Gallery_550_550', './Images/Dog_Accessories/5M Retractable Dog Leash/Gallery/5M_Dog_Leash_2_Gallery_550_550.jpg', 'Gallery'),
(66, 12, 'Heavy_Duty_Collar_1_Card_319_409', './Images/Dog_Accessories/Heavy Duty Stainless Steel Collar/Card/Heavy_Duty_Collar_1_Card_319_409.jpg', 'Card'),
(67, 12, 'Heavy_Duty_Collar_1_Gallery_550_550', './Images/Dog_Accessories/Heavy Duty Stainless Steel Collar/Gallery/Heavy_Duty_Collar_1_Gallery_550_550.jpg', 'Gallery'),
(68, 12, 'Heavy_Duty_Collar_2_Gallery_550_550', './Images/Dog_Accessories/Heavy Duty Stainless Steel Collar/Gallery/Heavy_Duty_Collar_2_Gallery_550_550.jpg', 'Gallery'),
(71, 13, 'Pet_Chew_Toys_Bone_1_Card_319_409', './Images/Dog_Accessories/Indestructible Pet Chew Toys Bone/Card/Pet_Chew_Toys_Bone_1_Card_319_409.jpg', 'Card'),
(72, 13, 'Pet_Chew_Toys_Bone_1_Gallery_550_550', './Images/Dog_Accessories/Indestructible Pet Chew Toys Bone/Gallery/Pet_Chew_Toys_Bone_1_Gallery_550_550.jpg', 'Gallery'),
(73, 13, 'Pet_Chew_Toys_Bone_2_Gallery_550_550', './Images/Dog_Accessories/Indestructible Pet Chew Toys Bone/Gallery/Pet_Chew_Toys_Bone_2_Gallery_550_550.jpg', 'Gallery'),
(76, 14, 'Cotton_Rope_Dog_Toy_1_Card_319_409', './Images/Dog_Accessories/Interactive Traction Cotton Rope Dog Toy/Card/Cotton_Rope_Dog_Toy_1_Card_319_409.jpg', 'Card'),
(77, 14, 'Cotton_Rope_Dog_Toy_1_Gallery_550_550', './Images/Dog_Accessories/Interactive Traction Cotton Rope Dog Toy/Gallery/Cotton_Rope_Dog_Toy_1_Gallery_550_550.jpg', 'Gallery'),
(78, 14, 'Cotton_Rope_Dog_Toy_2_Gallery_550_550', './Images/Dog_Accessories/Interactive Traction Cotton Rope Dog Toy/Gallery/Cotton_Rope_Dog_Toy_2_Gallery_550_550.jpg', 'Gallery'),
(81, 15, 'Basketball_Shirt_1_Card_319_409', './Images/Dog_Accessories/MIAODODO Thin Summer Basketball Shirt for Dogs/Card/Basketball_Shirt_1_Card_319_409.jpg', 'Card'),
(82, 15, 'Basketball_Shirt_1_Gallery_550_550', './Images/Dog_Accessories/MIAODODO Thin Summer Basketball Shirt for Dogs/Gallery/Basketball_Shirt_1_Gallery_550_550.jpg', 'Gallery'),
(83, 15, 'Basketball_Shirt_2_Gallery_550_550', './Images/Dog_Accessories/MIAODODO Thin Summer Basketball Shirt for Dogs/Gallery/Basketball_Shirt_2_Gallery_550_550.jpg', 'Gallery'),
(86, 16, 'Unit_Vest_1_Card_319_409', './Images/Dog_Accessories/Pet Dog Black Polices K-9 Unit Vest T-Shirt/Card/Unit_Vest_1_Card_319_409.jpg', 'Card'),
(87, 16, 'Unit_Vest_1_Gallery_550_550', './Images/Dog_Accessories/Pet Dog Black Polices K-9 Unit Vest T-Shirt/Gallery/Unit_Vest_1_Gallery_550_550.jpg', 'Gallery'),
(88, 16, 'Unit_Vest_2_Gallery_550_550', './Images/Dog_Accessories/Pet Dog Black Polices K-9 Unit Vest T-Shirt/Gallery/Unit_Vest_2_Gallery_550_550.jpg', 'Gallery'),
(91, 17, 'Leash_Nylon_1_Card_319_409', './Images/Dog_Accessories/Reflective Rope Pet Dog Leash/Card/Leash_Nylon_1_Card_319_409.jpg', 'Card'),
(92, 17, 'Leash_Nylon_1_Gallery_550_550', './Images/Dog_Accessories/Reflective Rope Pet Dog Leash/Gallery/Leash_Nylon_1_Gallery_550_550.jpg', 'Gallery'),
(93, 17, 'Leash_Nylon_2_Gallery_550_550', './Images/Dog_Accessories/Reflective Rope Pet Dog Leash/Gallery/Leash_Nylon_2_Gallery_550_550.jpg', 'Gallery'),
(96, 18, 'Folding_Bag_1_Card_319_409', './Images/Dog_Care/Folding Portable Mesh Breathable Dog Bag/Card/Folding_Bag_1_Card_319_409.jpg', 'Card'),
(97, 18, 'Folding_Bag_1_Gallery_550_550', './Images/Dog_Care/Folding Portable Mesh Breathable Dog Bag/Gallery/Folding_Bag_1_Gallery_550_550.jpg', 'Gallery'),
(98, 18, 'Folding_Bag_2_Gallery_550_550', './Images/Dog_Care/Folding Portable Mesh Breathable Dog Bag/Gallery/Folding_Bag_2_Gallery_550_550.jpg', 'Gallery'),
(101, 19, 'Toilet_1_Card_319_409', './Images/Dog_Care/idropmy Pet Toilet Mat Puppy Potty Pad Training Seat Tray/Card/Toilet_1_Card_319_409.jpg', 'Card'),
(102, 19, 'Toilet_1_Gallery_550_550', './Images/Dog_Care/idropmy Pet Toilet Mat Puppy Potty Pad Training Seat Tray/Gallery/Toilet_1_Gallery_550_550.jpg', 'Gallery'),
(103, 19, 'Toilet_2_Gallery_550_550', './Images/Dog_Care/idropmy Pet Toilet Mat Puppy Potty Pad Training Seat Tray/Gallery/Toilet_2_Gallery_550_550.jpg', 'Gallery'),
(106, 20, 'Shampoo_1_Card_319_409', './Images/Dog_Care/Nanovet Pet Medicated Shampoo/Card/Shampoo_1_Card_319_409.jpg', 'Card'),
(107, 20, 'Shampoo_1_Gallery_550_550', './Images/Dog_Care/Nanovet Pet Medicated Shampoo/Gallery/Shampoo_1_Gallery_550_550.jpg', 'Gallery'),
(108, 20, 'Shampoo_2_Gallery_550_550', './Images/Dog_Care/Nanovet Pet Medicated Shampoo/Gallery/Shampoo_2_Gallery_550_550.jpg', 'Gallery'),
(109, 20, 'Shampoo_3_Gallery_550_550', './Images/Dog_Care/Nanovet Pet Medicated Shampoo/Gallery/Shampoo_3_Gallery_550_550.jpg', 'Gallery'),
(113, 21, 'Only_Fresh_Shampoo_1_Card_319_409', './Images/Dog_Care/Oxyfresh Premium Pet Dental Care Solution Pet Water Additive (16oz)/Card/Only_Fresh_Shampoo_1_Card_319_409.jpg', 'Card'),
(114, 21, 'Only_Fresh_Shampoo_1_Gallery_550_550', './Images/Dog_Care/Oxyfresh Premium Pet Dental Care Solution Pet Water Additive (16oz)/Gallery/Only_Fresh_Shampoo_1_Gallery_550_550.jpg', 'Gallery'),
(115, 21, 'Only_Fresh_Shampoo_2_Gallery_550_550', './Images/Dog_Care/Oxyfresh Premium Pet Dental Care Solution Pet Water Additive (16oz)/Gallery/Only_Fresh_Shampoo_2_Gallery_550_550.jpg', 'Gallery'),
(118, 22, 'Pads_1_Card_319_409', './Images/Dog_Care/Training Pads, Pack of 100/Card/Pads_1_Card_319_409.jpg', 'Card'),
(119, 22, 'Pads_1_Gallery_550_550', './Images/Dog_Care/Training Pads, Pack of 100/Gallery/Pads_1_Gallery_550_550.jpg', 'Gallery'),
(120, 22, 'Pads_2_Gallery_550_550', './Images/Dog_Care/Training Pads, Pack of 100/Gallery/Pads_2_Gallery_550_550.jpg', 'Gallery'),
(121, 22, 'Pads_3_Gallery_550_550', './Images/Dog_Care/Training Pads, Pack of 100/Gallery/Pads_3_Gallery_550_550.jpg', 'Gallery'),
(125, 23, 'Toothpaste_1_Card_319_409', './Images/Dog_Care/Vet Best Enzymatic Dog Toothpaste/Card/Toothpaste_1_Card_319_409.jpg', 'Card'),
(126, 23, 'Toothpaste_1_Gallery_550_550', './Images/Dog_Care/Vet Best Enzymatic Dog Toothpaste/Gallery/Toothpaste_1_Gallery_550_550.jpg', 'Gallery'),
(127, 23, 'Toothpaste_2_Gallery_550_550', './Images/Dog_Care/Vet Best Enzymatic Dog Toothpaste/Gallery/Toothpaste_2_Gallery_550_550.jpg', 'Gallery'),
(128, 23, 'Toothpaste_3_Gallery_550_550', './Images/Dog_Care/Vet Best Enzymatic Dog Toothpaste/Gallery/Toothpaste_3_Gallery_550_550.jpg', 'Gallery'),
(132, 24, 'Container_1_Card_319_409', './Images/Dog_Care/Vumdua Dog Food Storage Container with Serving Scoop/Card/Container_1_Card_319_409.jpg', 'Card'),
(133, 24, 'Container_1_Gallery_550_550', './Images/Dog_Care/Vumdua Dog Food Storage Container with Serving Scoop/Gallery/Container_1_Gallery_550_550.jpg', 'Gallery'),
(134, 24, 'Container_2_Gallery_550_550', './Images/Dog_Care/Vumdua Dog Food Storage Container with Serving Scoop/Gallery/Container_2_Gallery_550_550.jpg', 'Gallery'),
(137, 25, 'IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_1_Card_319_409', './Images/Cat_Food/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg/Card/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_1_Card_319_409.jpg', 'Card'),
(138, 25, 'IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_1_Gallery_550_550', './Images/Cat_Food/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg/Gallery/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_1_Gallery_550_550.jpg', 'Gallery'),
(139, 25, 'IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_2_Gallery_550_550', './Images/Cat_Food/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg/Gallery/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_2_Gallery_550_550.jpg', 'Gallery'),
(140, 25, 'IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_3_Gallery_550_550', './Images/Cat_Food/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg/Gallery/IAMS_Cat_Dry_Food_Adult_Care_Chicken_3kg_3_Gallery_550_550.jpg', 'Gallery'),
(144, 26, 'IAMS_Cat_Dry_Food_Adult_Ocean_Fish_1_Card_319_409', './Images/Cat_Food/IAMS Cat Dry Food Adult Ocean Fish 3kg Cat Food/Card/IAMS_Cat_Dry_Food_Adult_Ocean_Fish_1_Card_319_409.jpg', 'Card'),
(145, 26, 'IAMS_Cat_Dry_Food_Adult_Ocean_Fish_1_Gallery_550_550', './Images/Cat_Food/IAMS Cat Dry Food Adult Ocean Fish 3kg Cat Food/Gallery/IAMS_Cat_Dry_Food_Adult_Ocean_Fish_1_Gallery_550_550.jpg', 'Gallery'),
(146, 26, 'IAMS_Cat_Dry_Food_Adult_Ocean_Fish_2_Gallery_550_550', './Images/Cat_Food/IAMS Cat Dry Food Adult Ocean Fish 3kg Cat Food/Gallery/IAMS_Cat_Dry_Food_Adult_Ocean_Fish_2_Gallery_550_550.jpg', 'Gallery'),
(147, 26, 'IAMS_Cat_Dry_Food_Adult_Ocean_Fish_3_Gallery_550_550', './Images/Cat_Food/IAMS Cat Dry Food Adult Ocean Fish 3kg Cat Food/Gallery/IAMS_Cat_Dry_Food_Adult_Ocean_Fish_3_Gallery_550_550.jpg', 'Gallery'),
(151, 27, 'Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_1_Card_319_409', './Images/Cat_Food/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm/Card/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_1_Card_319_409.jpg', 'Card'),
(152, 27, 'Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_1_Gallery_550_550', './Images/Cat_Food/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm/Gallery/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_1_Gallery_550_550.jpg', 'Gallery'),
(153, 27, 'Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_2_Gallery_550_550', './Images/Cat_Food/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm/Gallery/Sheba_Can_Cat_Wet_Food_Adult_Succulent_Chicken_Breast_with_Prawn_85gm_2_Gallery_550_550.jpg', 'Gallery'),
(156, 28, 'SHEBA_Melty_Cat_Treat_Tuna_Seafood_1_Card_319_409', './Images/Cat_Food/SHEBA Melty Cat Treat Tuna & Tuna Seafood (48g)/Card/SHEBA_Melty_Cat_Treat_Tuna_Seafood_1_Card_319_409.jpg', 'Card'),
(157, 28, 'SHEBA_Melty_Cat_Treat_Tuna_Seafood_1_Gallery_550_550', './Images/Cat_Food/SHEBA Melty Cat Treat Tuna & Tuna Seafood (48g)/Gallery/SHEBA_Melty_Cat_Treat_Tuna_Seafood_1_Gallery_550_550.jpg', 'Gallery'),
(158, 28, 'SHEBA_Melty_Cat_Treat_Tuna_Seafood_2_Gallery_550_550', './Images/Cat_Food/SHEBA Melty Cat Treat Tuna & Tuna Seafood (48g)/Gallery/SHEBA_Melty_Cat_Treat_Tuna_Seafood_2_Gallery_550_550.jpg', 'Gallery'),
(159, 28, 'SHEBA_Melty_Cat_Treat_Tuna_Seafood_3_Gallery_550_550', './Images/Cat_Food/SHEBA Melty Cat Treat Tuna & Tuna Seafood (48g)/Gallery/SHEBA_Melty_Cat_Treat_Tuna_Seafood_3_Gallery_550_550.jpg', 'Gallery'),
(163, 29, 'Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_1_Card_319_409', './Images/Cat_Food/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm/Card/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_1_Card_319_409.jpg', 'Card'),
(164, 29, 'Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_1_Gallery_550_550', './Images/Cat_Food/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm/Gallery/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_1_Gallery_550_550.jpg', 'Gallery'),
(165, 29, 'Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_2_Gallery_550_550', './Images/Cat_Food/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm/Gallery/Temptation_Cat_Treat_Adult_Tasty_Chicken_85gm_2_Gallery_550_550.jpg', 'Gallery'),
(168, 30, 'WHISKAS_Dry_Cat_Food_Ocean_FIsh_1_Card_319_409', './Images/Cat_Food/WHISKAS Dry Cat Food Junior Ocean Fish 1.1kg Cat Dry Food/Card/WHISKAS_Dry_Cat_Food_Ocean_FIsh_1_Card_319_409.jpg', 'Card'),
(169, 30, 'WHISKAS_Dry_Cat_Food_Ocean_FIsh_1_Gallery_550_550', './Images/Cat_Food/WHISKAS Dry Cat Food Junior Ocean Fish 1.1kg Cat Dry Food/Gallery/WHISKAS_Dry_Cat_Food_Ocean_FIsh_1_Gallery_550_550.jpg', 'Gallery'),
(170, 30, 'WHISKAS_Dry_Cat_Food_Ocean_FIsh_2_Gallery_550_550', './Images/Cat_Food/WHISKAS Dry Cat Food Junior Ocean Fish 1.1kg Cat Dry Food/Gallery/WHISKAS_Dry_Cat_Food_Ocean_FIsh_2_Gallery_550_550.jpg', 'Gallery'),
(171, 30, 'WHISKAS_Dry_Cat_Food_Ocean_FIsh_3_Gallery_550_550', './Images/Cat_Food/WHISKAS Dry Cat Food Junior Ocean Fish 1.1kg Cat Dry Food/Gallery/WHISKAS_Dry_Cat_Food_Ocean_FIsh_3_Gallery_550_550.jpg', 'Gallery'),
(175, 31, 'Whiskas_Mackerel_1_Card_319_409', './Images/Cat_Food/Whiskas_Mackerel/Card/Whiskas_Mackerel_1_Card_319_409.jpg', 'Card'),
(176, 31, 'Whiskas_Mackerel_1_Gallery_550_550', './Images/Cat_Food/Whiskas_Mackerel/Gallery/Whiskas_Mackerel_1_Gallery_550_550.jpg', 'Gallery'),
(177, 31, 'Whiskas_Mackerel_2_Gallery_550_550', './Images/Cat_Food/Whiskas_Mackerel/Gallery/Whiskas_Mackerel_2_Gallery_550_550.jpg', 'Gallery'),
(178, 31, 'Whiskas_Mackerel_3_Gallery_550_550', './Images/Cat_Food/Whiskas_Mackerel/Gallery/Whiskas_Mackerel_3_Gallery_550_550.jpg', 'Gallery'),
(189, 32, 'Whiskas_Group_1_Card_319_409', './Images/Cat_Food/Whiskas_4_Pack/Card/Whiskas_Group_1_Card_319_409.jpg', 'Card'),
(190, 32, 'Whiskas_Group_1_Gallery_550_550', './Images/Cat_Food/Whiskas_4_Pack/Gallery/Whiskas_Group_1_Gallery_550_550.jpg', 'Gallery'),
(191, 32, 'Whiskas_Group_2_Gallery_550_550', './Images/Cat_Food/Whiskas_4_Pack/Gallery/Whiskas_Group_2_Gallery_550_550.jpg', 'Gallery'),
(192, 32, 'Whiskas_Group_3_Gallery_550_550', './Images/Cat_Food/Whiskas_4_Pack/Gallery/Whiskas_Group_3_Gallery_550_550.jpg', 'Gallery'),
(193, 32, 'Whiskas_Group_4_Gallery_550_550', './Images/Cat_Food/Whiskas_4_Pack/Gallery/Whiskas_Group_4_Gallery_550_550.jpg', 'Gallery'),
(198, 33, 'Cat_Litter_1_Card_319_409', './Images/Cat_Accessories/Cat_Litter/Card/Cat_Litter_1_Card_319_409.jpg', 'Card'),
(199, 33, 'Cat_Litter_1_Gallery_550_550', './Images/Cat_Accessories/Cat_Litter/Gallery/Cat_Litter_1_Gallery_550_550.jpg', 'Gallery'),
(200, 33, 'Cat_Litter_2_Gallery_550_550', './Images/Cat_Accessories/Cat_Litter/Gallery/Cat_Litter_2_Gallery_550_550.jpg', 'Gallery'),
(203, 34, 'Cat_Scratchers_1_Card_319_409', './Images/Cat_Accessories/Cat_Scratchers/Card/Cat_Scratchers_1_Card_319_409.jpg', 'Card'),
(204, 34, 'Cat_Scratchers_1_Gallery_550_550', './Images/Cat_Accessories/Cat_Scratchers/Gallery/Cat_Scratchers_1_Gallery_550_550.jpg', 'Gallery'),
(205, 34, 'Cat_Scratchers_2_Gallery_550_550', './Images/Cat_Accessories/Cat_Scratchers/Gallery/Cat_Scratchers_2_Gallery_550_550.jpg', 'Gallery'),
(208, 35, 'Cat_Tower_1_Card_319_409', './Images/Cat_Accessories/Cat_Tower/Card/Cat_Tower_1_Card_319_409.jpg', 'Card'),
(209, 35, 'Cat_Tower_1_Gallery_550_550', './Images/Cat_Accessories/Cat_Tower/Gallery/Cat_Tower_1_Gallery_550_550.jpg', 'Gallery'),
(210, 35, 'Cat_Tower_2_Gallery_550_550', './Images/Cat_Accessories/Cat_Tower/Gallery/Cat_Tower_2_Gallery_550_550.jpg', 'Gallery'),
(213, 36, 'Feather_Toy_1_Card_319_409', './Images/Cat_Accessories/Feather_Toy/Card/Feather_Toy_1_Card_319_409.jpg', 'Card'),
(214, 36, 'Feather_Toy_1_Gallery_550_550', './Images/Cat_Accessories/Feather_Toy/Gallery/Feather_Toy_1_Gallery_550_550.jpg', 'Gallery'),
(215, 36, 'Feather_Toy_2_Gallery_550_550', './Images/Cat_Accessories/Feather_Toy/Gallery/Feather_Toy_2_Gallery_550_550.jpg', 'Gallery'),
(218, 37, 'Habitat_Crate_1_Card_319_409', './Images/Cat_Accessories/Habitat_Crate/Card/Habitat_Crate_1_Card_319_409.jpg', 'Card'),
(219, 37, 'Habitat_Crate_1_Gallery_550_550', './Images/Cat_Accessories/Habitat_Crate/Gallery/Habitat_Crate_1_Gallery_550_550.jpg', 'Gallery'),
(220, 37, 'Habitat_Crate_2_Gallery_550_550', './Images/Cat_Accessories/Habitat_Crate/Gallery/Habitat_Crate_2_Gallery_550_550.jpg', 'Gallery'),
(223, 38, 'Advantage_Flea_Prevenion_Treatment_1_Card_319_409', './Images/Cat_Care/Advantage II Flea Prevention and Treatment/Card/Advantage_Flea_Prevenion_Treatment_1_Card_319_409.jpg', 'Card'),
(224, 38, 'Advantage_Flea_Prevenion_Treatment_1_Gallery_550_550', './Images/Cat_Care/Advantage II Flea Prevention and Treatment/Gallery/Advantage_Flea_Prevenion_Treatment_1_Gallery_550_550.jpg', 'Gallery'),
(225, 38, 'Advantage_Flea_Prevenion_Treatment_2_Gallery_550_550', './Images/Cat_Care/Advantage II Flea Prevention and Treatment/Gallery/Advantage_Flea_Prevenion_Treatment_2_Gallery_550_550.jpg', 'Gallery'),
(228, 39, 'Golden_Paw_Herbal_Cat_Supplement_1_Card_319_409', './Images/Cat_Care/GoldenPaw Herbal Pet Supplement for Cat/Card/Golden_Paw_Herbal_Cat_Supplement_1_Card_319_409.jpg', 'Card'),
(229, 39, 'Golden_Paw_Herbal_Cat_Supplement_1_Gallery_550_550', './Images/Cat_Care/GoldenPaw Herbal Pet Supplement for Cat/Gallery/Golden_Paw_Herbal_Cat_Supplement_1_Gallery_550_550.jpg', 'Gallery'),
(230, 39, 'Golden_Paw_Herbal_Cat_Supplement_2_Gallery_550_550', './Images/Cat_Care/GoldenPaw Herbal Pet Supplement for Cat/Gallery/Golden_Paw_Herbal_Cat_Supplement_2_Gallery_550_550.jpg', 'Gallery'),
(233, 40, 'Lysine_Chews_1_Card_319_409', './Images/Cat_Care/L-Lysine Chews/Card/Lysine_Chews_1_Card_319_409.jpg', 'Card'),
(234, 40, 'Lysine_Chews_1_Gallery_550_550', './Images/Cat_Care/L-Lysine Chews/Gallery/Lysine_Chews_1_Gallery_550_550.jpg', 'Gallery'),
(235, 40, 'Lysine_Chews_2_Gallery_550_550', './Images/Cat_Care/L-Lysine Chews/Gallery/Lysine_Chews_2_Gallery_550_550.jpg', 'Gallery'),
(238, 41, 'Omega_Fish_Oil_1_Card_319_409', './Images/Cat_Care/Omega 3 Fish Oil/Card/Omega_Fish_Oil_1_Card_319_409.jpg', 'Card'),
(239, 41, 'Omega_Fish_Oil_1_Gallery_550_550', './Images/Cat_Care/Omega 3 Fish Oil/Gallery/Omega_Fish_Oil_1_Gallery_550_550.jpg', 'Gallery'),
(240, 41, 'Omega_Fish_Oil_2_Gallery_550_550', './Images/Cat_Care/Omega 3 Fish Oil/Gallery/Omega_Fish_Oil_2_Gallery_550_550.jpg', 'Gallery'),
(243, 42, 'Kidney_Support_Gold_1_Card_319_409', './Images/Cat_Care/Pet Wellbeing - Kidney Support Gold for Cats/Card/Kidney_Support_Gold_1_Card_319_409.jpg', 'Card'),
(244, 42, 'Kidney_Support_Gold_1_Gallery_550_550', './Images/Cat_Care/Pet Wellbeing - Kidney Support Gold for Cats/Gallery/Kidney_Support_Gold_1_Gallery_550_550.jpg', 'Gallery'),
(245, 42, 'Kidney_Support_Gold_2_Gallery_550_550', './Images/Cat_Care/Pet Wellbeing - Kidney Support Gold for Cats/Gallery/Kidney_Support_Gold_2_Gallery_550_550.jpg', 'Gallery'),
(248, 43, 'FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_1_Card_319_409', './Images/Hamster_Food/F.M. Brown Tropical Carnival Gourmet Hamster and Gerbil Food/Card/FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_1_Card_319_409.jpg', 'Card'),
(249, 43, 'FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_1_Gallery_550_550', './Images/Hamster_Food/F.M. Brown Tropical Carnival Gourmet Hamster and Gerbil Food/Gallery/FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_1_Gallery_550_550.jpg', 'Gallery'),
(250, 43, 'FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_2_Gallery_550_550', './Images/Hamster_Food/F.M. Brown Tropical Carnival Gourmet Hamster and Gerbil Food/Gallery/FM_Brown_Tropical_Carnival_Gourment_Hamster_Food_2_Gallery_550_550.jpg', 'Gallery'),
(253, 44, 'Kaytee_Food_Wild_Hamster_1_Card_319_409', './Images/Hamster_Food/Kaytee Food from The Wild Hamster/Card/Kaytee_Food_Wild_Hamster_1_Card_319_409.jpg', 'Card'),
(254, 44, 'Kaytee_Food_Wild_Hamster_1_Gallery_550_550', './Images/Hamster_Food/Kaytee Food from The Wild Hamster/Gallery/Kaytee_Food_Wild_Hamster_1_Gallery_550_550.jpg', 'Gallery'),
(255, 44, 'Kaytee_Food_Wild_Hamster_2_Gallery_550_550', './Images/Hamster_Food/Kaytee Food from The Wild Hamster/Gallery/Kaytee_Food_Wild_Hamster_2_Gallery_550_550.jpg', 'Gallery'),
(258, 45, 'Kaytee_Forti_Diet_Pro_1_Card_319_409', './Images/Hamster_Food/Kaytee Forti Diet Pro Health Hamster Food/Card/Kaytee_Forti_Diet_Pro_1_Card_319_409.jpg', 'Card'),
(259, 45, 'Kaytee_Forti_Diet_Pro_1_Gallery_550_550', './Images/Hamster_Food/Kaytee Forti Diet Pro Health Hamster Food/Gallery/Kaytee_Forti_Diet_Pro_1_Gallery_550_550.jpg', 'Gallery'),
(260, 45, 'Kaytee_Forti_Diet_Pro_2_Gallery_550_550', './Images/Hamster_Food/Kaytee Forti Diet Pro Health Hamster Food/Gallery/Kaytee_Forti_Diet_Pro_2_Gallery_550_550.jpg', 'Gallery'),
(263, 46, 'Oxbow_Essentials_Hamster_Food_1_Card_319_409', './Images/Hamster_Food/Oxbow Essentials Hamster Food and Gerbil Food/Card/Oxbow_Essentials_Hamster_Food_1_Card_319_409.jpg', 'Card'),
(264, 46, 'Oxbow_Essentials_Hamster_Food_1_Gallery_550_550', './Images/Hamster_Food/Oxbow Essentials Hamster Food and Gerbil Food/Gallery/Oxbow_Essentials_Hamster_Food_1_Gallery_550_550.jpg', 'Gallery'),
(265, 46, 'Oxbow_Essentials_Hamster_Food_2_Gallery_550_550', './Images/Hamster_Food/Oxbow Essentials Hamster Food and Gerbil Food/Gallery/Oxbow_Essentials_Hamster_Food_2_Gallery_550_550.jpg', 'Gallery'),
(268, 47, 'Vitakraft_Hamster_Treat_Stick_1_Card_319_409', './Images/Hamster_Food/Vitakraft Hamster Treat Stick/Card/Vitakraft_Hamster_Treat_Stick_1_Card_319_409.jpg', 'Card'),
(269, 47, 'Vitakraft_Hamster_Treat_Stick_1_Gallery_550_550', './Images/Hamster_Food/Vitakraft Hamster Treat Stick/Gallery/Vitakraft_Hamster_Treat_Stick_1_Gallery_550_550.jpg', 'Gallery'),
(270, 47, 'Vitakraft_Hamster_Treat_Stick_2_Gallery_550_550', './Images/Hamster_Food/Vitakraft Hamster Treat Stick/Gallery/Vitakraft_Hamster_Treat_Stick_2_Gallery_550_550.jpg', 'Gallery');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `warrantyPeriod` varchar(255) NOT NULL,
  `productDimensions` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `productCatId` int(11) NOT NULL,
  `staffId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `name`, `price`, `quantity`, `status`, `description`, `brand`, `weight`, `warrantyPeriod`, `productDimensions`, `createdAt`, `updatedAt`, `productCatId`, `staffId`) VALUES
(1, 'Alpo Dry Adult Dog Food Pack', 25, 198, 1, 'ALPO® was formulated to meet the nutritional levels of established by Association of American Feed Control Official (AFFCO) Dog Food Nutrients Profiles for the growth and reproduction dogs.\r\n\r\nSafety Information:\r\nStore in a cool, dry place, with no contact to sunlight.\r\n\r\nInstruction:\r\nWhen switching to ALPO®, allow 7 – 10 days for the transition first. Gradually add more ALPO® and less of the previous food to your dog’s dish every day until the changeover is complete. \r\n\r\nIngredients:\r\nChicken, Liver and Vegetables.\r\n\r\nTest', 'ALPO', '3kg', '7 days', '25 x 15 x 40 cm', '2021-10-10 16:34:20', '2021-11-03 10:25:14', 1, NULL),
(2, 'CESAR Dog Food Beef x6 Dog Tray Dog Wet Food', 20.5, 1, 1, 'Cesar® Naturally Crafted Dog Food is made from high quality & natural ingredients with an irresistible taste that your dog will love. It is designed with no artificial colours, flavours, and preservatives.\\n\r\n•Premium Dog Food with Irresistible taste\\n\r\n•Manufactured with variety of Menus and vitamins\\n\r\n•Higher Protein\\n\r\n•Suitable for adult dog', 'Cesar', '100g', '7 days', '15 x 15 x 5 cm', '2021-10-10 16:44:33', '2021-11-13 16:28:49', 1, NULL),
(3, 'CESAR Dog Food Naturally Crafted Aust Beef X6 Dog Wet Food', 20.5, 4, 1, 'Cesar® Naturally Crafted Dog Food is made from high quality & natural \r\ningredients with an irresistible taste that your dog will love. It is designed \r\nwith no artificial colours, flavours, and preservatives. This delicious \r\nmeal is crafted in Australia.\\n\r\n•Natural Ingredients with added vitamins & mineral\\n\r\n•No Artificial Color, Flavors or Preservative\\n\r\n•Made from Fresh Ingredients\\n\r\n•Complete & Balanced\\n\r\n•Australian made\\n\r\n•Suitable for adult dog\\n\r\nCESAR® brand is always looking to unlock more shared moments of joy between you and your furry friend. Love them back with Cesar® Naturally Crafted.\r\n', 'Cesar', '85g', '7 days', '15 x 15 x 5 cm', '2021-10-10 16:44:33', '2021-11-01 10:47:33', 1, NULL),
(4, 'GREENIES Treatpack Petite Dog Dental Care', 19.6, 40, 1, '• Vet-Recommended Dental Treat Chew Snack for Dog\\n\r\n• Chewy Texture cleans Teeth & Help Maintain Healthy Gums for a Sparkle\\n\r\n• Made with Natural Ingredients Plus Vitamins, Minerals and Nutrients\\n\r\n• Freshens breath & makes mouth happy day after day\\n\r\n• Easy to digest due highly soluble ingredients\\n\r\n• Delicious & nutritious balanced recipe for healthy treating\\n\r\nSafety Information:\\nAs with any edible product, monitor your dog to ensure the treat is adequately chewed. Gulping any item can be harmful or even fatal to a dog.\\n\r\nInstruction:\\nFEED 1 GREENIES dental treat per day. For dogs 7-11 kg Not suitable for dogs less than 5 lbs. or dogs less than 6 months of age. Fresh drinking water should always be available.\\n\r\nIngredients:\\nWheat flour, glycerin, wheat gluten, gelatin, water, powdered \r\ncellulose, lecithin, minerals (dicalcium phosphate, potassium chloride, calcium \r\ncarbonate, magnesium amino acid chelate, zinc amino acid chelate, iron amino acid \r\nchelate, copper amino acid chelate, manganese amino acid chelate, selenium, \r\npotassium iodide), natural poultry flavor, choline chloride, fruit juice color, vitamins (dl-alpha tocopherol acetate [source of vitamin E], vitamin B12 supplement, d-calcium pantothenate [vitamin B5], niacin supplement, vitamin A supplement, riboflavin supplement [vitamin B2], vitamin D3 supplement, biotin, thiamine mononitrate [vitamin B1], pyridoxine hydrochloride [vitamin B6], folic acid), turmeric color.', 'Greenies', '85g', '7 days', '15 x 2 x 21 cm', '2021-10-10 17:02:16', '0000-00-00 00:00:00', 1, NULL),
(5, 'IAMS Proactive Health', 15.9, 59, 1, 'IAMS Adult Dog nourishes your active dog with essential nutrients and prebiotics for a healthy body inside and out.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nInstruction:\\nThis diet contains 364 kilocalories of metabolizable energy \r\n(ME) per 100 gms. Remember to have clean, fresh water available for your dog at all times.\\n\r\nIngredients:\\nPoultry and poultry by product, Corn, Wheat, Barley, Chicken oil, Maize Gluten, Flavor, Beet Pulp, Minerals, Grain Distillers, Dried Yeast, Fish oil, Choline Chloride, Vitamins, \r\nFructooligosaccharide, Methionine, Preservatives.\r\n', 'IAMS', '3.5kg', '7 days', '25 x 15 x 40 cm', '2021-10-10 17:02:16', '0000-00-00 00:00:00', 1, NULL),
(6, 'PEDIGREE Can Dog Wet Food Adult Chicken', 12.2, 263, 1, '-Good for skin health & makes dog hair shine.\\n\r\n-Maintain Dog bone health & strength.\\n\r\n-Maintain Dog digestion.\\n\r\n-Make Dog muscles stronger.\\n\r\n-Nutrition is right for building a good dog immune system.\\n\r\nSafety Information:\\nStore in a cool, dry place out of the sun.\\n\r\nInstruction:\\nIf you are just starting to feed your dog PEGIFREE Home Style, mix steadily increasing amounts of PEDIGREE Home Style with your dog\'s current food over a period of 7 consecutive days.\\n\r\nIngredients:\\nChicken by product, beef by product, chicken mince, chicken, viscera, sheep lung, beef liver, gel, minerals, whole wheat, fibre, sunflower oil, colouring agents, wheat gluten, vitamins, flavour, amino acid, preservatives.', 'Pedigree', '400g', '7 days', '20 x 20 x 25 cm', '2021-10-10 17:08:17', '0000-00-00 00:00:00', 1, NULL),
(7, 'PEDIGREE Dentastix Medium Dog Treats', 7.5, 40, 1, '• PEDIGREE® DENTASTIX™ Dog Snack with TRIPLE ACTION+ are scientifically proven to reduce the build-up of tartar by up to 80%.\\n\r\n• Dog Treats Low in fat, no added sugar and free from artificial colours and flavours.\\n\r\n• Clean hard to reach teeth.\\n\r\n• Support gum health.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nInstruction:\\nFor adult breed dog (1 year up) 1 piece/day.\r\n', 'Pedigree', '980g', '7 days', '12 x 0.5 x 18 cm', '2021-10-10 17:08:17', '0000-00-00 00:00:00', 1, NULL),
(8, 'PEDIGREE Dog Dry Food Adult Chicken & Vegetable Flavour', 131.9, 32, 1, '-Good for skin health & makes dog hair shine.\\n\r\n-Maintain Dog bone health & strength\r\n-Maintain Dog digestion.\\n\r\n-Make Dog muscles stronger.\\n\r\n-Nutrition is right for building a good dog immune system.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nIngredients:\\nCereals (Com, Wheat), Poultry and Poultry by Products, Soybean Products (Soy Bean Meal, Full Fat Soy Bean), Oils (Palm, Soybean), Minerals, Flavours, Vitamins, Methionine, Food Colouring, Preservatives, Dietary Fiber, Dried Vegetables.\r\n', 'Pedigree', '20 kg', '7 days', '50 x 14 x 65 cm', '2021-10-10 17:19:53', '0000-00-00 00:00:00', 1, NULL),
(9, 'PEDIGREE Dog Dry Food Puppy Chicken, Egg & Milk', 25, 180, 1, 'Breast milk contains many elements that support puppies immune system and help them grow up with proper physical and congenital development. PEDIGREE Puppy is the night choice after mother\'s milk for puppies, which con- tains Zinc and Vitamin A to support healthy immune system, Calcium and Phosphorus to support strong teeth and bones plus DHA and choline to nourish his nervous system. PEDIGREE Puppy helps him grow strong and lets him enjoy all his puppy adventures.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun. Remember to have clean, fresh water available for your dog at all times.\\n\r\nIngredients:\\nCereal Rice, Com, Wheat, Poultry and poultry by products, Soy bean Products (Soy Bean Meal Full fat soybean), Oil Palm, Chicken, Soy Fish (Source of DHA), Flavour, Wheat Flour Minerals, Com Gluten Meal lodised salt, Vitamins, Dietary Fiber Food Colouring Preservative Methionne, Egg Powder.', 'Pedigree', '2.7kg', '7 days', '25 x 13 x 40 cm', '2021-10-10 17:45:02', '0000-00-00 00:00:00', 1, NULL),
(10, 'SUPERCOAT ADULT SMALL BREED Chicken Dry Dog Food', 35.9, 73, 1, 'SUPERCOAT®SMARTBLEND® It takes a precise combination of nutrients to keep your dog in top condition. Which is why the experts at PURINA®have developed SMARTBLEND®. Inspired by nature and blended with scientific precision, SMARTBLEND®is a complete and balanced nutrition designed to promote your dogs’ whole body health. BLENDED WITH SCIENTIFIC PRECISION Scientifically formulated with the right balance of protein, fats/oils, vitamins, minerals, carbohydrates and water to meet your dog\'s daily essential nutritional needs. NATURAL High quality natural ingredients, with no added artificial colors or flavors. QUALITY REAL MEAT High quality real meat as the primary protein sources to help build strong muscles. TAILORED NUTRITION Unique SMARTBLEND®formulas developed by PURINA®Nutritionists tailored to nutritional needs by life stages, breed sizes and health needs. GREAT TASTE High palatability to ensure your dog enjoys his food and finishes his meal so he can get the full nutrition that he needs.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\r\n', 'Purina', '3kg', '7 days', '16 x 4 x 20 cm', '2021-10-10 17:45:13', '0000-00-00 00:00:00', 1, NULL),
(11, '5M Retractable Dog Leash Automatic Extending Reflective Nylon Dog Leads with Strong Carabiner Hook', 55.9, 8, 1, '◾Retractable leash with stop-and-lock control.\\n\r\n◾Reflective stitching cord on both side for night time safety.\\n\r\n◾Click & Lock Snap for extra safety, once locked, dog cannot run away.\\n\r\n◾Ergonomically designed, sturdy and super soft anti-slip handle for comfortable strong grip.\\n\r\n◾High strength stainless spring hardware for retraction system.\r\n', 'DOCO', '800g', '1 year', '25 x 3 x 20 cm', '2021-10-10 17:33:30', '0000-00-00 00:00:00', 2, NULL),
(12, 'Heavy Duty Stainless Steel Gold Cuban Curb Link Chain Dog Collar ', 39.9, 5, 1, 'A cool dog should have a cool, designer dog collar! Perfect as a pitbull collar, our fancy dog chain is strong, stylish, and comfortable. The Cuban-link slip chain is made of ultra-strong 316L Stainless Steel, which will NEVER rust or irritate your dog\'s skin.\\n\r\n▸ Dog Jewelry - Dog jewellery and designer dog collars keep getting more popular, but most are made for small wimpy dogs. The heavy-duty design of this collar will make your pitbull or large dog look even cooler!\\n\r\n▸ Strong & Durable - Stainless steel is incredibly strong and will never rust or tarnish, making it the perfect material for a metal dog collar. Each dog collar is made of solid 316L stainless steel, and has a polished finish.\\n\r\nSize: 14\'(35.5cm),suit for neck girth 10\'\'(25.4cm).', 'No Brand', '1.4kg', '1 year', '60 x 3 x 0.5 cm', '2021-10-10 17:44:34', '0000-00-00 00:00:00', 2, NULL),
(13, 'Indestructible Pet Chew Toys Bone for Puppy Dogs', 14.9, 32, 1, '1. Made of durable nylon,safe non-toxic and durable.\\n\r\n2. Chewing help clean teeth and control plaque and tartar, effectively cleans teeth to promote oral health soothes discomforts from teething.\\n\r\n3. Irresistible Flavor, smell good. Your dog must love it!\\n\r\n4. Creates positive association with toys for dogs and reduces their anxiety and boredom.\\n\r\n5. We have three different sizes of products suitable for different dogs.\\n\r\nMaterial: Nylon', 'Wayhome', '300g', '1 year', '15 x 5 x 4 cm', '2021-10-10 17:44:34', '0000-00-00 00:00:00', 2, NULL),
(14, 'Interactive Traction Cotton Rope Dog Toy', 4.9, 13, 1, 'This bone-shaped chew toy has a bone-shaped design and is very creative and attractive. With this chewing, you can keep the dog\'s teeth healthy and clean.\r\nThe pet toy is made of high quality cotton material and is durable.', 'No brand', '200g', '1 year', '40 x 4 x 5 cm', '2021-10-11 06:54:39', '0000-00-00 00:00:00', 2, NULL),
(15, 'MIAODODO Thin Summer Basketball Shirt for Dogs', 17.9, 10, 1, 'Have some fun with your dog with our basketball shirts made with quality nylon fabric.\\n\r\nColor: Navy Blue\\n\r\nSize: Suitable for large dogs', 'Miaododo', '100g', '1 year', '15 x 8 x 6 cm', '2021-10-11 06:54:39', '0000-00-00 00:00:00', 2, NULL),
(16, 'Pet Dog Black Polices K-9 Unit Vest T-Shirt', 10.9, 8, 1, 'This dog apparel is with attitude!\\n\r\nCool and fashionable, comfortable to wear.\\n\r\nExcellent gifts for dogs and dog lovers.\\n\r\nType: Dog Vest\\n\r\nGender: Unisex\\n\r\nMain Color: Black\\n\r\nMaterial: Polyester\\n\r\nStyle: Fashion, Casual, Cool\\n\r\nFeatures: Summer T-Shirt, Polices K-9 Unit\r\n', 'No brand', '100g', '1 year', '30 x 20 x 20 cm', '2021-10-11 07:02:35', '0000-00-00 00:00:00', 2, NULL),
(17, 'Reflective Rope Pet Dog Leash Nylon Traction Rope Running Strap Belt Glow Lead', 31.9, 10, 1, '1. Color：Black\\n\r\n2. Pattern：Basic Leash\\n\r\n3. Material：Nylon，Reflective Material\\n\r\n4. Suitable for：Dogs and other Pets\\n\r\n5. Size：1.2cm Width，150cm Length\\n\r\nType:Braided Pet Dog Leads Climbing Rope\\n\r\nMaterial:Nylon\\n\r\n⭐ This is a mountain climbing rope dog leash. Strong and durable.\\n\r\n⭐ Fit most of breeds. It is not only a great every day leads, it also looks stylish!\\n\r\n⭐ Reflective thread to make the leash perceptible in the dark.\\n\r\n⭐ It is a great choice for dog that like to chew leads. Can be used as a training dog leash and everyday leadsh as well!\\n\r\n⭐ Exquisite workmanship.\\n\r\n⭐ Quality hardware making,it a true heavy duty dog leads.\\n\r\n⭐ Size:Diameter:1.2cm;Total Length:5 Feet(150cm)\\n\r\n⭐ Package Inlcude:1x Dog Lead.\\n\r\n⭐ Note: Please allow 0.5-1 inch(1-3 cm) error due to manual measurement.', 'No brand', '500g', '1 year', '150 x 3 x 3 cm', '2021-10-11 07:02:35', '0000-00-00 00:00:00', 2, NULL),
(18, 'Folding Portable Mesh Breathable Dog Bag', 59.9, 30, 1, 'Extremely portable pet bag carrier suitable for small and medium sized pets. Made of high quality mesh fabric for extra durability and flexibility that allows for the bag to be foldable.\r\nColor: Green & Black', 'No brand', '500g', '1 year', '42 x 27 x 26 cm', '2021-10-11 07:21:21', '0000-00-00 00:00:00', 3, NULL),
(19, 'idropmy Pet Toilet Mat Puppy Potty Pad Training Seat Tray', 17.9, 20, 1, '3 layers; odor resistant mat, plastic mesh tray and durable collection tray\\n\r\n3-layer system captures odor and moisture\\n\r\nAn innovative way of teaching your dog where to go to the toilet when they can’t go outdoors\\n\r\nGood for indoor or outdoor use\\n\r\nWaste tray guaranteed not to leak & Easy to clean\\n\r\nMaterial :  ABS ', 'idropmy', '980g', '1 year', '34 x 47 x 5.5 cm', '2021-10-11 07:21:21', '0000-00-00 00:00:00', 3, NULL),
(20, 'Nanovet Pet Medicated Shampoo 500ml', 19.9, 36, 1, 'Nanovet Antifungal & Antibacteria Medicated Shampoo helps relieve bacteria skin infections related to allergies grooming and scratching. Provides relief from itching due to fungal infections and ph balanced. It is suitable for long and short-coated puppies. It uses a new Nano Technology to achieve over 99.99% effect preventing the growth of numerous kinds of bacteria, including multi-drug resistant bacteria and fungi.\\n\r\nInstruction:\\nUse warm water to wet the pet\'s coat thoroughly. Lather coat evenly from head to paws with shampoo and massage. Leave on for 3-5 minutes to allow the shampoo to penetrate the coat and reach the skin. Rinse well and repeat if necessary. Keep your pet warm until dry. Not to exceed 2 shampoos in 24 hours. \r\nIngredients:\\nSodium Lauryl Ether Sulfate, Sodium Laureth Sulfosuccinate, Lauramidopyl Betaine, Coconut Diethanolamide, Glycerin, Glycol Distearate, Polyquaternium 7, Propylene Glycol, Preservative, Citric Acid, Fragrance.', 'Nanovet', '1.2kg', '1 year', '10 x 10 x 20 cm', '2021-10-11 07:27:00', '2021-11-01 10:45:29', 3, NULL),
(21, 'Oxyfresh Premium Pet Dental Care Solution Pet Water Additive (16oz)', 39.9, 36, 1, 'All-Day Pet Fresh Breath – Finally say goodbye to pet bad breath with our fast-acting, patented formula of Oxygene® and zinc. We don’t just mask bad pet breath; we safely neutralize it at the source.\\n\r\nClean Teeth and Gums – The easiest way to clean pets’ teeth, help protect against periodontal disease and strengthen gum tissue.\\n\r\nSafe for Cats and Dogs – We use only 100% non-toxic ingredients that matter to pets’ dental health.\\n\r\nPets Love It Because It’s Tasteless and Odorless – Our Pet Dental Water Additive is undetectable so even the pickiest pets won’t know it’s there.', 'Oxyfresh', '1.2kg', '1 year', '8 x 8 x 18 cm', '2021-10-11 07:27:00', '0000-00-00 00:00:00', 3, NULL),
(22, 'Training Pads, Pack of 100', 39.9, 40, 1, 'Size: 100 Count (Pack of 1)\\n\r\nQuick drying surface prevents tracking.\\n\r\nThe super-absorbent core can turn urine into gel instantly and hold up to 3 cups of liquid.\\n\r\nBuilt-in attractant and odor neutralizer.\\n\r\nPerfect for training puppies or assisting aging dogs.', 'All-Absorb', '1.3kg', '1 year', '56 x 58 x 30 cm', '2021-10-11 07:38:16', '0000-00-00 00:00:00', 3, NULL),
(23, 'Vet’s Best Enzymatic Dog Toothpaste', 12.9, 27, 1, '-SOOTHING AND EFFECTIVE - Vet’s Best Enzymatic Dental Gel Toothpaste is a veterinarian formulated soothing and effective mix of aloe, neem oil, grapefruit seed extract, baking soda, and enzymes\\n\r\n-CLEANS AND FRESHENS - Freshens breath and gently cleans away plaque and tartar\\n\r\n-PART OF A HEALTHY REGIMEN - Supports your dog’s dental hygiene between annual cleanings at your vet’s office\\n\r\n-NATURAL FLAVORS - Your dog will love the great taste. You will love how it brightens and whitens teeth while freshening the breath\\n\r\n-SAME FORMULA, NEW PACKAGE - The same great Vet’s Best dental gel is now available in an easy to use squeeze tube', 'Vet\'s Best', '300g', '1 year', '3.44 x 1.5 x 9 inches', '2021-10-11 07:38:16', '0000-00-00 00:00:00', 3, NULL),
(24, 'Vumdua Dog Food Storage Container with Serving Scoop', 20.9, 3, 1, '✔ SPACIOUS CAPACITY: The dog treat container measures 6.69\" (L) x 5.9\" (W) x 9.05\" (H) and holds up to 5-6 lbs of your dog\'s favorite dry food, treats or biscuits. These tins store on the counter, always ready to reward your dog for good behavior.\\n\r\n✔ STURDY AND DURABLE : Unlike glass containers that easily shatter, this dog food storage container made from food-safe, powder-coated galvanized steel and it won\'t break after long time of use. Easy to clean, just it wipe clean with a damp cloth.\\n\r\n✔ KEEPS PET FOOD FRESH: This airtight pet food storage containers with new upgraded rubber seal lid design to ensure treats stay fresh longer. Keep your pet\'s food neat and clean, perfectly stored to keep curious paws at bay.\\n\r\n✔ INCLUDED SERVING SCOOP: The dog food storage bin comes with a metal scoop that can hang on the side of the storage bin for conveniently transferring the food to dog\'s or cat\'s bowl. With metal carrying handles for easy to grasp when using it.\\n\r\n✔ BEATIFUL AND FUNCTIONAL: No more dealing with unsightly dog food bags. Whether on display on your countertop, or store in your pantry, the cute dog food storage container is an eye-catching focus. Add a touch of farmhouse style for your counter.', 'Vumdua', '760g', '1 year', '6.69 x 5.59 x 9.05 inches', '2021-10-11 07:41:18', '0000-00-00 00:00:00', 3, NULL),
(25, 'IAMS Cat Dry Food Adult Indoor Weight & Hairball Care Chicken 3kg Cat Food', 72.2, 18, 1, '* Formulated Cat Food with high quality protein sources to help your cat mantain strong muscle\\n\r\n* Formulated with Omega 6 and Omega 3 fatty acids to help support healthy skin and coat\\n\r\n* Crunchy kibbles help reduce plaque and tartar build up that lead to bad breath\\n\r\n* Formulated to help maintain urinary tract health \\n\r\n* Prebiotics and beet pulp to help support your cat digestive system\\n\r\nSafety Information:\\nStore in a cool, dry place away from direct sunlight.\\n\r\nInstruction:\\nAlways ensure fresh water is available.\\n\r\nIngredients:\\nChicken, Wheat, Corn, Sorghum, Natural Flavours, Chicken Fat, Turkey, Beet Pulp, Cellulose, Salt, Minerals, Whole Egg, Brewer\'s Yeast, Vitamins, Fish Oil, Methionine, Calcium Sulphate Dihydrate, Taurine, Fructoologosaccharides, Antioxidants, Flavour, Yucca Extract, L-Carnitine. ', 'IAMS', '3kg', '7 days', '20 x 12 x 38 cm', '2021-10-11 07:49:44', '2021-11-13 16:26:40', 4, NULL),
(26, 'IAMS Cat Dry Food Adult Ocean Fish 3kg Cat Food', 50.9, 33, 1, '* Formulated Cat Food with high quality protein sources to help your cat mantain strong muscle\\n\r\n* Formulated with Omega 6 and Omega 3 fatty acids to help support healthy skin and coat\\n\r\n* Crunchy kibbles help reduce plaque and tartar build up that lead to bad breath\\n\r\n* Formulated to help maintain urinary tract health\\n\r\n* Prebiotics and beet pulp to help support your cat digestive system\\n\r\nSafety Information:\\nAlways ensure fresh water is available. Store in a cool, dry place away from direct sunlight.\\n\r\nIngredients:\\nChicken, Wheat, Corn, Chicken Fat, Natural Flavours, Corn Gluten, Tuna, Turkey, Beet Pulp, Salt, Whole Egg, Brewer\'s Yeast, Minerals, Vitamins, Fish Oil, Methionine, Calcium Sulphate Dihydrate, Taurine, Fructooligosaccharides, Antioxidants.', 'IAMS', '3kg', '7 days', '25 x 12 x 32 cm', '2021-10-11 07:49:44', '2021-11-04 08:54:43', 4, NULL),
(27, 'SHEBA Can Cat Wet Food Adult Succulent Chicken Breast with Prawn 85gm x 6 Cat Food', 21.9, 7, 1, 'Superior Quality Wet Cat Food\\n\r\nComplete and Balanced Wet Cat Food\\n\r\nFinest Cat Food Main Meal\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nIngredients:\\nChicken Breast, Prawn, Thickening Agents (Modified Starch, Guar Gum).', 'Sheba', '850g', '7 days', '10 x 10 x 5 cm', '2021-10-11 13:04:52', '2021-11-13 16:26:39', 4, NULL),
(28, 'SHEBA Melty Cat Treat Tuna & Tuna Seafood x4 (48g)', 7.9, 53, 1, '• Hand Feed Lovingly\\n\r\n• Create bonding moment\\n\r\n• Japanese Recipe\\n\r\n• Finest Cat Snack\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n \r\nIngredients:\\nChicken meat, Tuna, Thickening agents, Flavor, Pangasius, Preservative, Coloring agent.', 'Sheba', '12g', '7 days', '12 x 15 x 1.5 cm', '2021-10-11 13:04:52', '0000-00-00 00:00:00', 4, NULL),
(29, 'TEMPTATIONS Cat Treat Adult Tasty Chicken 85gm Cat Snack', 8.2, 25, 1, '1. Delicious dual-textured cat treats with a tasty, crunchy outside and an irresistible soft centre.\\n\r\n2. Available in different flavour such as tasty chicken, creamy dairy, savoury salmon, seafood medley and tempting tuna flavour.\\n\r\n3. Less than 2 Kcal in every cat treat.\\n\r\n4. With no artificial flavours.\\n\r\n5. Resealable Pouch to keep your cat snack fresh.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\n\\nIngredients:\\nChicken by Product Meal, Corn, Beef Tallow, Beef Blood Plasma, Rice, Wheat Flour, Favours, Grain Distillers Dried Yeast, Minerals, Vitamins, Taurine, Salt, Antioxidants, Cheese Powder Guaranteed Analysis: Protein (min) 30%, Fat (min) 17%, Fiber (max) 4.5%, Moisture (max) 12%, Ash (max 12%, Calcium (min) 0.6%, Phosphorus (min) 0.5%.', 'Temptations', '85g', '7 days', '14 x 2 x 18 cm', '2021-10-11 13:09:27', '0000-00-00 00:00:00', 4, NULL),
(30, 'WHISKAS Dry Cat Food Junior Ocean Fish 1.1kg Cat Dry Food', 13.9, 200, 1, '1. WHISKAS dry  cat food is complete and balanced, specially designed to fulfil your cat’s needs at their life stage.\\n\r\n2. Tasty pockets - Crunchy on the outside with a creamy delicious texture in the centre.\\n\r\n3. The kibbles and pockets of WHISKAS Dry cat food will help promote their oral care.\\n\r\n4. Enriched with omega 3&6, fatty acids and zinc for healthy skin and shiny coat.\\n\r\n5. Enhanced Vitamin A and taurine for healthy Eyesight.\\n\r\n6. Selected quality protein from real fish, including fat, vitamins & minerals for lively and energetic.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nIngredients:\\nCereal (Con, Rice), Poultry and Poultry by Products, Oils (Palm, Soy). Soy bean meal, Flavours. Wheat flour, Minerals, Corn gluten meal, Milk powder, Vitamins, lodised salt, Methionine, Taurine, Preservatives.', 'Whiskas', '1.1kg', '7 days', '20 x 15 x 27 cm', '2021-10-11 13:09:27', '0000-00-00 00:00:00', 4, NULL),
(31, 'WHISKAS Dry Cat Food Mackerel (20kg)', 172.9, 60, 1, '1. WHISKAS dry cat food is complete and balanced, specially designed to fulfil your cat’s needs at their life stage.\\n\r\n2. Tasty pockets - Crunchy on the outside with a creamy delicious texture in the centre.\\n\r\n3. The kibbles and pockets of WHISKAS Dry cat food will help promote their oral care.\\n\r\n4. Enriched with omega 3&6, fatty acids and zinc for healthy skin and shiny coat.\\n\r\n5. Enhanced Vitamin A and taurine for healthy eyesight.\\n\r\n6. Selected quality protein from real fish, including fat, vitamins & minerals for lively and energetic.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.\\n\r\nIngredients:\\nWholegrain Cereal (Com, Wheat), Poultry and poultry by products. Soy bean product Full-fat soy bean Soy bean meal), Com gluton meal, Vegetables oil (Palm sterine, soy, oil). Ocean Fish, Wheat Flour, Minerals, lodisod Salt, Vitamins. Taurine Methionine. Food Coloring Preservatives, Flavour.', 'Whiskas', '20kg', '7 days', '50 x 18 x 60 cm', '2021-10-11 13:13:31', '0000-00-00 00:00:00', 4, NULL),
(32, 'WHISKAS Pouch Multipack Cat Food Adult 1+ Ocean Fish + Tuna + Tuna & Whitefish 85g (12 packs)', 19.9, 61, 1, '1. Specially designed to be complete and balanced for cats aged 1 year old and above.\\n\r\n2. Enriched Cat Food with omega 3 & 6, fats and zinc for a healthy and shiny coat.\\n\r\n3. Complete with vitamin A and taurine for healthy eyesight.\\n\r\n4. Filled with proteins from real fish, including fats, vitamins and minerals, so your cat stays fit and happy.\\n\r\n5. Contains antioxidants (vitamin E and selenium) for a healthy immune system.\\n\r\n6. Soft texture wet cat food for easy consumption.\\n\r\nSafety Information:\\nPlease store this pack in a cool, dry place, out of the sun.', 'Whiskas', '85g', '7 days', '21 x 10 x 15 cm', '2021-10-12 06:55:54', '0000-00-00 00:00:00', 4, NULL),
(33, 'Premium Clumping Cat Limited Edition', 59.99, 17, 1, 'Description:\r\n\\nNOTE - Item package indicates weight in both Kg and lb. 40 Lb is equal to 18.14 Kg. Fill clean, dry litter box with 3″ to 4″ of Dr. Elsey’s litter. Scoop waste twice daily and refill box as necessary. Replace entire box once a month. Dispose of used litter in trash. DO NOT FLUSH\r\n99.9% dust free, hypo-allergenic natural litter to keep your surfaces clean and perfect for families who suffer from allergies.\r\n\\n-Hard clumping, medium-grain clay makes it the perfect clumping litter that helps prevent moisture\r\n\\n-Multi-cat formula and superior odor control keeps your home smelling clean and fresh day in and day out\r\nIdeal for sifting and mechanical litter boxes so it\'s easier for you to dispose of your kitty\'s waste\r\n\\n-Forms hard clumps that don\'t break down making easier to scoop up and clean the box twice daily\r\n\\-A clay litter uniquely formulated combining heavy non tracking granules with medium grain. The result is an excellent clumping litter that prevents moisture from reaching the bottom of the litter box, while providing a clump that will not break apart. Ultra is perfect for multi-cat families and cat owners with sifting or mechanical litter boxes and it controls odor naturally without perfume, deodorants or chemicals.\r\n\\nSafety Information:\r\n\\nWash your hands thoroughly after handling the litter box. Properly disposing of urine clumps and cat feces, is beneficial to overall water quality. Please do not flush or dispose of it outdoors in gutters or storm drains.\r\n\\nInstructions:\r\n\\nPlace about 3 inches in litter box. The depth allows cats to dig and cover their waste naturally. Scoop out waste balls daily with a scooper and throw out waste. Do not flush. Add as needed to maintain litter box. Always wash hands after handling box.\r\n\\nIngredient:\r\n\\n100% bentonite clay', 'Dr. Elsey\'s Cat Products', '18.14kg', '1 year', '20 x 14 x 4 inches', '2021-10-12 06:35:26', '2021-10-10 07:56:21', 5, NULL),
(34, 'Kitty City XL Wide Corrugate Cat Scratchers 3 Pieces, Cat Scratching, Cat Scratch Pad', 45.99, 2, 1, 'Description:\r\n\\nKitty City scratchers are the smart, economical way to protect your valuable furnishings. Our scratchers look great in a home, they take extraordinary abuse and they support a cat\'s inbred desire to sharpen its \"tools.\" Our 1 best basic product, rotate for 3x the use, recycled cardboard and non-toxic corn starch glue.\r\n\\nSafetyInformation:\r\n\\nDo not allow children to play with or near this item. This is not a toy for children. IF PRODUT BECOMES DAMAGED PLEASE DISCARD IMMEDIATELY. This product is designed for a specific and intended use. Do not use this product for anything other than its intended use. FOR PET USE ONLY.\r\n\\nInstructions:\r\n\\nUse as pet toy.', 'SportPet Designs', '458g', '1 years', '18 x 10 x 1.5 inches', '2021-10-12 06:35:40', '2021-10-10 07:56:21', 5, NULL),
(35, 'Rabbitgoo Cat Tree Cat Tower 61\" for Indoor Cats, Multi-Level Cat Condo with Hammock & Scratching Posts for Kittens, Tall Cat Climbing Stand with Plush Perch & Toys for Play Rest', 399.99, 6, 1, 'Description:\r\n\\n(Spacious & Versatile Fun Center) - No matter your kitten wants to overlook the world on the top perch, melt into the luxury deep hammock, or feel spoiled in the cozy cradle, this multi-purpose cat tree works perfectly as a recreation paradise! Your furry friends can play with the interactive hanging ball and loop, tour freely in their castle across the platforms, or just be lazy inside the warm condo - Exploration never ends!\r\n\\n(Designed to Fulfill Your Cat\'s Nature) - This indoor cat tower is a go-to spot for your cat to play, exercise, and relax. Multiple scratching posts reinforced with natural sisal rope will satisfy your cat’s instinct of scratching. Multiple layers and ladder also meet your feline’s climbing nature. The cozy cat condo is a perfect hideaway for your sensitive baby to enjoy privacy. The top perch with raised edge feeds your cat’s desire to look out the window and to take a sunbath on sunny days.\r\n\\n(Sturdy Construction for Maximum Safety) - Crafted of heavy-duty particle wood, the strengthened base plates double secure the overall stability so this tall cat house won’t shake or fall when your cat jumps in or out. The robust posts are made of high-density particle wood tubes which can bear lots of weight and hold all platforms firmly without any wobbling, ideal for large kittens and average cats.\r\n\\n(Superior Quality Materials) - All platforms and supporting posts are made of strong P2-grade particle wood, ensuring the safety of your restless cat while jumping up and down this cat climbing tower. The skin-friendly plush covering gives feline-friendly softness and optimum warmth which your cat will never get enough of. The durable sisal rope allows your cat to sharpen the nails while saving your delicate furniture from scratches.\r\n\\n(Easy Assembly Cat Tree) - Easy-to-use cat playground equipped with detailed graphic instructions for hassle-free installation. Overall dimension - 26.3” L x 19.6” W x 61” H (67x50x155cm). This attractive cat trees and towers in elegant gray will blend nicely with your room decor as a piece of modern cat furniture. A purrrfect gift for both your kitten and your sweet home!\r\n\\nSafetyInformation:\r\n\\nThe package contains small assembly parts. Please keep away from your pets or children. Refer to the user manual for more information on the installation and what to do if any part is missing.\r\n\\nInstructions:\r\n\\n1. Keep this manual and all accessories in a safe place for your future reference.\r\n\\n2. Keep all small parts away from your children or pets.\r\n\\nMain Ingredient:\r\n\\nFrame Structure: Manufactured P2 Particle Board\r\n\\nExterior Cover: Faux Fur Fabric; Natural Sisal Ropes\r\n\r\n', 'GLOBEGOU CO.,LTD', '16 kg', '2 years', 'Overall Dimensions: 26.3” L x 19.6” W x 61” H (67 L x 50 W x 155 H cm)\r\n\\nCondo Interior: 13.4” x 11.8” (34 x 30 cm)\r\n\\nTop Perch Diameter: 11.8” (30 cm)\r\n\\nScratching Post Thickness: 2.55” (6.5 cm)', '2021-10-12 06:50:40', '2021-10-10 07:56:21', 5, NULL),
(36, 'MeoHui Interactive Cat Feather Toys, 2PCS Retractable Cat Wand Toy and 9PCS Squiggly Worm Feathers Teaser Refills,\r\nCat Toys for Indoor Cats Kitten Play Chase Exercise', 9.99, 30, 1, 'Description:\r\n\\n1. EXCITING ENTERTAINMENT FOR CATS: Cats are crazy about chaser games! Combine string and feather into a great cat toy, this cat feather toy is an irresistible lure for cats! Swing this feathers \" lure\" will get your cats excited and bring out the \" hunt instinct\", making them running and jumping like a wild animal, driving your cats crazy with joy! Even adult cat play like a kitten again!\r\n\\n2. CLASSIC PRACTICAL INTERACTIVE CAT TOY: This interactive cat toy wand will help your Indoor cats to flip, jump, pounce, chase. Great way to get your cats energy out and do more exercise, making your cat be released and happy! Suitable for kittens and cats of all ages and sizes! A great toy to spend some quality time with your feline friend! Enjoy the happiness time with our toy! This is a CLASSIC cat toys for indoor cats, give your fur baby a try!\r\n\\n3. TELESCOPIC FISHING POLE DESIGN: This cat toys wand extends from 15” in to 38.9”. It\'s very light, flexible, durable and easy to store. The fully extend cat wand is long enough( 38.9 in) plus the string (23.6in) which can cover a large space for playing, it can really get your cats exercise. And it\'s very light so that cat-teasing is no longer a tough job for you. You can even sit on the couch watching TV while teasing cats with this cat kitten toys.\r\n\\n4. HIGH QUALITY AND SAFETY: The feathers made from Safe, natural material. The telescopic cat wand made of the new material with higher elasticity and hardness. Our clasp is easy to open and close for changing feathers. Package includes: 2Pcs Cat Wand + 9Pcs Feather Worms Refills + 2Pcs Extra Strings with Clasp. This cat toys can be used for longer periods of time. It’s good cat gifts!\r\n\\n5. CONSIDERATIONS: The foam handle of the wand is originally designed for pet owner using it more comfortable, it has the advantages of being lightweight, comfortable to hold, and won\'t blister your hands. As this is an interactive cat toy, we kindly suggest supervise your cat all the time when playing this toy, in case they bite the string and handle. Keep it in a safe place pets can’t reach. Never leave your cat alone with this toy, because cats like to chew things like string and soft things.\r\n\\n-The clasp is easy to open for changing feathers.\r\n\\n-Also 2PCS extra durable strings with clasp for replacement or DIY.\r\n\\n-The cat wand is telescopic design, like a cat fishing pole toy.\r\n\\n-Retracted from 15in to 38.9in, Long enough to play.\r\n\\n-Pretty lightweight and flexible, comfortable to hold and durable.\r\n\\n-It\'s easy to store, and practical.\r\nMultiple attachments, EXCITING ENTERTAINMENT FOR CATS.\r\n\\n-This cat feather toy is an irresistible lure for cats!\r\n\\n-The fully extended cat wand plus string are long enough, which can cover a large space for playing. It can really get your cats exercise.\r\n\\nPackage includes:\r\n\\n2 Pcs Telescopic Cat Wand,5 Pcs Natural Feather Refills,4 Pcs Squiggly Worm Refills,2 Pcs Extra Strings with Clasp\r\n\\nSafetyInformation:\r\n\\nAs this is a interactive cat toy, we kindly suggest that supervise your cat when playing this toy all the time, in case they bite the toy. Keep it in a safe place that pets can’t reach it. Never leave your cat alone with this toy, because cats like to chew things like string and soft things.', 'Meohui', '68g', '6 months', '‎14.96 x 3.54 x 0.74 inches', '2021-10-12 06:36:14', '2021-10-10 07:56:21', 5, NULL),
(37, 'HOMEY PET INC 36\" Folding Wire Cat Ferret Habitat Crate with Casters,Tray and Hammock，Collapsible Large Cat Home Indoor on Wheels\r\n', 349.99, 10, 1, 'Description:\r\n\\nCat crate, fit for cat, kitten, ferret and small animal. Collapsible design make it easy to setup without any tools need. Four 360° rolling wheels with lock allow you put this cage in any place safely.\r\n\\n- Lockable casters render convenience for moving the cage.\r\n\\n- Pull out tray for easy cleaning.\r\n\\n- Foldable in box and easy set up without any tools needed.\r\n\\n- Plastic handles available for easy carry or move the cage around.\r\n', 'Homey Pet Station', '20.23kg', '2 years', '36.6 x 24 x 7.1 inches', '2021-10-12 06:36:48', '2021-10-10 07:56:21', 5, NULL),
(38, 'Advantage II Flea Prevention and Treatment', 23.99, 19, 1, 'Description:\r\n\\nAdvantage II topical flea treatment and prevention for large cats over 9 lbs is a veterinarian-recommended, monthly application that kills fleas through contact, so they don\'t have to bite your cat to die. The protection of Advantage II kills fleas in multiple life stages, including eggs, larvae and adults, effectively breaking the flea life cycle to control existing flea infestations on your cat and prevent further infestations. This 6-dose cat flea treatment comes in a convenient topical liquid that is easy to apply and fragrance free. A single application of Advantage II cat flea treatment for large cats starts working in 12 hours and keeps killing fleas for up to 30 days. Even indoor cats need flea protection because humans and other pets can bring fleas into your home. Advantage II is also available in a formula for dogs. Fight the misery of biting fleas with the help of Advantage II 6-month flea prevention and treatment for large cats.\r\n\\nSafety Information:\r\n\\nDo not get this product in your cat’s eyes, or allow your cat to ingest this product.\r\n\\nInstructions:\r\n\\n1. Use only on cats.\r\n\\n2. Hold applicator tube in an upright position. Pull cap off tube.\r\n\\n3. Turn the cap around and place other end of cap back on tube. Twist cap to break seal, then remove cap from tube.\r\n\\n4. Part the hair at the base of the cat’s skull until skin is visible.\r\n\\n5. Evenly apply the entire contents of the Advantage II tube directly on the skin by squeezing the entirety of the contents in that one spot.\r\n\\nIngredient:\r\n\\n9.1% Imidacloprid, 0.46% Pyripoxyfen', 'Advantage', '23g', '1 years', '6.5 x 1 x 4.25inches', '2021-10-12 06:37:05', '2021-10-10 07:56:21', 6, NULL),
(39, 'GoldenPaw Herbal Pet Supplement for Cat', 79.99, 6, 1, 'Description:\r\n\\nYour pet should try our product if the pet has: \r\n\\n- Respiratory problems of any nature: Kennel Cough, Runny Nose, Sneezing and Sinus     Congestion, Collapsed Trachea;\r\n\\n- Allergies of any etiology: seasonal allergies, food allergies;\r\n\\n- UTI, Kidney and Bladder problems, Urinary Incontinence;\r\n\\n- Gastrointestinal problems of any etiology; \r\n\\n- Lack of resistance of the body to harmful factors of the surrounding world and requires immune boosting.\r\n\\n-If you are tired of expensive antibioticsor other medications that harm your pet\'s digestive system, liver and kidneys - try the alternative given by nature! The composition of the 10 best natural ingredients allow us to cover all the organism systems as a whole. Action of the product is aimed at solving the problem: gently, quickly and efficiently.\r\n\\n-Сomplex problem solving due to the unique composition: Cranberry, Clove, Pau D’arco, Olive Leaf, Thyme, Oregano, Echinacea, Wormwood, Garlic, Eleutherococcus - Support, Protection, Improvement for your pet health! Best  natural herbal supplements in one bottle!\r\n\\nSafetyInformation:\r\n\\nFor pet use only. Monitor the condition of the pet before the first use. If the animal\'s condition worsens or does not improve, stop using the product and request medical attention. Do not use if safety seal is broken or missing. Do not use if the animal is pregnant or lactating. Store in a cool, dry place away from direct sunlight. For pets only. Not for human consumption. Keep away from children.\r\n\\nInstructions:\r\n\\nShake well before use. Can be given to pet directly by mouth or added into pet’s food or water. Dose as follows:\r\nPets under 10 pounds=1/2 dropper\r\n\\nIngredient:\r\n\\nPau D’arco, Olive Leaf, Thyme, Oregano, Echinacea, Wormwood, Garlic, Eleutherococcus. Other ingredients : Purified Water, Glycerin, Citric Acid, Potassium Sorbate.\r\n\\nInstructions:\r\n\\nShake well before use. Can be given to pet directly by mouth or added into pet’s food or water. Dose as follows:\r\n\\nPets under 10 pounds=1/2 dropper\r\n\\nPets 10-35 lbs= 1 1/4 dropper\r\n\\nPets 36+ lbs= 2 droppers\r\n\\nUse once a day for basic supplemental help. Use twice a day to ensure optimal effect.', 'GoldenPaw', '117g', '1 years', '4.8 x 3.82 x 1.73 inches', '2021-10-12 06:38:08', '2021-10-10 07:56:21', 6, NULL),
(40, 'L-Lysine Chews for Cats, Immune and Respiratory Support Supplement, 60 Bite Sized Chews (3.74oz)', 29.99, 16, 1, 'Description:\r\n\\nLysine is an essential amino acid for felines that must be ingested through food or supplements. L-Lysine for Cats supports respiratory health and immune system function while also building collagen for a healthy skin and coat. It also supports eye health in growing kittens and is recommended by veterinarians for conditions that are responsive to lysine. L-Lysine from Pet Natural’s comes in a delicious chicken liver bite sized chew that cats love!\r\n\\nSafety Information:\r\n\\nFor animal use only. Your pet may consider this a treat. In case of accidental overdose, contact a health professional immediately.\r\n\\nInstructions:\r\n\\nGive 1-2 Chews Daily\r\n\\nIngredient:\r\n\\nGrain-Free\r\n', 'Pet Naturals Of Vermont', '58g', '1 years', '‎5 x 3 x 7 inches', '2021-10-12 06:38:36', '2021-10-10 07:56:21', 6, NULL),
(41, 'Omega 3 Fish Oil for Cats - Better Than Salmon Oil for Cats - Kitten + Cat Vitamins and Supplements - Cat Health Supplies - Cat Dandruff Treatment - Liquid Fish Oil for Pets - Cat Shedding Products', 74.99, 1, 1, 'Description:\r\n\\n-Reduce Shedding + Improve Skin and Coat - Plano Paws Wild Caught Omega 3 for Cats is made with pure Anchovies, Herring, Mackerel, and Sardines from the clear ocean waters off the coast of Iceland.\r\n\\n-Low Odor, Safe + Effective - Our pet liquid fish oil is human grade and molecularly distilled to remove all harmful toxins and heavy metals to support joint health, skin, coat, heart, + immune system.\r\n\\n-For All Breeds and Ages - Our fish oil for cats liquid pump makes it easy to give your cat omega 3 oils they need to stay healthy and happy. Just squirt the fish oil onto your kitten or cats food.\r\n\\n-Sustainably Sourced - Our omega 3 fish oil cat supplement is all-natural and loaded with healthy DHA and EPA omega 3 for cats. Cat fish oil supplements may provide allergy and itch relief for cats.\r\n\\n-Our Mission - Plano Paws makes cat treats, cat health supplies and cat supplements you can trust. Plano Paws lives by 3 core principles. 1. Safe Ingredients. 2. Outstanding Effectiveness. 3. Exceptional Service.', 'Plano Paws', '272g', '1 years', '2 x 2 x 5 inches', '2021-10-12 06:38:55', '2021-10-10 07:56:21', 6, NULL),
(42, 'Pet Wellbeing - Kidney Support Gold for Cats - Natural Support for Feline Kidney Health - 2oz (59ml)', 19.99, 7, 1, 'Description:\r\n\\n-Supports immune system functionality against kidney issues in cats\r\n\\n-Promotes a natural increase in energy levels and general vitality\r\n\\n-Maintains a regular appetite and healthy weight\r\n\\n-Helps moderate normal hydration, urination, and thirst\r\n\\n-Prepared from organically grown and selectively imported herbs from trusted growers.\r\n\\nSafety Information:\r\n\\nSafe use in pregnant animals or animals intended for breeding has not been proven. If animal\'s condition worsens or does not improve, stop product administration and consult your veterinarian. An examination from a veterinarian is recommended prior to using this product. Do not use with blood thinners. Not to be used during diarrhea. For animal use only. Keep out of reach of children and animals. In case of accidental overdose, contact a health professional immediately.\r\n\\nInstructions:\r\n\\nUse as directed.\r\n\\nIngredient:\r\n\\nRehmannia root (Rehmannia glutinosa), Cordyceps mycelium (Cordyceps sinensis), Astragalus root (Astragalus membranaceous), Dong Quai root (Angelica sinesis)\r\n\r\n', 'Pet Wellbeing', '59g', '1 years', '3 x 1 x 1 inches', '2021-10-12 06:39:10', '2021-10-10 07:56:21', 6, NULL),
(43, 'F.M. Brown\'s Tropical Carnival Gourmet Hamster and Gerbil Food with Fruits, Veggies, Seeds, and Grains, Vitamin-Nutrient Fortified Daily Diet - 2lb', 14.99, 14, 1, 'Description:\\n\r\nBrown’s Tropical Carnival Gourmet Hamster and Gerbil Food with Fruits, Veggies, Seeds, and Grains is a vitamin-nutrient-fortified food and treat, all-in-one. This super premium gourmet food is specifically formulated for the daily dietary needs of your Hamster and Gerbil and is jam-packed with a medley of delicacies such as fruits, veggies, seeds and grains. Plus we\'ve added beneficial bacteria to aid in proper digestion. Your Hamster and Gerbil will find Tropical Carnival simply irresistible.\\n\r\nInstructions:\\n\r\nIt’s important to establish a consistent feeding and cleaning schedule for your pet. Keep food cups filled at all times and always supply fresh clean drinking water.\\n\r\nIngredient:\\n\r\nOats, White Proso Millet, Alfalfa Meal Dehydrated, Corn, Stripe Sunflower Seeds, Black Oil Sunflower Seeds, Safflower Seeds, Pineapple, Buckwheat, Banana, Wheat, Carrots, Lentils, Navy Beans, Sweet Potatoes, Feed Grade Tree Nuts, Pumpkin Seeds, Squash Seeds, Raisins, Cantaloupe Seeds, Green Peas, Canadian Peas, Red Watermelon Seeds, Semolina Flour, Oat Groats, Wheat Flour by-product less than 9.5-percent fiber, Maize Grain Ground, Dehulled Soybean Meal, Maize Gluten Meal, Soybean Oil, Calcium Carbonate, Dicalcium Phosphate, Beet Molasses Dried, Yeast Brewers Dehydrated, Salt, Whey Solids, Vitamin A Palmitate, Cholecalciferol (Source of Vitamin D3), Alpha Tocopherols (Source of Vitamin E), Ascorbic Acid (Source of Vitamin C), Thiamine Mononitrate, Menadione Sodium Bisulfite (Source of Vitamin K Activity), Biotin, Choline Chloride, Manganese Proteinate, Iron Proteinate, DL-Methionine, Zinc Proteinate, Sodium Selenite, Dried Bacillus Subtilis Fermentation Product, Dried Aspergillus Oryzae Fermentation Product, Dried Lactobacillus Acidophilus Product, Dried Lactobacillus Bulgaricus Fermentation Product, Dried Lactobacillus Lactis Fermentation Product, Lecithin, Natural Mixed Tocopherols (a preservative), Yucca Schidigera Extract, Rosemary Extract, Beta-Carotene, Titanium Dioxide, Banana Flavor and Artificial Colors Added.\r\n', 'Fm Browns', '907g', '7 days', '7.5 x 2.75 x 10.5 inches', '2021-10-12 06:50:57', '2021-10-11 01:01:45', 7, NULL),
(44, 'Kaytee Food from The Wild Hamster,', 39.99, 10, 1, 'Description:\\n\r\nIn the Wild, hamsters forage a complex range of nutrients from a variety of grains, seeds, nuts, flowers, fruits, and vegetables to support optimal health. \\n\r\nThe animal nutrition experts at Kaytee developed Food From the Wild blend for the forager in your family. Inspired by the ancestral feeding habits of hamsters, Food From the Wild blend is crafted with hand-selected Sunflower Seed, Peanut, Pumpkin Seed, Carrot, and Rose Petal to encourage the healthy foraging activity your hamster needs. Pelleted pieces offer comprehensive nutrition and contain natural probiotics to support digestive health. Food From the Wild blend contains nutritious and tasty ingredients to meet the unique dietary needs of your hamster and has no added sugar, fillers, or artificial preservatives. With more than 150 years of nutritional excellence, Kaytee is honored to be at the heart of your healthy, happy feeding routine.\\n\r\nInstructions:\\n\r\nStore in a dry, cool location.\\n\r\nIngredient:\\n\r\nSun-cured Timothy Grass Hay, Sunflower Seed, Rolled Oat Groats, Dehulled Soybean Meal, Sun-cured Alfalfa Meal, Wheat Middlings, Ground Wheat, Millet, Milo, Ground Corn, Shelled Peanuts, Soybean Hulls, Pumpkin Seed, Dehydrated Carrot, Dried Rose Petals, Puffed Barley, Puffed Wheat, Ground Oats, Fried Cane Molasses, Dicalcium Phosphate, Calcium Carbonate, Salt, Soybean Oil, DL-Methionine, L-Lysine, Vitamin A Supplement, Cholin Chloride, Mixed Tocopherols (preservative), Ferrous Sulfate, Riboflavin Supplement, Manganous Oxide, Zinc Oxide, Vitamin B12 Supplement, Vitamin E Supplement, L-Ascorbyl-2-Polyshosphate (Source of Vitamin C), Niacin, Yucca Schidigera Extract, Copper Sulfate, Menadione Sodium Bisulfate Complex (Source of Vitamin K activity), Rosemary Extract, Citric Acid, Cholecalciferol (Source of Vitamin D3), Calcium Pantothenate, Pryridoxine Hydrochloride, Thiamine Mononitrate, Folic Acid, Calcium Iodate, Biotin, Cobalt Carbonate, Sodium Selenite, Dried ASpergillus Oryzae Fermentation Extract, Dried Bacillus Licheniformis Fermentation Product, Dried Bacillus Subtillis Fermentation Product.\r\n', 'Central Garden & Pet', '907g', '7 days', '4 x 7 x 10.25 inches', '2021-10-12 06:51:12', '2021-10-11 01:01:45', 7, NULL);
INSERT INTO `products` (`productId`, `name`, `price`, `quantity`, `status`, `description`, `brand`, `weight`, `warrantyPeriod`, `productDimensions`, `createdAt`, `updatedAt`, `productCatId`, `staffId`) VALUES
(45, 'Kaytee Forti Diet Pro Health Hamster Food', 29.99, 15, 1, 'Kaytee Forti-Diet Pro Health Hamster and Gerbil food was developed by an animal nutritional expert to ensure you pet gets the proper nutrition. Forti Diet Pro Health contains probiotics and prebiotics to support digestive health. This food is rich in natural antioxidants for general health and immune support plus contains some larger, more crunchy pieces to support dental health through natural chewing activity. Kaytee understands that sharing your life with a small pet is not only enjoyable but very enriching.\r\nKaytee shows our love by ensuring we provide your small pet with the best nutrition for a long and healthy life. With over 150 years of nutritional experience, it\'s no wonder why Kaytee is at the heart of every healthy feeding routine\\n\r\nSafety Information:\\n\r\nAllergen information: Contains peanuts and/or other tree nuts.\\n\r\nInstructions:\\n\r\nA naturally preserved product needs special attention to maintain maximum freshness. After opening bag, remove air from package and reseal tightly. Use food within 30 - 45 days. Store in a cool, dry location. Refrigerate or freeze for extended storage.. When introducing a new food, begin with a mixture of \"old and new\" food, gradually increasing the amount of new food over a 7 to 10 day period. This will prevent digestive upsets as well as allowing your pet to adjust to something new. Adjust portions for proper weight maintenance and when feeding additional pets. Discard any uneaten food and clean dish before each feeding.\\n\r\nIngredient:\\n\r\nCorn, Wheat, Milo, Sunflower, Millet, Oat Groats, Sun-cured Alfalfa Meal, Dehulled Soybean Meal, Ground Corn, Toasted Corn Flakes, Shelled Peanuts, Toasted Wheat Flakes, Ground Flax Seed, Canadian Field Peas, Green Split Peas, Ground Oats, Ground Wheat, Ground Rice, Calcium Carbonate, Dicalcium Phosphate, Dried Cane Molasses, Salt, Soy Oil, Algae Meal (source of Omega-3 DHA), Fructooligosaccharide, DL-Methionine, L-Lysine, Yeast Extract, Yucca Schidigera Extract, Vitamin A Supplement, Choline Chloride, Mixed Tocopherols (a preservative), Ferrous Sulfate, Manganous Oxide, Riboflavin Supplement, Zinc Oxide, Vitamin B12 Supplement, Vitamin E Supplement, Niacin, Menadione Sodium Bisulfite Complex (source of vitamin K activity), Rosemary Extract, Citric Acid, Cholecalciferol (source of vitamin D3), Copper Sulfate, Calcium Pantothenate, Pyridoxine Hydrochloride, Thiamine Mononitrate, Calcium Iodate, Biotin, Folic Acid, Dried Bacillus licheniformis Fermentation Product, Dried Bacillus subtilis Fermentation Product, Cobalt Carbonate, Sodium Selenite, Artificial Color.', 'Central Garden & Pet ', '1.36kg', '7 days', '3.5 x 7 x 8 inches', '2021-10-12 06:54:39', '2021-10-11 01:01:45', 7, NULL),
(46, 'Oxbow Essentials Hamster Food and Gerbil Food - All Natural Hamster and Gerbil Food', 24.99, 7, 1, 'Description:\\n\r\nAt Oxbow Animal Health, our purpose is to help people and pets live happy, healthy lives. For more than 30 years, we’ve partnered with leading veterinarians and nutritionists to develop nutrition and care products that meet the specific species and life stage needs of rabbits, guinea pigs, chinchillas, hamsters, gerbils, rats, and mice. From farm fresh hays and nourishing fortified foods to wholesome treats, beneficial supplements, enrichment and care, Oxbow products are used and recommended by leading veterinary professionals and passionate pet parents worldwide. Oxbow’s Essentials - Hamster & Gerbil Food is formulated with the guidance of top exotics veterinarians to meet your pet hamster or gerbil’s unique nutritional needs. We combine hand-selected Timothy Hay with wholesome barley and oats to provide vital nutrients that support daily function and performance in hamsters and gerbils. FEEDING INSTRUCTIONS: Young (under six months) or Pregnant / Nursing Small Hamster or Gerbil/Large Hamster: Unlimited Adult (over six months) Small Hamster: 1/8 cup Adult (over six months) Gerbil/Large Hamster: 1/3 cup. While hamsters and gerbils don’t require hay as a staple in their diet, be sure to offer them free choice hay to burrow and hide in. Please note that these are guidelines.\\n\r\nInstructions\\n\r\nUse as directed.\\n\r\nIngredient:\\n\r\nTimothy Meal, Pearled Barley (Rolled), Oat Groats, Canola Meal, Millet, Canola Oil, Wheat Gluten, Calcium Carbonate, Salt, Brewer\'s Dried Yeast, Sodium Bentonite, Hydrolyzed Yeast, Mixed Tocopherols (preservative), Citric Acid, Soy Oil, Choline Chloride, Vitamin E Supplement, Zinc Sulfate , Zinc Proteinate, Niacin, Copper Sulfate, d-Calcium Pantothenate, Manganous Oxide, Riboflavin Supplement, Biotin, Thiamine Mononitrate, Magnesium Sulfate, Copper Proteinate, Vitamin A Supplement, Sodium Selenite, Manganese Proteinate, Pyridoxine Hydrochloride, Folic Acid, Vitamin D3 Supplement, Cobalt Carbonate, Vitamin B12 Supplement, Calcium Iodate, Rosemary Extract', 'Oxbow Animal Health LLC', '454g', '7 days', '12 x 2.9 x 7 inches', '2021-10-12 06:54:53', '2021-10-11 01:01:45', 7, NULL),
(47, 'Vitakraft Hamster Treat Stick - Apple And Honey', 8.99, 8, 1, 'Description:\\n\r\nTasty Apple And Honey Treat Sticks Your Hamsters Will Love\\n\r\nTriple Baked For Crunchiness And Great Taste\\n\r\nNatural Wood Stick Center Provides Your Bird With Long Lasting Chewing Fun\\n\r\nVitamin Fortified Containing Only Top Quality Ingredients Such As Specially Selected Seeds Plus Vitamins And Minerals\\n\r\nKeep Pets Mentally And Physically Stimulated To Prevent Boredom.\\n\r\nInstructions:\\n\r\nUse as directed on packaging.\\n\r\nIngredient:\\n\r\nWheat\\n', 'Vitakraft Sun Seed', '28g', '7 days', '3.25 x 1.5 x 9.5 inches\r\n', '2021-10-12 06:55:03', '2021-10-11 01:01:45', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderItemId` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` varchar(255) DEFAULT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewId`, `userId`, `orderItemId`, `rating`, `feedback`, `createdAt`) VALUES
(6, 7, 19, 5, 'Arrived on time. 10/10 will deal again.', '2021-11-14 00:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL,
  `mobileNumber` int(11) NOT NULL,
  `addressLine` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `userState` varchar(30) NOT NULL,
  `postcode` int(5) NOT NULL,
  `imagePath` varchar(255) NOT NULL,
  `userRole` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `firstName`, `lastName`, `email`, `userPassword`, `mobileNumber`, `addressLine`, `city`, `userState`, `postcode`, `imagePath`, `userRole`) VALUES
(6, 'Robert', 'Dawn', 'robert@yahoo.com', '$2y$10$aikFX7NWmy0rhrwaR1eAEOO2hw7F7QzU9jLsoMgJaOtdKZKWoZrwi', 123456789, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(7, 'Ryan', 'Higa', 'mbladge0@oaic.gov.au', '$2y$10$.H2kvlQGMIg6LA/vf248KeCE3QMlhgmrN3kn4YEQTAOxFwX/xr4.C', 160452661, '', '', 'Sarawak', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(8, 'Lise', 'Offord', 'lofford1@usgs.gov', '$2y$10$RykFhnwjm2F62gfQMMSaeu8XPjdNSzKzNsarwLcHnw.Lo2avnNToS', 174588990, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(9, 'Aviva', 'Stackbridge', 'astackbridge2@livejournal.com', '$2y$10$RPxPdOLO.8YeERywSpF44ustITJ6ybv4UmUb91nqt1UbmOKIboyNe', 181544288, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(10, 'Wilton', 'Wilkie', 'wwilkie3@cisco.com', '$2y$10$g6iXZ531i0uBM.NIoA51eO4zgFIdmViYBGIfWwCf4T2nJuYFXXYUe', 132517496, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(11, 'Annalise', 'Lynn', 'alynn4@irs.gov', '$2y$10$oOh3rzJIEgil6ic47VXAV.XXqsVLRkdBTymL3zo3EDW/r0f1.N33C', 182668140, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(12, 'Bogart', 'Noriega', 'bnoriega5@qq.com', '$2y$10$R6CA5miROGIM.NpWIr95be/BaYZiXa1er59bUgy8kkY0WC1fl9NxO', 198269536, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(13, 'Gottfried', 'Whall', 'gwhall6@nature.com', '$2y$10$IlkXByrqQIJkGepYR8M0W.aIL5Gl8RVEqfogOCIy8CLBFs1ePqrTy', 116074638, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(14, 'Angel', 'Costa', 'acosta7@themeforest.net', '$2y$10$XkEWDFHzhzJuWui4XOvSD.4hsjUCkgSiZd/MllIP1TJjN/sIwHwDO', 118219987, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(15, 'Arlana', 'Housego', 'ahousego8@webeden.co.uk', '$2y$10$a5vox4E10Asan0ylNQZVguphYypHfgNJke.t/xTlv5XtQ5qWehmIK', 110715590, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(16, 'Abigael', 'Sorrill', 'asorrill9@wix.com', '$2y$10$SK.Wrh1v1w6ocMzBN/JOpuVmM69XgbAF6CuCq6U34tq7Li7gqVPdK', 153021732, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(17, 'Reade', 'Vawton', 'rvawtona@house.gov', '$2y$10$fKaQQ8BAVKygbAsGdHbii.ZVUEWJDlBK3R5dPiL2zHPU85h/zRPmO', 137079326, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(18, 'Tomaso', 'Scoular', 'tscoularb@mail.ru', '$2y$10$W/WGaS8lCEnsmXTFCjKrHOLp3zq5seW6.4BYsrwu/a55L2Fsq.poG', 167434759, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(19, 'Dorolice', 'Sauvage', 'dsauvagec@digg.com', '$2y$10$K/U4Z5Ta3eNgO6NfIGwY8OCGFfgM22n1WE4d/9XKcqWgPv8rsiIGq', 183646568, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(20, 'Mehetabel', 'Oller', 'mollerd@rakuten.co.jp', '$2y$10$6ORYM6zt9QLQCP2vVXmbve0JY8N4fCOWA2fvRz5ZmHgI6wGQ3.PZ6', 113876474, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(21, 'Harri', 'Blasius', 'hblasiuse@sourceforge.net', '$2y$10$40PvHc4UWq/vVF2FLOtcNOr3j0azLHsPBdH6S.hVNvjvhXqMh.HRG', 177490552, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(22, 'Colline', 'Cherrie', 'ccherrief@unicef.org', '$2y$10$uT81EqCMKI/gPUcf.McZ7.UUHkY.cbKGiexxK4TjVdkvxJ83aqJJC', 117641107, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(23, 'Rikki', 'Chrystie', 'rchrystieg@w3.org', '$2y$10$DG.W1TtvjV/owvvnrc7SAOfGTr7WYQwILKEQzi9gEkPfU7GEZrTPK', 126683905, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(24, 'Raimundo', 'Hancorn', 'rhancornh@instagram.com', '$2y$10$Jra6TIr52sYiVz1883Twqea7tnJnXSZOHZ0V5MsBJXS5Q5vWT6PN.', 163325667, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(25, 'Shayla', 'De Fries', 'sdefriesi@instagram.com', '$2y$10$2/u0CjRX/ZztUaGnIs7M/ONlDT6otXHsb7NjMCYeEL88Fzh8sBWlK', 176253389, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(26, 'Nevil', 'Ganforthe', 'nganforthej@netlog.com', '$2y$10$ZiqurMJKwocaApEidUmFLOiU8av7Krn0BuGEZiR.y0MfAph3PJM/G', 117409117, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(27, 'Serena', 'Haruard', 'sharuardk@mlb.com', '$2y$10$Ts02XhjgUztqumXDYXMWyehubBCjOWZU3odQoT5zAppuN2Lzs5Tq6', 193321385, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(28, 'Arabella', 'Ockleshaw', 'aockleshawl@forbes.com', '$2y$10$2a04q5hB/h3FQiLE5/s9rO2k0Dts3rlFnW1.fJqt81OHQPZWjQzhy', 123670483, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(29, 'Nicol', 'Dugood', 'ndugoodm@ocn.ne.jp', '$2y$10$zwsScHYUplsyQH9bawhdB.48AUpCE023nrPUsC8JgI63DP/H6iXy.', 180561772, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(30, 'Desirae', 'OFairy', 'dofairyn@1688.com', '$2y$10$VuBMJ/IW2sVi4w6e5XBMOe7k/i26syMAATY/NdbhFAy7zFfwQfGL.', 173815139, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(31, 'Hannah', 'Mont', 'hmonto@google.co.uk', '$2y$10$XbZNGIepmOY/v/pvIQBJpOdtAOXrzPp96/TNtUMmYoQjPeVkHFR72', 177172850, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(32, 'Peta', 'Roadknight', 'proadknightp@ebay.co.uk', '$2y$10$SuQOODwd1dPcEsqepe0m0.SCLZGf6HiYsvEiz3eNx5Yrtt4ivM0/O', 136754596, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(33, 'Elizabet', 'Kirwood', 'ekirwoodq@omniture.com', '$2y$10$fZ6XLmXPxenWAcFzu9Q7vOIfJ51qBNX94jME1/37Lt9RyCN2zBXP6', 185639350, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(34, 'Boot', 'Tukely', 'btukelyr@msu.edu', '$2y$10$rno6O.z4gWns32K0FKimC.iisUR2Dw0eG78eriqnhHJGycM7vOmSG', 184635755, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(35, 'Allsun', 'Sympson', 'asympsons@macromedia.com', '$2y$10$CWfQzkB8VpuxFr11lGRnqOoLL7diJkgNH.q73qCGuJLZ0ATo6UfCW', 161019697, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(36, 'Arda', 'Messent', 'amessentt@elpais.com', '$2y$10$ZcRfxrW9e6TBwX8UNQwUSeFTGlTBNbRbKBm6zncYW4fPMH.aLu7e2', 199778533, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(37, 'Gun', 'Cockerton', 'gcockertonu@theguardian.com', '$2y$10$Ijx3gu8aIxuTup093cwUSunCA3mSkLZOgAalGSADkCfhEUCehZV5q', 118625704, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(38, 'Silva', 'Bygate', 'sbygatev@auda.org.au', '$2y$10$dHVfqIpXSJioZHtt/1jbj.iI19eGX5mx88GjTxd/MjhPswWFGaBN2', 116362178, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(39, 'Harcourt', 'Rickeard', 'hrickeardw@vimeo.com', '$2y$10$JTr4nEveEyzj9kus/KsBEeJhbpUx1I.fYWP3ZCMxNCsUmsHKq5bbK', 123387092, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(40, 'Kale', 'Dallow', 'kdallowx@irs.gov', '$2y$10$rqMXcX8SxfaVIIy.WtjEb.vYqJ426QmR716bAFRm/.zzwvwWsiEIq', 190216044, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(41, 'Florance', 'Pearcey', 'fpearceyy@mayoclinic.com', '$2y$10$QAS6UZbAr.zR9MWytR0XWeE2JmhuCq0HYvKQ8L4j6tuui5.NYuGFu', 127604214, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(42, 'Billye', 'Linnane', 'blinnanez@linkedin.com', '$2y$10$stqDylCGYk7NB09GBnewMO785OS3ENWRWTCEWra2gs2yve794tH8C', 146223535, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(43, 'Ted', 'Drieu', 'tdrieu10@reddit.com', '$2y$10$4HvO2L.SF98PHHQcvCCABOadKRDJPyTMg9IdFVpVm4WOu3evqpnGS', 165121485, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(44, 'Rivi', 'Alvarado', 'ralvarado11@xinhuanet.com', '$2y$10$a.yiIFWeJgsCtd2dnq.8ouqRNZN5ec5sbT3uMFsmBgIZyBKEu5THq', 117231034, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(45, 'Chucho', 'Garry', 'cgarry12@freewebs.com', '$2y$10$CMgdJ90l9BbR5C2E.iy.V.zulF5cAex9aot7PJ8lLwSuz2MRdWrdu', 182977424, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(46, 'Maddie', 'Polsin', 'mpolsin13@nyu.edu', '$2y$10$IG6.dJFousyyJTzPHhKWpOuM.MMMMIyeRU0n3nJvRjuDk27cmkVmS', 160795577, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(47, 'Cinderella', 'Glackin', 'cglackin14@nps.gov', '$2y$10$qn0tdXuYCJIt1EV5gLLApO5Dkaq8OAO7X4MFs1FTWt1qL5UR2wGIe', 178565390, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(48, 'Hollie', 'Wellbank', 'hwellbank15@dot.gov', '$2y$10$T7bd7oJVKqvF.rTALGwEYeNlvKKqsxHiAl4XI0EPtFWPsZuqfbVwy', 195518218, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(49, 'Ginni', 'Wyldish', 'gwyldish16@unicef.org', '$2y$10$dGWzARMfowaAN5Q1ZG3cg.x/ad6uuyc0bP1F6BD8/fvQ15Br1BxkS', 151445895, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(50, 'Elnora', 'Muzzillo', 'emuzzillo17@vimeo.com', '$2y$10$ia2rb3Cu9iAjvCokbVMgzeKSlLmlvA0Xl1Y45.j84zereUXtv1eC2', 139471391, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(51, 'Alyson', 'OKelly', 'aokelly18@163.com', '$2y$10$eGV8XVb8dk8/1wtjcup47OpYzlOTyo0hXLDMBDiRhuWeN7TrJTESm', 133964958, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(52, 'Iseabal', 'Phillipson', 'iphillipson19@1und1.de', '$2y$10$98A/lHBjjCvgyCYGfI/Tl.yxsWRpO84BkfoTMO5DLyNqyqiaTDeOq', 181247735, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(53, 'Garrek', 'Varfolomeev', 'gvarfolomeev1a@wisc.edu', '$2y$10$Q0ZqUvsuYUUiWbgbsuHzEexa9SCqMnm/0gkndDiCcaacBd4DFQ.F6', 196403048, '', '', '', 0, './svg/profile-pic-default.svg', 'CUSTOMER'),
(54, 'Kip', 'Fawson', 'kfawson1b@digg.com', '$2y$10$C6z350j9Jc8GYgtN992UfOml6P0q/ipx7wb9DdAfnZqufrTiwXSEO', 174946498, '', '', '', 0, './svg/profile-pic-default.svg', 'STAFF'),
(55, 'Arri', 'Garric', 'agarric1c@spiegel.de', '$2y$10$4yK0pIMR9kIAHlFtSBmOHeD8twhD6h388QgY0evGqJfcB16DPR4zO', 148887395, '', '', '', 55555, './svg/profile-pic-default.svg', 'STAFF'),
(56, 'Winslow', 'Sheers', 'wsheers1d@themeforest.net', '$2y$10$mTEd4eXC9BIcIpvZMllZLuh3Sge3tWCs4BycbpXKs5bnJPGRDh9mu', 161087194, '', '', '', 0, './svg/profile-pic-default.svg', 'STAFF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `userid` (`userId`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`cartItemId`),
  ADD KEY `cartId` (`cartId`),
  ADD KEY `petId` (`petId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`orderItemId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `petId` (`petId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `petcategory`
--
ALTER TABLE `petcategory`
  ADD PRIMARY KEY (`petCatId`);

--
-- Indexes for table `petimage`
--
ALTER TABLE `petimage`
  ADD PRIMARY KEY (`petImageId`),
  ADD KEY `petId` (`petId`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`petId`),
  ADD KEY `petCatId` (`petCatId`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`productCatId`);

--
-- Indexes for table `productimage`
--
ALTER TABLE `productimage`
  ADD PRIMARY KEY (`productImageId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `productCatId` (`productCatId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `orderItemId` (`orderItemId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cartitem`
--
ALTER TABLE `cartitem`
  MODIFY `cartItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `orderitem`
--
ALTER TABLE `orderitem`
  MODIFY `orderItemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `petcategory`
--
ALTER TABLE `petcategory`
  MODIFY `petCatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `petimage`
--
ALTER TABLE `petimage`
  MODIFY `petImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `petId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `productcategory`
--
ALTER TABLE `productcategory`
  MODIFY `productCatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `productimage`
--
ALTER TABLE `productimage`
  MODIFY `productImageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`cartId`) REFERENCES `cart` (`cartId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`petId`) REFERENCES `pets` (`petId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartitem_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`petId`) REFERENCES `pets` (`petId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `petimage`
--
ALTER TABLE `petimage`
  ADD CONSTRAINT `petimage_ibfk_1` FOREIGN KEY (`petId`) REFERENCES `pets` (`petId`);

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`petCatId`) REFERENCES `petcategory` (`petCatId`) ON DELETE CASCADE;

--
-- Constraints for table `productimage`
--
ALTER TABLE `productimage`
  ADD CONSTRAINT `productimage_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`productCatId`) REFERENCES `productcategory` (`productCatId`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE NO ACTION,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`orderItemId`) REFERENCES `orderitem` (`orderItemId`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
