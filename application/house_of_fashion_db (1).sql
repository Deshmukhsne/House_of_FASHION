-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 07:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `house_of_fashion_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(20) NOT NULL,
  `username` varchar(155) NOT NULL,
  `password` varchar(155) NOT NULL,
  `role` enum('Admin','Staff','Accountant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$Gnx/xDKm6UHfgl.ARocS1.jDWJN/QQBK.Knxzl7x7oZ2WMVxhgDLu', 'Admin'),
(2, 'chaitali', '$2y$10$7V2vznEsegHNMU4Vt6KL..fxQEaiylIVipxAoHA1ljQfmz6Pgi/qS', 'Admin'),
(3, 'nikita', '$2y$10$AXesPlzZiFOiEIZRmR7Ok.hvE7Mo3qNYYkSG/xMVQYadeEA0f7am.', 'Accountant');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Saree'),
(3, 'Party Dress'),
(4, 'Lehenga'),
(6, 'Blouse'),
(7, 'Ring'),
(8, 'Necklace'),
(9, 'Earrings'),
(11, 'Channia Choli'),
(12, 'Patal'),
(16, 'Wedding Jewellery set'),
(17, 'HeadGears');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `id_proof_type` varchar(50) NOT NULL,
  `id_proof_file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `id_proof` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `contact`, `id_proof_type`, `id_proof_file`, `created_at`, `id_proof`) VALUES
(1, 'Nikita', '647364743', 'Aadhar', 'bg2.png', '2025-07-24 15:50:20', NULL),
(2, 'Chaitali', '7709671206', '12', '4tvm4j', '2025-07-28 12:03:07', 'r23r');

-- --------------------------------------------------------

--
-- Table structure for table `drycleaning_status`
--

CREATE TABLE `drycleaning_status` (
  `id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `vendor_mobile` varchar(15) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_status` varchar(50) DEFAULT NULL,
  `forward_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Forwarded','In Cleaning','Returned') DEFAULT 'Forwarded',
  `expected_return` date DEFAULT NULL,
  `cleaning_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drycleaning_status`
--

INSERT INTO `drycleaning_status` (`id`, `vendor_name`, `vendor_mobile`, `product_name`, `product_status`, `forward_date`, `return_date`, `status`, `expected_return`, `cleaning_notes`, `created_at`, `updated_at`) VALUES
(15, 'shubham', '9785663421', '', 'Forwarded', '2025-08-14', '2025-08-17', 'Forwarded', '2025-08-16', 'fhjkl;kgfnvbhn', '2025-08-19 05:13:49', '2025-08-19 05:13:49'),
(16, 'vijay sharma', '6587844889890', '', 'Forwarded', '2025-08-19', '2025-08-22', 'Forwarded', '2025-08-21', 'fghjiuihuuhuh', '2025-08-19 08:00:18', '2025-08-19 08:00:18'),
(17, 'rhea', '7896541236', 'Banarsi Saree', '', '2025-08-21', NULL, 'Forwarded', '2025-08-28', 'clean good', '2025-08-23 04:52:22', '2025-08-23 09:00:37'),
(18, 'Abhi', '', 'Banarsi Saree', 'Forwarded', '2025-08-23', NULL, 'Forwarded', '2025-08-24', 'hii', '2025-08-23 05:34:26', '2025-08-23 05:34:26'),
(19, '11', '7896541236', 'Banarsi Saree', 'Forwarded', '2025-08-21', NULL, 'Forwarded', '2025-08-27', '7895', '2025-08-23 05:48:51', '2025-08-23 05:48:51'),
(20, '11', '7896541236', 'Banarsi Saree', 'Forwarded', '2025-08-21', '2025-08-28', 'Forwarded', NULL, '7895', '2025-08-23 05:51:16', '2025-08-23 05:51:16'),
(21, '11', '7896541236', 'Banarsi Saree', 'In Cleaning', '2025-08-22', '2025-08-27', 'Forwarded', NULL, '565', '2025-08-23 06:08:32', '2025-08-23 06:08:32'),
(22, 'Anu', '7895642121', 'Banarsi Saree', 'In Cleaning', '2025-08-22', '2025-08-26', 'Forwarded', NULL, 'gktyhmky', '2025-08-23 06:17:18', '2025-08-23 06:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `return_date` date NOT NULL,
  `deposit_amount` decimal(10,2) DEFAULT 0.00,
  `discount_amount` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `total_payable` decimal(10,2) DEFAULT 0.00,
  `paid_amount` decimal(10,2) DEFAULT 0.00,
  `due_amount` decimal(10,2) DEFAULT 0.00,
  `payment_mode` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `customer_name`, `customer_mobile`, `invoice_date`, `return_date`, `deposit_amount`, `discount_amount`, `total_amount`, `total_payable`, `paid_amount`, `due_amount`, `payment_mode`, `created_at`) VALUES
(1, 'BILL-TEMP-20250824-D215', 'Sarika', '7894562135', '2025-08-24', '2025-08-26', '100.00', '0.00', '2000.00', '2000.00', '400.00', '1600.00', 'Cash', '2025-08-24 12:59:51'),
(2, 'BILL-TEMP-20250824-DED0', 'Nikita', '546451210', '2025-08-22', '2025-08-27', '300.00', '0.00', '2250.00', '2250.00', '2000.00', '250.00', 'Online', '2025-08-24 13:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `category` int(11) DEFAULT NULL,
  `item_name` varchar(100) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total` decimal(10,2) NOT NULL,
  `times_rented` int(10) NOT NULL,
  `status` enum('Rented','Drycleaning','Returned') NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `category`, `item_name`, `product_id`, `price`, `quantity`, `total`, `times_rented`, `status`, `category_name`) VALUES
