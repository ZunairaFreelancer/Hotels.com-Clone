<?php
require_once 'db_config.php';

$conn = getDB();

// Create Users Table
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create Hotels Table
$sql_hotels = "CREATE TABLE IF NOT EXISTS hotels (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    main_image VARCHAR(255),
    price_usd DECIMAL(10, 2) NOT NULL,
    price_aed DECIMAL(10, 2) NOT NULL,
    rating DECIMAL(2, 1) NOT NULL,
    reviews_count INT(11) DEFAULT 0,
    hotel_type ENUM('Luxury', 'Resort', 'Budget', 'Boutique') DEFAULT 'Luxury',
    amenities TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Create Bookings Table
$sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    hotel_id INT(11),
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    guests INT(2) NOT NULL,
    total_price DECIMAL(10, 2),
    status ENUM('Confirmed', 'Cancelled', 'Pending') DEFAULT 'Confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE SET NULL
)";

if ($conn->query($sql_users) && $conn->query($sql_hotels) && $conn->query($sql_bookings)) {
    echo "Tables created successfully.<br>";
} else {
    echo "Error creating tables: " . $conn->error . "<br>";
}

// Seed Initial Data for Hotels
$check_hotels = $conn->query("SELECT COUNT(*) as count FROM hotels");
$row = $check_hotels->fetch_assoc();

if ($row['count'] == 0) {
    // ... (hotels array remains same)
    $hotels = [
        [
            'Atlantis The Royal',
            'Palm Jumeirah, Dubai',
            'Experience the height of luxury at the iconic Atlantis The Royal. Featuring stunning views of the Arabian Sea and world-class amenities.',
            'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=800&q=80',
            1200.00,
            4400.00,
            4.9,
            1240,
            'Luxury',
            'WiFi, Pool, Spa, Breakfast, Gym, Parking'
        ],
        [
            'Burj Al Arab Jumeirah',
            'Umm Suqeim, Dubai',
            'The world\'s only 7-star hotel, offering unparalleled luxury and exceptional service in an architectural masterpiece.',
            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=800&q=80',
            2500.00,
            9182.00,
            5.0,
            850,
            'Luxury',
            'WiFi, Infinity Pool, Private Beach, Spa, Breakfast'
        ],
        [
            'Bab Al Shams Desert Resort',
            'Al Qudra Road, Dubai',
            'A rare jewel that brings together traditional Arabic architecture and modern luxury in the heart of the desert.',
            'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
            450.00,
            1650.00,
            4.7,
            2100,
            'Resort',
            'WiFi, Desert Safari, Pool, Spa, Breakfast'
        ],
        [
            'Address Sky View',
            'Downtown Dubai',
            'Stunning views of the Burj Khalifa and the Dubai Fountains from the heart of Downtown Dubai.',
            'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=800&q=80',
            600.00,
            2200.00,
            4.8,
            3400,
            'Luxury',
            'WiFi, Pool, Sky Deck, Gym, Breakfast'
        ],
        [
            'Rove Downtown',
            'Downtown Dubai',
            'Modern, quirky, and affordable stay for urban explorers in the center of the city.',
            'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=800&q=80',
            120.00,
            440.00,
            4.5,
            5600,
            'Budget',
            'WiFi, Pool, Gym, Laundry, Self-parking'
        ]
    ];

    $stmt = $conn->prepare("INSERT INTO hotels (name, location, description, main_image, price_usd, price_aed, rating, reviews_count, hotel_type, amenities) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($hotels as $hotel) {
        $stmt->bind_param("ssssddisss", $hotel[0], $hotel[1], $hotel[2], $hotel[3], $hotel[4], $hotel[5], $hotel[6], $hotel[7], $hotel[8], $hotel[9]);
        $stmt->execute();
    }
    echo "Hotel seed data inserted successfully.<br>";
}

// Seed Guest User
$sql_user = "INSERT IGNORE INTO users (id, name, email, password, created_at) VALUES (1, 'Guest User', 'guest@example.com', '654321#', '2026-02-03 09:40:00')";
if ($conn->query($sql_user)) {
    echo "Guest User check completed.<br>";
} else {
    echo "Error seeding user: " . $conn->error . "<br>";
}

$conn->close();
?>
