<?php
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getDB();

    $hotel_id = (int) $_POST['hotel_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $guests = (int) $_POST['guests'];
    $price_per_night = (float) $_POST['price_usd'];

    // Calculate days
    $diff = strtotime($check_out) - strtotime($check_in);
    $days = max(1, round($diff / (60 * 60 * 24)));
    $total_price = $price_per_night * $days;

    // Simulate User Login if not logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    if ($user_id == 0) {
        // Create a guest user or use a fixed one for demo
        $conn->query("INSERT INTO users (name, email, password) VALUES ('Guest User', 'guest@example.com', 'password123') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)");
        $user_id = $conn->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = 'Guest User';
    }

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, hotel_id, check_in, check_out, guests, total_price, status) VALUES (?, ?, ?, ?, ?, ?, 'Confirmed')");
    $stmt->bind_param("iissid", $user_id, $hotel_id, $check_in, $check_out, $guests, $total_price);

    if ($stmt->execute()) {
        $booking_id = $conn->insert_id;
        // Redirect to confirmation using JS for smoother experience as requested
        echo "<script>window.location.href = 'confirmation.php?id=$booking_id';</script>";
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: index.php");
}
?>