(1, 1, 3, 'Red Gaun', NULL, '1000.00', 1, '2000.00', 1, 'Returned', 'Party Dress'),
(2, 2, 7, 'Diamond Ring', NULL, '450.00', 1, '2250.00', 1, 'Returned', 'Ring');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_signatures`
--

CREATE TABLE `invoice_signatures` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `signature_image` longblob NOT NULL,
  `document_hash` varchar(255) NOT NULL,
  `signed_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `invoice_id`, `invoice_no`, `customer_name`, `customer_mobile`, `invoice_date`, `return_date`, `item_name`, `category`, `price`, `quantity`, `total`, `status`, `product_image`, `created_at`) VALUES
(1, 8, 'BILL83064423', 'Sayali', '7564598653', '2025-08-15', '0000-00-00', 'Red Lehengas', 'Pre-wedding dress', '20000.00', 1, '20000.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(2, 8, 'BILL83064423', 'Sayali', '7564598653', '2025-08-15', '0000-00-00', 'Tear Drops', 'earring', '100.00', 1, '100.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(3, 8, 'BILL83064423', 'Sayali', '7564598653', '2025-08-15', '0000-00-00', 'Diamond Necklace', 'necklace', '200.00', 1, '200.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(4, 9, 'BILL922BB5EF', 'Sakshi', '2386992777', '2025-08-14', '0000-00-00', 'Diamond Necklace', 'necklace', '200.00', 3, '600.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(5, 9, 'BILL922BB5EF', 'Sakshi', '2386992777', '2025-08-14', '0000-00-00', 'Tear Drops', 'earring', '100.00', 1, '100.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(6, 10, 'BILL10111BAEE', 'Chaitali', '7894561234', '2025-08-19', '0000-00-00', 'Banarsi Saree', 'saree', '100.00', 2, '1600.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(7, 11, 'BILL11194E7FA', 'sakshi', '7894561234', '2025-08-16', '0000-00-00', 'Banarsi Saree', 'saree', '100.00', 2, '2400.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(8, 12, 'BILL121472799', 'nikita', '7889675645', '2025-08-16', '0000-00-00', 'Diamond Necklace', 'necklace', '200.00', 1, '400.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(9, 13, 'BILL132B490E6', 'Snehal', '7895641235', '2025-08-18', '0000-00-00', 'Diamond Necklace', 'necklace', '200.00', 2, '800.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(10, 13, 'BILL132B490E6', 'Snehal', '7895641235', '2025-08-18', '0000-00-00', 'Banarsi Saree', 'saree', '100.00', 3, '600.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(11, 14, 'BILL141E52524', 'Snehal', '7895641235', '2025-08-18', '0000-00-00', 'Banarsi Saree', 'saree', '100.00', 1, '100.00', 'Rented', NULL, '2025-08-19 08:48:52'),
(12, 16, '', 'Raju Kaju', '7894561234', '2025-08-19', '2025-08-21', 'Banarsi Saree', 'saree', '100.00', 1, '200.00', 'Issued', NULL, '2025-08-19 11:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `main_category` enum('Cloths','Accessories') NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(10) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `main_category`, `stock`, `price`, `status`, `image`) VALUES
(1, 'Banarsi Saree', 1, 'Cloths', 0, 100, 'Available', 0x75706c6f6164732f61336135613365653561653364393838316431336537396664303837343132372e706e67),
(2, 'Diamond Necklace', 8, 'Accessories', 0, 200, 'Available', 0x75706c6f6164732f34633234376565356135396236313733303431626263613430313230313830632e6a7067),
(7, 'Diamond Ring', 7, 'Accessories', 0, 450, 'Available', 0x75706c6f6164732f66643131316130393333306138636539636132366363653736353735363432372e706e67),
(8, 'Wedding Jewellery', 16, 'Accessories', 1, 400, 'Available', 0x75706c6f6164732f38373530613337356638303239386539313233653536326265373538353034362e6a706567),
(9, 'Wedding Lehenga', 4, 'Cloths', 0, 5000, 'Available', 0x75706c6f6164732f31353538616262643966393634316631663732306434613633663366653863392e706e67),
(10, 'Feta', 17, 'Cloths', 1, 200, 'Available', 0x75706c6f6164732f30333862386662363731393031386164366361666466386363383662393533652e706e67),
(12, 'Red Gaun', 3, 'Cloths', 0, 1000, 'Available', 0x75706c6f6164732f37646666313963396330363762666333356162383336616263313065626236612e706e67),
(13, 'Blue Silk Saree', 1, 'Cloths', 0, 800, 'Available', 0x75706c6f6164732f36316333373061303366636636656634373234663935616530643736613062632e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `name` varchar(155) NOT NULL,
  `email` varchar(155) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `role` enum('Staff','Accountant') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `joining_date`, `role`, `username`, `password`) VALUES
(1, 'Neha', 'neha12@gmail.com', '7709671206', 'Pune', '2025-07-09', 'Staff', 'neha', '0'),
(5, 'Sanika', 'sanika@gmail.com', '9765231205', 'Mumbai', '2025-07-01', 'Accountant', 'sanika', '$2y$10$O71ERWKOk2AM8WEZCoKB.Oxd7JJVJzLARDnmVi48q7M'),
(6, 'Gayatri', 'gayatri@gmail.com', '9856452147', 'Nashik', '2025-07-17', 'Staff', 'gayatri', '$2y$10$YVodPKdsGq5ltNdaHEC2eucOBU8tai51M6YxcGyxBDb');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `company` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `name`, `email`, `mobile`, `company`, `address`, `created_at`) VALUES
(4, 'Snehal', 'shehal@gmail.com', '7896541236', 'SnehalBusinesses', 'Nashik', '2025-08-22 11:35:04'),
(11, 'Abhi', 'abhi@gmail.com', '7896541236', 'AbhiBsinesses', 'Mumbai', '2025-08-22 17:10:51'),
(12, 'Anu', 'anu@gmail.com', '7895642121', 'AnuBsinesses', 'Mumbai', '2025-08-23 09:46:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drycleaning_status`
--
ALTER TABLE `drycleaning_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `invoice_signatures`
--
ALTER TABLE `invoice_signatures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drycleaning_status`
--
ALTER TABLE `drycleaning_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoice_signatures`
--
ALTER TABLE `invoice_signatures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_signatures`
--
ALTER TABLE `invoice_signatures`
  ADD CONSTRAINT `invoice_signatures_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
