-- Hotels.com Clone Database SQL Export
-- Database: rsoa_rsoa278_4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Guest User', 'guest@example.com', '654321#', '2026-02-03 09:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE IF NOT EXISTS `hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL,
  `price_usd` decimal(10,2) NOT NULL,
  `price_aed` decimal(10,2) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `reviews_count` int(11) DEFAULT 0,
  `hotel_type` enum('Luxury','Resort','Budget','Boutique') DEFAULT 'Luxury',
  `amenities` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `location`, `description`, `main_image`, `price_usd`, `price_aed`, `rating`, `reviews_count`, `hotel_type`, `amenities`) VALUES
(1, 'Atlantis The Royal', 'Palm Jumeirah, Dubai', 'Experience the height of luxury at the iconic Atlantis The Royal. Featuring stunning views of the Arabian Sea and world-class amenities.', 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80', 1200.00, 4400.00, 4.9, 1240, 'Luxury', 'WiFi, Pool, Spa, Breakfast, Gym, Parking'),
(2, 'Burj Al Arab Jumeirah', 'Umm Suqeim, Dubai', 'The world\'s only 7-star hotel, offering unparalleled luxury and exceptional service in an architectural masterpiece.', 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80', 2500.00, 9182.00, 5.0, 850, 'Luxury', 'WiFi, Infinity Pool, Private Beach, Spa, Breakfast'),
(3, 'Bab Al Shams Desert Resort', 'Al Qudra Road, Dubai', 'A rare jewel that brings together traditional Arabic architecture and modern luxury in the heart of the desert.', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80', 450.00, 1650.00, 4.7, 2100, 'Resort', 'WiFi, Desert Safari, Pool, Spa, Breakfast'),
(4, 'Address Sky View', 'Downtown Dubai', 'Stunning views of the Burj Khalifa and the Dubai Fountains from the heart of Downtown Dubai.', 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80', 600.00, 2200.00, 4.8, 3400, 'Luxury', 'WiFi, Pool, Sky Deck, Gym, Breakfast'),
(5, 'Rove Downtown', 'Downtown Dubai', 'Modern, quirky, and affordable stay for urban explorers in the center of the city.', 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=800&q=80', 120.00, 440.00, 4.5, 5600, 'Budget', 'WiFi, Pool, Gym, Laundry, Self-parking');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` int(2) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Confirmed','Cancelled','Pending') DEFAULT 'Confirmed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `hotel_id` (`hotel_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
