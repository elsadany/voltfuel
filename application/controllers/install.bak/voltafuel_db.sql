-- VoltaFuel DB
-- version 1.0.0
-- https://voltafuel.site
-- Tables added: 1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` int(11) NOT NULL,
  `outlet_name` varchar(100) NOT NULL,
  `geo_cordinates` varchar(100) NULL,
  `googlemaps_link` varchar(100) NULL,
  `operation_mode` varchar(100) DEFAULT NULL,
  `operation_time` varchar(100) DEFAULT NULL,
  `weekdays` varchar(100) DEFAULT NULL,
  `support` varchar(100) DEFAULT NULL,
  `batteries` int(11) DEFAULT NULL,
  `rentalcost` float(10,3) DEFAULT NULL,
  `address` text,
  `city` varchar(10) DEFAULT NULL,
  `province` varchar(10) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `image1` varchar(10) DEFAULT NULL,
  `image2` varchar(10) DEFAULT NULL,
  `image3` varchar(10) DEFAULT NULL,
  `image4` varchar(10) DEFAULT NULL,
  `available` varchar(10) DEFAULT 'yes',
  `is_active` varchar(255) DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `outlets`
--

ALTER TABLE `outlets` ADD PRIMARY KEY(`id`);
ALTER TABLE `outlets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--


CREATE TABLE `installs` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `device_id` varchar(100) NOT NULL,
  `device_platform` varchar(100) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` date DEFAULT NULL,
  `users` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--


CREATE TABLE `stations` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `station_id` varchar(100) NOT NULL,
  `station_type` varchar(100) NULL,
  `batteries` INT(2) NOT NULL,
  `batteries_status` JSON NULL,
  `qr_code` VARCHAR(100) NOT NULL,
  `outlet_id` int(10) NOT NULL,
  `is_active` varchar(255) DEFAULT 'yes',
  `is_online` varchar(255) DEFAULT 'no',
  `equipment_make` VARCHAR(100) NOT NULL,
  `purchasedate` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;